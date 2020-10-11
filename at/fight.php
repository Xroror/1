<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();
$dbname = "at";

//has no real way to trigger more than one fights or raids yet also needs more than CRIT 
//needs names to be fixed and advanced combat logging


$acc_id = $_SESSION["login_id"];
$fight_id = $_POST["fight_id"];
//$fight_id = 1; //change
$act_id = 2; //FIGHT ACTIVITY ID

$conn = new mysqli($servername, $username, $password, $dbname);
	
$sql = "SELECT * FROM `active`, `hero` WHERE active.acc_id = $acc_id AND hero.acc_id = $acc_id ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$end = strtotime($row['end']);
$now = time();
if(($end - $now) > 0){
	die("hero is unavailable");
}elseif ($row['hp_cur'] <= 0) {
	die("hero ded");
}

	
	$sql = "SELECT * FROM fight_list WHERE fight_id = $fight_id"; // change to loc_fight
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
		$hero->curHP = (int)$rowh["hp_cur"];
		$hero->ATmax = (int)$rowh["attack_max"];
		$hero->ATmin = (int)$rowh["attack_min"];
		$hero->AS = (int)$rowh["attack_speed"];
		$hero->XP = (int)$rowh["exp"];
		$hero->xpREW = 0;
		$hero->startHP = $hero->curHP;
		$fight->curHP = (int)$rowf["fight_HP"];
		$fight->ATmax = (int)$rowf["fight_ATmax"];
		$fight->ATmin = (int)$rowf["fight_ATmin"];
		$fight->AS = (int)$rowf["fight_AS"];
		$fightReward = json_decode($rowf["fight_reward"]);
		$fight->xpREW = $fightReward->xp;
		

	$enemies = array();;
	$fight->name = "wolf";
	$fight->CritCh = 10;
	$fight->CritDMG = 100;
	$fight->nextATTACKtime = $fight->AS;

	

