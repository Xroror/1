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

<?php
	echo "<div id = 'gameDiv'>";
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
	

$servername = "localhost";
$dbname = "auch";
$username = "root";
$password = "";
$placenum = 1;

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
	die("Connection failed: " . $conn->connection_error);
}
$sqlq = "SELECT 2048ld.score_value, accounts.acc_nick FROM 2048ld
 INNER JOIN accounts ON 2048ld.acc_id = accounts.acc_id ORDER BY score_value DESC";
$sql = "SELECT acc_id, score_value FROM 2048ld ORDER BY score DESC";
$result = $conn->query($sqlq);

if($result->num_rows >  0){
	echo "<div id = 'LDdiv'>";
	echo "<table>";
	echo "<tr>";
		echo "<th>Place</th>";
		echo "<th>Name</th>";
		echo "<th>Score</th>";
	echo "</tr>";
	while($row = $result->fetch_assoc()){
		echo "<tr> <td>" . $placenum . "</td> <td>" . $row["acc_nick"] . "</td> <td>" . $row["score_value"] . "</td> </tr>";
	$placenum++;
	}
}
	echo "</div>";
	?>

</div>
</body>
</html>
