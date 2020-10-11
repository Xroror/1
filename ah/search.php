<?php include $_SERVER['DOCUMENT_ROOT']."/DBACCESS.php";
	#$req = "dust";
	$req = $_GET["req"];
	$dbname = "wowah";
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT * FROM record ORDER BY id DESC LIMIT 1;";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$tab_name = $row['tab_name'];
	echo "Last Updated: " . (mktime()-$row['created_on']) . "seconds.";
	$sql = "SELECT * FROM `" . $tab_name . "` WHERE `item_name` LIKE '%" . $req . "%' LIMIT 20;";
	$result = $conn->query($sql);
	echo "<table>";
	
	while($row = $result->fetch_assoc()){
		if(strlen($row["item_minbuyout"]) >= 5){
			#echo substr($row["item_minbuyout"], -4, 2);

			$copper = substr($row["item_minbuyout"], -2);
			$silver = substr($row["item_minbuyout"], -4, 2);
			$gold = substr($row["item_minbuyout"], 0, -4);
		}else if (strlen($row["item_minbuyout"]) == 4){
			$copper = substr($row["item_minbuyout"], -2);
			$silver = substr($row["item_minbuyout"], -4, 2);
			$gold = "0";
		}else if (strlen($row["item_minbuyout"]) == 3){
			$copper = substr($row["item_minbuyout"], -2);
			$silver = "0" . substr($row["item_minbuyout"], -4, 1);
			$gold = "0";
		}else if (strlen($row["item_minbuyout"]) == 2){
			$copper = substr($row["item_minbuyout"], -2);
			$silver = "00";
			$gold = "0";
		}else{
			$copper = "0" . substr($row["item_minbuyout"], -2);
			$silver = "00";
			$gold = "0";
		}
		echo "<tr>";
		echo "<td class = 'itemlist'>" . $row["item_name"] ."</td> <td><span class = 'cost_g'>" . $gold . "g</span><span class = 'cost_s'>" . 
		$silver . "s</span><span class = 'cost_c'>" . $copper . "c</span></td>";
		echo "</tr>";
	}
	echo "</table>";
?>