<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

$dbname = "at";
$acc_id = $_SESSION["login_id"];
$act_id = 4;

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * FROM `active` INNER JOIN `hero` ON active.acc_id = hero.acc_id WHERE acc_id = $acc_id ORDER BY id DESC LIMIT 1;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$end = strtotime($row['end']);
$now = time();
if(($end - $now) > 0){
	die("hero is unavailable");
//}elseif ($row['hp_cur'] <= 0) {
//	die("hero ded");
}
$sql = "SELECT * FROM `vendor_list` WHERE acc_id = $acc_id ORDER BY id DESC LIMIT 1;";
$result = $conn->query($sql);