<?php include 'DBACCESS.php';
if($_POST['username']){
	$user = $_POST['username'];
	$pass = $_POST['passwd'];
	$nick = $_POST['nick'];
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "INSERT INTO accounts (acc_name, acc_pass, acc_nick)
	VALUES ('$user', '$pass', '$nick')";
	$conn->query($sql);
	$sql = "SELECT acc_id FROM accounts WHERE acc_name = '" . $_POST['username'] . "'";
	$result = $conn->query($sql);
	$row = $result->fetch_assoc();
	$accid = $row['acc_id'];
	echo $accid;
	$sql = "INSERT INTO inventory (acc_id, item_id, item_amount)
	VALUES ('$accid', 1 , 1)";
	$conn->query($sql);
	echo "complete";
	
}


?>
