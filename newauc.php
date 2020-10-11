<?php include 'DBACCESS.php';
if(!isset($_SESSION)){session_start();}

$posterid = $_SESSION['login_id'];
$poster = $_SESSION['login_nick'];
$item = $_POST['item'];
$price = $_POST['price'];
$durr = $_POST['long'] * 86400;
$amount = $_POST['amount'];


$conn = new mysqli($servername, $user, $password, $dbname);
$sql = "SELECT id_item_types, name_item_types FROM item_types WHERE name_item_types = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $item);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($itemid, $itemname);
$stmt->fetch();

$sql = "SELECT item_types.name_item_types, inventory.item_amount 
FROM inventory INNER JOIN item_types ON item_types.id_item_types = inventory.item_id 
WHERE acc_id ='" . $posterid . "' AND inventory.item_id = '" . $itemid . "'";

$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($itemavailable, $amountavailable);
$stmt->fetch();


if($amount <= $amountavailable){

$postedon = date("Y-m-d H-i-s");

$sql = "INSERT INTO auctions (item_name_auctions, seller_auctions, price_auctions, duration_auctions, postedon_auctions, forsale_auctions)
VALUES ('$itemname', '$poster', '$price', '$durr',  '$postedon', '$amount')";

$success = $conn->query($sql);
if($success){
	$remains = $amountavailable - $amount;
	$sql = "UPDATE inventory SET item_amount ='" . $remains . "' 
	WHERE acc_id ='" . $posterid . "' AND item_id ='" . $itemid . "'";
	echo $conn->query($sql);
}
}

?>