<?php 
include $_SERVER['DOCUMENT_ROOT'] . "/DBACCESS.php";
session_start();
$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "DELETE FROM `ahinterests` WHERE `acc_id` = '" . $_SESSION['login_id'] . "'
 AND `item_name` = '" . $_POST['item_name'] . "';";
$conn->query($sql);

?>