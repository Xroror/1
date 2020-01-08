<?php include 'DBACCESS.php';
if(!isset($_SESSION)){session_start();}

if($_POST['username']){
	$dataname = $_POST['username'];
	$datapass = $_POST['passwd'];
	
	$conn = new mysqli($servername, $username, $password, $dbname);
	$sql = "SELECT acc_id, acc_name, acc_pass, acc_nick 
	FROM accounts WHERE acc_name = ?";
	$stmt = $conn->prepare($sql);
	$stmt->bind_param("s", $_POST['username']);
	$stmt->execute();
	$stmt->store_result();
	$stmt->bind_result($id, $name, $password, $nick);
	$stmt->fetch();
	
	if($dataname == $name && $datapass == $password){
		
		$sql = "SELECT 	acc_id, item_id, item_amount 
		FROM inventory WHERE acc_id = ? AND item_id = 1";
		$stm2 = $conn->prepare($sql);
		$stm2->bind_param("i", $id);
		$stm2->execute();
		$stm2->store_result();
		$stm2->bind_result($inv_acc_id, $item_id, $item_amount);
		$stm2->fetch();
		
		
		$_SESSION['login_nick'] = $nick;
		$_SESSION['login_id'] = $id;
		$_SESSION['currency'] = $item_amount;
		
		echo $nick . "&" . $id;
	} else {
		echo "You fucked up";
	}
	
}
?>
