<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

$acc_id = $_SESSION['login_id'];
//check for admin acc?
$target = $_POST['target'];
$dbname = "at";
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * FROM `active` WHERE acc_id = $acc_id ORDER BY id DESC LIMIT 1;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$end = strtotime($row['end']);
$now = time();
if(($end - $now) > 0){
	$sql = "UPDATE active SET end = start WHERE acc_id = $target;";
	$conn->query($sql);
	echo("cheated");
	
}else if (($end-$now) < 0){
	die("hero is already available");
}

