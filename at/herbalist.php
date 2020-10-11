<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

$time = $_POST["healtime"];
if($time>60){$time = 60;}
$dbname = "at";
$acc_id = $_SESSION["login_id"];
$act_id = 3;

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * FROM `active`, `hero` WHERE active.acc_id = $acc_id AND hero.acc_id = $acc_id ORDER BY id DESC LIMIT 1;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$end = strtotime($row['end']);
$now = time();
if(($end - $now) > 0){
	die("hero is unavailable");
}

$hp_cur = $row["hp_cur"];
$hp_max = $row['hp_max'];

$healing = round($hp_max/60*$time);
$newcur = $hp_cur + $healing;
if($newcur > $row["hp_max"]){
	$time = ($hp_max - $hp_cur)/round($hp_max/60);
	echo $time;
	$healing = $row["hp_max"] - $row["hp_cur"];
}
$start = date("Y-m-d H-i-s");
$end = date("Y-m-d H-i-s", strtotime("+$time minutes"));
$cR = new stdClass();
$cR->hp = $healing;
$changes = json_encode($cR);
$sql = "INSERT INTO `active` (acc_id, act_id, start, end, changes) VALUES ($acc_id, $act_id, '$start', '$end', '$changes');";
$conn->query($sql);
echo "max hp:" . $row["hp_max"] . ", before healing:" . $row["hp_cur"] . ", healed:" . $healing . ", took:" . $time . " minutes";


?>