<?php
echo "<div id = 'friendslist'>";
	if(isset($_SESSION['login_id'])){
		echo "Friends";
		echo "<ul>";
			$sql = "SELECT accounts.acc_nick FROM accounts INNER JOIN friends ON friends.friend_id = accounts.acc_id 
			WHERE friends.acc_id = '" . $_SESSION['login_id'] . "'";
			$result = $conn->query($sql);
			while($row = $result->fetch_assoc()){
				echo "<li class = 'fr'>";
				echo $row['acc_nick'];
				echo "</li>";
			}
		echo "</ul>";
	}
echo "</div>";
?>