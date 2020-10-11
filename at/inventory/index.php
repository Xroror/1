<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

$acc_id = $_SESSION['login_id'];

$dbname = "at";
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * FROM `hero_inventory` INNER JOIN item_list ON hero_inventory.item_id = item_list.item_id WHERE acc_id = $acc_id AND item_quantity > 0";

$result = $conn->query($sql);
$bagsize = 30;
$bagwidth = 5;
echo "<table>";
while($row = $result->fetch_assoc()){
	echo "<td>";
	echo '<img draggable = "true" style="width:25px" src="data:image/jpeg;base64,'.base64_encode( $row['item_icon'] ).'"/>';
	echo "</td>";
	echo "<td>" . $row["item_name"] . "</td>";
	echo "<td>" . $row["item_quantity"] . "</td>";
	echo "</tr>";
	//echo "<td dreaggable = 'false'> <img style='width:25px' src='data:image/jpeg;base64," . base64_encode($row['item_icon']) . "/></td>";
	//if($i%$bagwidth == 0){
	//	echo "</tr><tr>";
	//}
	
}

echo "</table>";


?>
<head>
	<link rel="stylesheet" type="text/css" href="index.css">
	<script type="text/javascript" src="index.js"></script>
</head>

