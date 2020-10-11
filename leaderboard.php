<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<?php
$servername = "localhost";
$dbname = "leaderboard1";
$username = "root";
$password = "";
$placenum = 1;

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
	die("Connection failed: " . $conn->connection_error);
}

$sql = "SELECT nick, score FROM topscore ORDER BY score DESC";
$result = $conn->query($sql);

if($result->num_rows >  0){
	echo "<table>";
	echo "<tr>";
		echo "<th>Place</th>";
		echo "<th>Name</th>";
		echo "<th>Score</th>";
	echo "</tr>";
	while($row = $result->fetch_assoc()){
		echo "<tr> <td>" . $placenum . "</td> <td>" . $row["nick"] . "</td> <td>" . $row["score"] . "</td> </tr>";
	$placenum++;
	}
}

?>

</body>
</html>
