<?php
session_start();

$score = $_POST["score"];
$id = $_SESSION["login_id"];

$servername = "localhost";
$dbname = "auch";
$username = "root";
$password = "";

$conn = new mysqli($servername, $username, $password, $dbname); # establish a connection
if($conn->connect_error){
	die("Connection failed: " . $conn->connection_error);
}
$sqlq = "SELECT score_value FROM snakeld WHERE acc_id = '$id'";
$result = $conn->query($sqlq);
if($result->num_rows > 0){
	$row = $result->fetch_assoc();
	if ($score > $row['score_value']){
		$sqlq = "INSERT INTO snakeld (acc_id, score_value) VALUES ('$id', '$score')
		ON DUPLICATE KEY UPDATE score_value = $score";
		$result = $conn->query($sqlq);
	}else if ($score < $row['score_value']){
		
	}
}else if($result->num_rows == 0){
	$sqlq = "INSERT INTO snakeld (acc_id, score_value) VALUES ('$id', '$score')";
		$result = $conn->query($sqlq);
	}
	

var_dump($result);
?>


