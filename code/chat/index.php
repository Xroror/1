<?php
session_start();
?>
<html>
<head>

</head>
<body>

	<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';

	if(isset($_SESSION['login_id'])){
		$tablename = strtolower($_SESSION['login_nick']);
		$conn = new mysqli($servername, $username, $password, $dbname);
		$sql = "SELECT accounts.acc_nick FROM accounts INNER JOIN friends ON friends.friend_id = accounts.acc_id 
		WHERE friends.acc_id = '" . $_SESSION['login_id'] . "'";
		$result = $conn->query($sql);
		while($row = $result->fetch_assoc()){
			$accnick = $row['acc_nick'];
			//$sql = "SELECT * FROM message_db.`$tablename` WHERE sender = '$accnick' OR reciever = '$accnick' ORDER BY id DESC LIMIT 20";
			
			//$resultinner = $conn->query($sql);
				echo "<div class = 'chatdiv' id ='$accnick'</div>";
				echo "<span class = 'openchat'>$accnick</span>";
				
				echo "<div class = 'chathide'>";
				echo "<div class = 'chattext'>";
				/*while($rowin = $resultinner->fetch_assoc()){
					if($rowin['sender'] == $accnick)
					{
						echo "<div class = 'recmes'>" . $rowin['message'] . "</div></br>";
					}else if($rowin['reciever'] == $accnick){
						echo "<div class = 'mymes'>" . $rowin['message'] . "</div></br>";
					}
					
				}*/
				echo "</div>";
				echo "<form id = '$accnick' class = 'typing'>";
				echo "<input class = 'messagebox' type = 'text' placeholder = 'Your message'>";
				echo "<input type = 'submit' value = 'send'>";
				echo "</form>";
				echo "</div>";
				echo "</div>";
				echo "</br>";
			}
	}
	?>
		
			
			
			
			
	

</body>
</html>
