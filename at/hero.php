<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();
	$dbname = "at";
	$acc_id = $_SESSION["login_id"];
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT * FROM `hero` INNER JOIN `loc_list` ON hero.location_id = loc_list.loc_id WHERE acc_id = $acc_id;";
	$result = $conn->query($sql);
	if($result->num_rows >  0){
		$row = $result->fetch_assoc();
		$sendObj = new stdClass();
		$sendObj->expp = $row['exp'];
		$sendObj->gold = $row['gold'];
		$sendObj->hp_max = $row['hp_max'];
		$sendObj->hp_cur = $row['hp_cur'];
		$sendObj->location = $row['loc_name'];
		$JSON = json_encode($sendObj);
		echo $JSON;
	}else{
		$sql = "INSERT INTO `hero` (acc_id, exp, gold, hp_max, hp_cur, attack_speed, attack_max, attack_dps, location_id) VALUES ($acc_id, 0, 0, 100, 100, 1, 1, 1, 1);";
		$conn->query($sql);
		$sendObj = new stdClass();
		$sendObj->expp = 0;
		$sendObj->gold = 0;
		$sendObj->hp_max = 100;
		$sendObj->hp_cur = 100;
		$sendObj->location = 1;
		$JSON = json_encode($sendObj);
		echo $JSON;
	}


?>