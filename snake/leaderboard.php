<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="style.css">
</head>

<body>

<?php 
$servername = "localhost";
$dbname = "auch";
$username = "root";
$password = "";
$placenum = 1;

$conn = new mysqli($servername, $username, $password, $dbname);

if($conn->connect_error){
	die("Connection failed: " . $conn->connection_error);
}
$sqlq = "SELECT snakeld.score_value, accounts.acc_name FROM snakeld
 INNER JOIN accounts ON snakeld.acc_id = accounts.acc_id ORDER BY score_value DESC";
$sql = "SELECT acc_id, score_value FROM snakeld ORDER BY score DESC";
$result = $conn->query($sqlq);

if($result->num_rows >  0){
	echo "<table>";
	echo "<tr>";
		echo "<th>Place</th>";
		echo "<th>Name</th>";
		echo "<th>Score</th>";
	echo "</tr>";
	while($row = $result->fetch_assoc()){
		echo "<tr> <td>" . $placenum . "</td> <td>" . $row["acc_name"] . "</td> <td>" . $row["score_value"] . "</td> </tr>";
	$placenum++;
	}
}

?>



</body>
</html>
