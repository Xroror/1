<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

$acc_id = $_SESSION['login_id'];

$dbname = "at";
$conn = new mysqli($servername, $username, $password, $dbname);

$gather_dur = $_POST['gather_dur'];
$bonus_dropch = 0;
$act_id = 5;

$sql = "SELECT loc_gather FROM loc_list INNER JOIN hero ON loc_list.loc_id = hero.location_id WHERE acc_id = $acc_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$POSSIBLEgather = json_decode($row['loc_gather']);
$reward = array();

	foreach ($POSSIBLEgather as $gr) {
		$lootedLOOT = array();
		$lootedNUMB = 0;
		for($i=0;$i<$gather_dur;$i++){
			$drop_chance = $gr[1] + $bonus_dropch;
			if(mt_rand(0, 100)<= $drop_chance){
				$lootedNUMB++;
		}
		$lootedLOOT[0] = $gr[0]; //store the looted item id
		$lootedLOOT[1] = $lootedNUMB; // store the number of looted items
	}
	array_push($reward, $lootedLOOT); // place loot into array
}
$lootOBJ = new stdClass(); // object needed later for placing items into place inventory - checkACT.php//
$lootOBJ->grantITEMS = $reward;
$changes = json_encode($lootOBJ);

$start = date("Y-m-d H-i-s");
$end = date("Y-m-d H-i-s", strtotime("+$gather_dur minutes"));
$sql = "INSERT INTO `active` (acc_id, act_id, start, end, changes) VALUES ($acc_id, $act_id, '$start', '$end', '$changes');";
$conn->query($sql);



?>