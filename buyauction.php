<?php include 'DBACCESS.php';
session_start();

$loginid = $_SESSION['login_id'];
$goldr = $_SESSION['currency'];
$aucidr = $_POST['id'];
$amountr = $_POST['amount'];

$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT item_amount FROM inventory WHERE acc_id = '" . $loginid . "' AND item_id = 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hasgold);
$stmt->fetch();

$sql = "SELECT auctions.seller_auctions, auctions.price_auctions, auctions.forsale_auctions, item_types.id_item_types
	FROM auctions INNER JOIN item_types ON item_types.name_item_types = auctions.item_name_auctions 
	WHERE id_auctions = '" . $aucidr . "'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($seller_auc, $price_auc, $forsale_auc, $item_id_auc);
$stmt->fetch();
$ncur = $amountr * $price_auc; //needed currency

if($forsale_auc >= $amountr && $hasgold >= $ncur){
$sql = "SELECT item_amount FROM inventory 
WHERE acc_id = '" . $loginid . "' AND item_id = '" . $item_id_auc . "'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($hasamount);
$stmt->fetch();
$sql = "UPDATE auctions SET forsale_auctions = forsale_auctions - '" . $amountr . "'
WHERE id_auctions = '" . $aucidr . "'";
$conn->query($sql);

	if($hasamount === NULL){
		$sql = "INSERT INTO inventory (acc_id, item_id, item_amount)
		VALUES ('$loginid', '$item_id_auc', '$amountr')";
		$conn->query($sql);
	}else if($hasamount >= 0){
		$newamount = $hasamount + $amountr;
		$sql = "UPDATE inventory SET item_amount = '" . $newamount . "' WHERE acc_id = '" . $loginid . 
		"' AND item_id = '" . $item_id_auc . "'";
		if($conn->query($sql) == 1){
			$sql = "SELECT acc_id FROM accounts WHERE acc_nick = '" . $seller_auc . "'";
			$stmt = $conn->prepare($sql);
			$stmt->execute();
			$stmt->store_result();
			$stmt->bind_result($sellerid);
			$stmt->fetch();
			$sql = "UPDATE inventory SET item_amount = item_amount + '" . $ncur . "' 
			WHERE acc_id = '" . $sellerid . "' AND item_id = 1";
			if($conn->query($sql)){
				$sql = "UPDATE inventory SET item_amount = item_amount - '" . $ncur . "'
				WHERE acc_id = '" . $loginid . "' AND item_id = 1";
				if($conn->query($sql)){$_SESSION['currency']=$_SESSION['currency'] - $ncur;}
			}
		}
	}
	
}else{
	echo " NOPE ";
}
?>
