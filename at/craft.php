<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

$acc_id = $_SESSION['login_id'];

$dbname = "at";
$conn = new mysqli($servername, $username, $password, $dbname);

$craft_id = $_POST['craft_id'];
$items_to_craft = $_POST['craft_num'];
$act_id = 6;



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
$sql = "SELECT * FROM craft_list WHERE craft_id = $craft_id";
$resultc = $conn->query($sql);
$rowc = $resultc->fetch_assoc();
$craft_dur = $rowc['craft_time'] * $items_to_craft;
$req_have = 0;//?

$remove = array();
$hero_inventory = array();

$mats_per_craft = json_decode($rowc['craft_mats']);
$sql = "SELECT * FROM hero_inventory WHERE acc_id = $acc_id";//AND item_id = $mpc[0]"; //reduce returned result by requesting only materials and not whole inventory(inner join item_list???)
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){ //GET 2D ARRAY WITH HERO INVENTORY
	$items_in_inventory = array();
	array_push($items_in_inventory, $row['item_id'], $row['item_quantity']);
	$hero_inventory[] = $items_in_inventory;
}
foreach ($mats_per_craft as $mpc) {
	$mpc[1] = $mpc[1]*$items_to_craft;
	foreach ($hero_inventory as $hi) {
		if($hi[0] == $mpc[0] && $hi[1] >= $mpc[1]){
			//echo "HAS ENOUGH " . $mpc[0];
			array_push($remove, $mpc);
			$req_have++; // material found
		}
	}
}
if($req_have <	sizeof($mats_per_craft)){
	die("NOT ENOUGH MATS");
}else{
	$crafted = array();
	$reward = array();
	$craft_result = json_decode($rowc['craft_result']);
	foreach ($craft_result as $cr) {
		$crafted[0]=$cr[0];
		$crafted[1]=$cr[1]*$items_to_craft;
		array_push($reward, $crafted);
	}
	$lootOBJ = new stdClass();
	$lootOBJ->grantITEMS = $reward;
	$lootOBJ->removeITEMS = $remove;
	$changes = json_encode($lootOBJ);

	$start = date("Y-m-d H-i-s");
	$end = date("Y-m-d H-i-s", strtotime("+$craft_dur seconds"));
	$sql = "INSERT INTO `active` (acc_id, act_id, start, end, changes) VALUES ($acc_id, $act_id, '$start', '$end', '$changes');";
	$conn->query($sql);
}
