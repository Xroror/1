<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();
$dbname = "at";
$acc_id = $_SESSION["login_id"];


$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * FROM `active` INNER JOIN `activity_list` ON active.act_id = activity_list.act_id  WHERE acc_id = $acc_id ORDER BY id DESC LIMIT 1;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$end = strtotime($row['end']);
$now = time();
$sendObj = new stdClass();
$sendObj->timeLeft = $end - $now;

$sendObj->activity = $row['act_name'];
$JSON = json_encode($sendObj);
if($sendObj->timeLeft <= 0 && $row["changes_claimed"] == 0){
	$newHP = 0;
	$newXP = 0;
	$changes = json_decode($row["changes"]);
	if(isset($changes->hp)){$newHP = $changes->hp;}
	if(isset($changes->xp)){$newXP = $changes->xp;}
	if(isset($changes->removeITEMS)){removeitems($changes->removeITEMS);}
	if(isset($changes->grantITEMS)){additemreward($changes->grantITEMS);}
	$sql = "UPDATE `active` SET changes_claimed = 1 WHERE acc_id = $acc_id ORDER BY id DESC LIMIT 1;";
	$conn->query($sql);
	$sql = "UPDATE `hero` SET hp_cur = hp_cur + $newHP, exp = exp + $newXP WHERE acc_id = $acc_id;";
	$conn->query($sql);
	echo $JSON;
	//rewards
}else{
	echo $JSON;
	//not yet
	}

function removeitems($arr){
	global $conn, $acc_id;
	foreach ($arr as $ar) {
		$sql = "UPDATE hero_inventory SET item_quantity = item_quantity - $ar[1] WHERE acc_id = $acc_id AND item_id = $ar[0]";
		$conn->query($sql);
	}
	
}

 function additemreward($arr){
 	global $conn, $acc_id; 
	foreach($arr as $ar){
		$sql = "INSERT INTO hero_inventory (acc_id, item_id, item_quantity) VALUES ($acc_id, $ar[0], $ar[1]) ON DUPLICATE KEY UPDATE item_quantity = item_quantity+$ar[1];";
		$conn->query($sql);
	}
 }


?>
