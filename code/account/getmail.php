<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

if(!isset($_SESSION['login_id'])){
	die("You are not logged in");
}

$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "SELECT * FROM mail WHERE mail_reciever_id = " . $_SESSION['login_id'] . ";";
$result = $conn->query($sql);

while($row = $result->fetch_assoc()){
	echo "<span class = 'maildate'>";
	echo $row['mail_senddate'];
	echo "</span></br>";//<i id = 'delmail' class='material-icons'>delete</i></br>";
	echo "<p class = mailhead>";
	echo $row['mail_header'];
	echo "</p>";
}
?>