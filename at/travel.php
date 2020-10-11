<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

$end_point = $_POST["end_point"];
$dbname = "at";
$acc_id = $_SESSION["login_id"];
$act_id = 4;

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * FROM `active`, `hero` WHERE active.acc_id = $acc_id AND hero.acc_id = $acc_id ORDER BY id DESC LIMIT 1;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$end = strtotime($row['end']);
$now = time();
if(($end - $now) > 0){
	die("hero is unavailable");
}elseif ($row['hp_cur'] <= 0) {
	die("hero ded");
}


$sql = "SELECT location_id FROM `hero` WHERE acc_id = $acc_id;";
$result = $conn->query($sql);
$rowh = $result->fetch_assoc();
$cur_loc = $rowh['location_id'];
if($end_point == $cur_loc){die("you are already here");}
$sql = "SELECT * FROM `travel_list` WHERE start_pos = $cur_loc AND end_pos = $end_point;";
$result = $conn->query($sql);
if($result->num_rows >  0){
	$row = $result->fetch_assoc();
	$time = $row['time'];
	$start = date("Y-m-d H-i-s");
	$end = date("Y-m-d H-i-s", strtotime("+$time seconds"));
	$sql = "INSERT INTO `active` (acc_id, act_id, start, end) VALUES ($acc_id, $act_id, '$start', '$end');";
	$conn->query($sql);
	$sql = "UPDATE `hero` SET location_id = $end_point WHERE acc_id = $acc_id";
	$conn->query($sql);
	echo "traveling from $cur_loc towards $end_point, will take $time seconds.";
}else{
	die("you cannot travel to there from here");
}
?>