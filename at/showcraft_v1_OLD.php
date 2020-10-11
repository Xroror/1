<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

$acc_id = $_SESSION['login_id'];
//check for admin acc?

$dbname = "at";
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * FROM `craft_list`;";
$result1 = $conn->query($sql);

while($row1 = $result1->fetch_assoc()){
	$lookup = [];
	$mats = json_decode($row1['craft_mats']);
	$products = json_decode($row1['craft_result']);
	foreach ($mats as $m) {
		$lookup[] = $m[0];
	}
	foreach ($products as $p) {
		$lookup[] = $p[0];
	}

$sql = "SELECT * FROM `item_list` WHERE item_id IN (";
$ts = "";
for($i = 0;$i<sizeof($lookup);$i++) {
	$ts = $ts . $lookup[$i];
	if($i == (sizeof($lookup)-1)){
		break;
	}
	$ts = $ts . ", ";
}
$sql = $sql . $ts . ");";
$result = $conn->query($sql);

echo "<table>";
echo "<tr>";
while($row = $result->fetch_assoc()){
	echo "<td><img draggable = 'true' style='width:25px' src='data:image/jpeg;base64,".base64_encode( $row['item_icon'] )."'/></td>";
	echo "<td>" . $row['item_name'] . "</td>";


}
}

/*
CREATE TABLE `craft_list` (
  `craft_id` int(11) NOT NULL,
  `craft_mats` longtext,
  `craft_result` longtext,
  `craft_location` int(11) DEFAULT NULL,
  `craft_time` int(11) DEFAULT NULL,
  PRIMARY KEY (`craft_id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COMMENT='mats-array[[itemid][number],[itemid][number]]/// craft_location - location_id or 0 for anywhere';

[{"craft_id":1, "craft_mats":"[[3,2],[4,1],[5,1]]", "craft_result":"[[8,1]]", "craft_location":0, "craft_time":10},
 {"craft_id":2, "craft_mats":"[[8,1],[9,2]]", "craft_result":"[[20,1]]", "craft_location":0, "craft_time":10}]

increases database calls...

*/	

?>

