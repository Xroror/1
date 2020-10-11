<?php session_start();
if(!isset($_SESSION['login_id'])){
	die("You must login to see your shopping list");
}
include $_SERVER['DOCUMENT_ROOT'] . "/DBACCESS.php";
$conn = new mysqli($servername, $username, $password);
$sql = "SELECT * FROM wowah.record ORDER BY id DESC LIMIT 1;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$tn = "`wowah`.`" . $row['tab_name'];

$sql = "SELECT `auch`.`ahinterests`.`acc_id`, `auch`.`ahinterests`.`item_name`, " . $tn . "`.`item_minbuyout`, 
		" . $tn . "`.`item_regminbuyavg`, " .$tn . "`.`item_regavgdailysold`
		FROM " . $tn . "` INNER JOIN  `auch`.`ahinterests` ON `auch`.`ahinterests`.`item_name` = " . $tn . "`.`item_name`
		WHERE `acc_id` = '" . $_SESSION['login_id'] . "'";


if($result = $conn->query($sql)){
	#echo "<button id = 'expandall'></button>";
	#echo "</br>";

	while ($row = $result->fetch_assoc()){
	
		echo "<p class = 'interestname'>" . $row['item_name'] . "</p>";
		echo "</br>";
		echo "<p class = 'interestinfo'>BO:" . gold($row['item_minbuyout']). " rBOavg: " .gold($row['item_regminbuyavg']) . "</p>";
		echo "</br>";
	
	}
}

function gold($s){
		if(strlen($s) >= 5){
			$copper = substr($s, -2);
			$silver = substr($s, -4, 2);
			$gold = substr($s, 0, -4);
		}else if (strlen($s) == 4){
			$copper = substr($s, -2);
			$silver = substr($s, -4, 2);
			$gold = "0";
		}else if (strlen($s) == 3){
			$copper = substr($s, -2);
			$silver = "0" . substr($s, -4, 1);
			$gold = "0";
		}else if (strlen($s) == 2){
			$copper = substr($s, -2);
			$silver = "00";
			$gold = "0";
		}else{
			$copper = "0" . substr($s, -2);
			$silver = "00";
			$gold = "0";
		}
		$currency = "<td><span class = 'cost_g'>" . $gold . "g</span><span class = 'cost_s'>" . 
		$silver . "s</span><span class = 'cost_c'>" . $copper . "c</span></td>";
		return $currency;
	}

?>