/*	$fight2 = new stdClass();
	$fight2->name = "bear";
	$fight2->AS = 2;
	$fight2->ATmin = 20;
	$fight2->ATmax = 25;
	$fight2->CritCh = 10;
	$fight2->CritDMG = 100;
	$fight2->nextATTACKtime = $fight2->AS;
	$fight2->curHP = 2000;
	array_push($enemies, $fight2);*/

	$hero->name = "anyo";
	$hero->CritCh = 20;
	$hero->CritDMG = 60;
	$hero->nextATTACKtime = $hero->AS;
	$xpREW = 0;
	
	$heroHITS = array();
	$fightHITS = array();
	$heroes = array();
	array_push($enemies, $fight);
	array_push($heroes, $hero);

	$sh = sizeof($heroes);
	$se = sizeof($enemies);

	$time = 0;
	$target = new stdClass;
	$iterations = 0;

	while($time < 3000 && sizeof($enemies)>0 && sizeof($heroes)>0){ //3000 MAIN COMBAT LOOP
		$iterations++;
		$time = round($time + 0.02, 2);
		foreach($enemies as $e){ // ENEMIES LOOP
			if($e->nextATTACKtime <= $time){

				if(isset($tank)){
					$target = $tank;
					echo "bad";
				}else{
					$target = $heroes[mt_rand(0, ($sh-1))];
					
				}
				
				$e->nextATTACKtime += $e->AS;
				$r = hit($e);
				$target->curHP -= $r->damage;
				//echo $e->name . " hit ". $target->name . " time:" . $time . " HP left = " . $target->curHP . "<br>";
				if($target->curHP <= 0){
					$target->curHP = 0;
					//echo "</br> HERO DED </br>";
					$r->KillingBlow = true;
					unset($heroes[array_search($target, $heroes)]);
					$heroes = array_values($heroes);
					$sh = sizeof($heroes);
				}else{
					$r->KillingBlow = false;
				}
				array_push($fightHITS, $r);
				if(sizeof($enemies) < 1 || sizeof($heroes) < 1){
					COMBAT_END();
					break;
				}
			}

			

		}

		foreach ($heroes as $h) { // HEROES LOOP
			if($h->nextATTACKtime <= $time){

				$target = getTarget($enemies);
				$h->nextATTACKtime += $h->AS;
				$r = hit($h);
				$target->curHP -= $r->damage;
				//echo "<i style = 'color:red'>" . $h->name . " hit ". $target->name . " time:" . $time . " HP left = " . $target->curHP . "</i></br>";
				if($target->curHP <= 0){
					$target->curHP = 0;
					//echo $target->name . " DED </br>";
					$r->KillingBlow = true;
					$h->xpREW += $target->xpREW;
					unset($enemies[array_search($target, $enemies)]);
					$enemies = array_values($enemies);
					$se = sizeof($enemies);
				}else{
					$r->KillingBlow = false;
				}
				array_push($heroHITS, $r);
			if(sizeof($enemies) < 1 || sizeof($heroes) < 1){
				COMBAT_END();
				break;
			}

			}

			
		}


	}


	
	
	//echo "</br>Combat took: " . $time;
	//echo "</br>iterations: " . $iterations;
	//var_dump($fightHITS);
	//echo "<br>";
	//var_dump($heroHITS);
}

	function COMBAT_END(){
		global $time, $hero, $fight, $acc_id, $act_id, $conn, $enemies, $heroes;
		if(sizeof($enemies) > 0 && sizeof($heroes) == 0){
			$herowin = 0;
			echo "hero loss";
		}else if (sizeof($heroes) > 0 && sizeof($enemies) == 0){
			$herowin = 1;
			echo "hero win";
		}
		//echo "COMBAT ENDED";
		$start = date("Y-m-d H-i-s");
		$end = date("Y-m-d H-i-s", strtotime("+$time seconds"));
		$changes = new stdClass();
		$changes->hp = 0-($hero->startHP - $hero->curHP);
		$changes->xp = $hero->xpREW;
		$cR = json_encode($changes);

		$sql = "INSERT INTO `active` (acc_id, act_id, start, end, herowin, changes) VALUES ($acc_id, $act_id, '$start', '$end', $herowin, '$cR');";
		$conn->query($sql);
	}

	function getTarget($tar){
		$target = $tar[mt_rand(0, (sizeof($tar)-1))];
		return $target;
	}

	function hit($s){
			$hit = new stdClass();
			$rawhit = mt_rand($s->ATmin, $s->ATmax);
			$Crit = mt_rand(1, 100);
			if($Crit <= $s->CritCh){ //DID IT CRIT?
				$hit->isCrit = true;
				$hit->damage = round($rawhit * ((100 + $s->CritDMG)/100));

			}else{
				$hit->isCrit = false;
				$hit->damage = round($rawhit);
			}
			return $hit;
		}



	
		

/*		function herohit($s){
			$heroTIMER += $s->AS;
			$hit = new stdClass();
			$hit->time = $heroTIMER;
			$rawhit = mt_rand($s->ATmin, $s->ATmax);
			$Crit = mt_rand(1, 100);
			if($Crit <= $s->CritCh){ //DID IT CRIT?
				$hit->isCrit = true;
				$hit->damage = round($rawhit * ((100 + $s->CritDMG)/100));

			}else{
				$hit->isCrit = false;
				$hit->damage = round($rawhit);
			}
			return $hit;
		}

		function fighthit($s){
			global $fightTIMER;
			$fightTIMER += $s->AS;
			$hit = new stdClass();
			$hit->time = $fightTIMER;
			$rawhit = mt_rand($s->ATmin, $s->ATmax);
			$Crit = mt_rand(1, 100);
			if($Crit <= $s->CritCh){ //DID IT CRIT?
				$hit->isCrit = true;
				$hit->damage = round($rawhit * ((100 + $s->CritDMG)/100));

			}else{
				$hit->isCrit = false;
				$hit->damage = round($rawhit);
			}
			return $hit;
		}

		


		while($heroHP > 0 && $fightHP > 0){
			$GTIMER += 0.2;
			if($GTIMER >= $heroTIMER){
				$h = herohit($hero);
				array_push($heroHITS, $h);
				$fightHP -= $h->damage;
			}
			
			$f = fighthit($fight);
			array_push($fightHITS, $f);
			$heroHP -= $f->damage;
			echo "HP LEFT: " . $fightHP . " - " . $heroHP . "</br>";
		}
		var_dump($heroHITS);
		echo " </br> LOL </br>";
		var_dump($fightHITS);
?>


/*
		fightAS/heroAS 
*/

?>