<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

$dbname = "at";
//$acc_id = $_SESSION["login_id"];


$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * FROM `item_list`;";
$result = $conn->query($sql);
while($row = $result->fetch_assoc()){
	echo $row['item_id'] ;
	echo '<img style="width:30px" src="data:image/jpeg;base64,'.base64_encode( $row['item_icon'] ).'"/>';
	echo $row['item_name'];
	echo "</br>";
}

?>