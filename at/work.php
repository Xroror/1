<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

$acc_id = $_SESSION['login_id'];

$dbname = "at";
$conn = new mysqli($servername, $username, $password, $dbname);

$craft_id = $_POST['craft_id'];
$items_to_craft = $_POST['craft_num'];
$act_id = 7;
$work_id = 1;


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
$work_time = json_decode($row['work_time']);
$work_promo = json_decode($row['work_promo']);
$sql = "SELECT * FROM work_list WHERE work_id = $work_id";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	
}