<?php include 'DBACCESS.php';
session_start();
$invsize = 120;
$accid = $_SESSION['login_id'];
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT item_types.name_item_types, inventory.item_amount, inventory.item_slot, inventory.item_id 
FROM inventory INNER JOIN item_types ON item_types.id_item_types = inventory.item_id WHERE acc_id = '" . $accid . "' AND inventory.item_amount > 0";

$result = $conn->query($sql);

$slotp = array();
while($row = $result->fetch_assoc()){
	if(in_array($row['item_slot'], $slotp)){
		for($i = 1;$i<$invsize;$i++){
			if(in_array($i, $slotp)){
				//next for iteration
			}else{
				$slotp[] = $i;
				$newslot = $i;
				$sql = "UPDATE inventory SET item_slot = '" . $newslot . "' WHERE acc_id = '" . $accid . 
				"' AND item_id = '" . $row['item_id'] . "'";
				$conn->query($sql);
				continue 2;
			}
		}
	}
	$slotp[] = $row['item_slot'];
}


$sql = "SELECT item_types.name_item_types, inventory.item_amount, inventory.item_slot, inventory.item_id 
FROM inventory INNER JOIN item_types ON item_types.id_item_types = inventory.item_id WHERE acc_id = '" . $accid . "' AND inventory.item_amount > 0";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
echo $row['name_item_types'] . "&" . $row['item_amount'] . "&" . $row['item_slot'] . "??";
 }	


?>
