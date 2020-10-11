<?php session_start();
include $_SERVER['DOCUMENT_ROOT'] . "/DBACCESS.php";
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "INSERT INTO ahinterests (acc_id,  item_name) VALUES (?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("is", $_SESSION['login_id'], $_POST['item_interest']);
$stmt->execute();

?>