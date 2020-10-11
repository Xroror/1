<?php session_start();
include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
	if(isset($_SESSION['login_id'])){
		$conn = new mysqli($servername, $username, $password, $dbname);
		$sql = 'SELECT acc_chatsession FROM `accounts` WHERE acc_id = ' . $_SESSION['login_id'];
		$result = $conn->query($sql);
		$row = $result->fetch_assoc();
		echo $row['acc_chatsession'];
	}
	?>