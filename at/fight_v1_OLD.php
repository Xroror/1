<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();
$dbname = "at";
$acc_id = $_SESSION["login_id"];
$fight_id = 2;//$_POST["fight_id"];
$act_id = 2; //FIGHT ACTIVITY ID

$conn = new mysqli($servername, $username, $password, $dbname);
	
$sql = "SELECT * FROM `active` WHERE acc_id = $acc_id ORDER BY id DESC LIMIT 1;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$end = strtotime($row['end']);
$now = time();
if(($end - $now) > 0){
	die("hero is unavailable");
}
	
	$sql = "SELECT * FROM fight_list WHERE fight_id = $fight_id";
	$conn->query($sql);
	$resultFight = $conn->query($sql);
	$sql = "SELECT * FROM hero WHERE acc_id = $acc_id";
	$conn->query($sql);
	$resultHero = $conn->query($sql);
	if($resultFight->num_rows >  0 && $resultHero->num_rows > 0){
		$rowf = $resultFight->fetch_assoc();
		$rowh = $resultHero->fetch_assoc();
		$hero = new stdClass();
		$fight = new stdClass();
		$hero->HP = (int)$rowh["hp_cur"];
		$hero->ATmax = (int)$rowh["attack_max"];
		$hero->ATmin = (int)$rowh["attack_dps"];
		$hero->AS = (int)$rowh["attack_speed"];
		$hero->XP = (int)$rowh["exp"];
		$fight->HP = (int)$rowf["fight_HP"];
		$fight->DPS = (int)$rowf["fight_DPS"];
		$fight->AT = (int)$rowf["fight_AT"];
		$fight->AS = (int)$rowf["fight_AS"];
		$fight->Reward = json_decode($rowf["fight_reward"]);
		var_dump($fight->Reward);
		$herowin = 0;
		// first hit
		if($heroAS < $fightAS){
			$fightHP -= $heroAT;
		}else if ($heroAS == $fightAS){
			$fightHP -= $heroAT;
			$heroHP -= $fightAT;
		}else{
			$heroHP -= $fightAT;
		}
//here 
		function hit($s){
			$rawhit = mt_rand($hero->ATmin, $hero->ATmax);
			$Crit = mt_rand(1, 100);
			if($Crit >= $hero->CritCh){ //DID IT CRIT?
				$isCrit = true;
				$damage = $rawhit * $hero->CritDMG;

			}else{
				$isCrit = false;
			}
		}

		


		while($heroHP > 0 && $fightHP > 0){
			$fightHITS = new array();
			$heroHITS = new array();
			array_push($fightHITS, var)
		}

//here end
		$heroTTK = $fightHP / $heroDPS;
		$fightTTK = $heroHP / $fightDPS;

		if($heroTTK < $fightTTK){ 
			$TTK = $heroTTK;
			$xpREW = $fightReward->xp;
			$herowin = 1;
			$fightHP = 0;
			$heroHP = $heroTTK * $fightDPS;
		}else if ($heroTTK == $fightTTK){
			$TTK = $heroTTK;
			$xpREW = round(($fightReward->xp)/10);
			$fightHP = 0;
			$herowin = 0;
			##rip
		}else{
			$TTK = $fightTTK;
			$xpREW = 0;
			$herowin = 0;
			$fightHP -= $fightTTK * $heroDPS;
		}
		$TTK = floor($TTK);
		$start = date("Y-m-d H-i-s");
		$end = date("Y-m-d H-i-s", strtotime("+$TTK seconds"));
		$changes = new stdClass();
		$changes->hp = 0-$heroHP;
		$changes->xp = $xpREW;
		$cR = json_encode($changes);

		$sql = "INSERT INTO `active` (acc_id, act_id, start, end, herowin, changes) VALUES ($acc_id, $act_id, '$start', '$end', $herowin, '$cR');";
		$conn->query($sql);
	
	}else{
		die("no such fight id");
	}


?>