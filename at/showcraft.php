<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

$acc_id = $_SESSION['login_id'];
//check for admin acc?

$dbname = "at";
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * FROM item_list WHERE item_ismaterial = 1 OR item_iscrafted = 1;";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	$items[] = $row;
}


$sql = "SELECT * FROM `craft_list`;";
$result = $conn->query($sql);


echo '<input type = "number" id = "craftnum" min = "1" max = "10"></input>';
echo '<button type = "button" id = "begincraft">Craft</button>';
echo '</br>';


while($row = $result->fetch_assoc()){
	$craft_id = $row['craft_id'];
	$craftmats = json_decode($row['craft_mats']);
	$craftresults = json_decode($row['craft_result']);
	echo '<button type = "button" class = "collapse">';
	foreach ($craftresults as $r) {
		$item = array_search($r[0], array_column($items, 'item_id'));
		echo '<img style="width:30px" src="data:image/jpeg;base64,'.base64_encode( $items[$item]['item_icon'] ).'"/>';
		echo $items[$item]['item_name'];
		echo ' x ';
		echo '<span class = "matquantity">' . $r[1] . '</span>';
		echo '<span class = "matquantityhide">' . $r[1] . '</span>';
	}
	echo '</button>';
	echo '<div id = '.$craft_id.' class = "collapseCont">';
	foreach ($craftmats as $m) {
		$item = array_search($m[0], array_column($items, 'item_id'));
		echo '<img style="width:30px" src="data:image/jpeg;base64,'.base64_encode( $items[$item]['item_icon'] ).'"/>';
		echo $items[$item]['item_name'];
		echo ' x ';
		echo '<span class = "matquantity">' . $m[1] . '</span>';
		echo '<span class = "matquantityhide">' . $m[1] . '</span>';
	}
	echo '</div></br>';
	
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


*/	

?>

