<?php include $_SERVER['DOCUMENT_ROOT']."/DBACCESS.php";
	$req = $_GET["req"];
	$dbname = "wowah";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT * FROM record ORDER BY id DESC LIMIT 1;";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$tab_name = $row['tab_name'];
	$sql = "SELECT * FROM `" . $tab_name . "` WHERE `item_name` = \"" . $req . "\";";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	echo "<table id = 'tptable'>";
	echo "<td>Vendor Price: </td><td>" . gold($row["item_vendorsell"]) . "</td>"; 
	echo "</table>";
	
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