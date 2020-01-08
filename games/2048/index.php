<?php
session_start();
?>
<html>
<head>
<title>2048</title>
<link rel="stylesheet" type="text/css" href="styleGame.css">
<script src = "2048.js"></script>
<script>
var loggedIn = "<?php if(isset($_SESSION["login_nick"])){
						echo $_SESSION["login_nick"];
					}else{
						echo "null";
					}
						?>";
</script>
</head>
<body>
<div>
<?php
	echo "<div id = gameDiv>";
	echo "<table>";
	for($y = 1;$y < 5;$y++){
		echo "<tr>";
		for($x = 1;$x < 5;$x++){
			echo "<td id = '" . $y ."-" . $x . "'>0</td>";
		}
		echo "</tr>";
	}
	echo "</table>";
	echo "</div>";
	?>
	<a id = "scorePlace">0</a>
	
	

<div id = "loginDisplay">
<?php
	if(isset($_SESSION["login_nick"])){
		echo "Logged in as: " . $_SESSION["login_nick"];
	}else{
		echo "You are not logged in.";
	}
?>
</div>
</div>
</body>
</html>
