<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

$acc_id = $_SESSION['login_id'];
$dbname = "at";
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * FROM loc_list INNER JOIN hero ON loc_list.loc_id = hero.location_id WHERE hero.acc_id = $acc_id;";
$result = $conn->query($sql);

echo '<input placeholder = "minutes" type = "number" id = "gathertime" min = "1" max = "300"></input>';
echo '<button id = "startgather">Gather</button>';
echo '</br>';

while($row = $result->fetch_assoc()){
	echo $row['loc_gather_desc'];
	$potential_loot = json_decode($row['loc_gather']);
	$sql = "SELECT * FROM item_list WHERE item_id IN(";
	$tempi = 0;
	foreach ($potential_loot as $ploot) {
		$tempi++;
		$sql = $sql . $ploot[0];
		if($tempi == sizeof($potential_loot)){
			$sql = $sql . ");";
			break;
		}
		$sql = $sql . ",";
	}
	$result = $conn->query($sql);
	echo '</br>';
	echo "<span>Potential Loot: </span>";
	echo '</br>';
	while($row = $result->fetch_assoc()){
		echo '<img style="width:30px" src="data:image/jpeg;base64,'.base64_encode( $row['item_icon'] ).'"/>';
		echo $row['item_name'];
		echo '</br>';
	}
	
}