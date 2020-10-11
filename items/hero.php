<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

$dbname = "at";
$acc_id = $_SESSION["login_id"];

$conn = new mysqli($servername, $username, $password, $dbname);
function checkhero($try){
	if($try>2) return;
	$sql = "SELECT * FROM `hero` WHERE acc_id = $acc_id;";
	if($result = $conn->query($sql)){
		$row = $result->fetch_assoc();
		$sendObj = new stdClass();
		$sendObj->expp = $row['exp'];
		$sendObj->gold = $row['gold'];
		$sendObj->hp_max = $row['hp_max'];
		$sendObj->hp_cur = $row['hp_cur'];
		$JSON = json_encode($sendObj);
		echo $JSON;
	}else{
		$sql = "INSERT INTO `hero` (acc_id, exp, gold, hp_max, hp_cur, attack_speed, attack_max, attack_dps) VALUES ($acc_id, 0, 0, 100, 100, 1, 1, 1);";
		$conn->query($sql);
		checkhero($try);
	}
}
checkhero(1);
?>