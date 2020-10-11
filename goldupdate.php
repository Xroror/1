<?php include 'DBACCESS.php';
session_start();
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT item_amount FROM inventory WHERE acc_id = '" . $login . "' AND item_id = 1";
$stmt = $conn->prepare($sql);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($gold);
$stmt->fetch();
$_SESSION['currency'] = $gold;

?>