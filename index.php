<?php
session_start();
?>

<!DOCTYPE html>
<html>
<head>
<link rel="stylesheet" type="text/css" href="index.css">
<script type="text/javascript" src="index.js"></script>

</head>
<body>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/code/topbar/topbar_html.php' ?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';

$conn = new mysqli($servername, $username, $password, $dbname); 

if ($conn->connect_error){ # check if connection failed
	die("Well shiet... " . $conn->mysqli->connection_error);
}



$sqlselectall = "SELECT * FROM item_types"; #show all from table

$result = $conn->query($sqlselectall);
//include 'includeCHAT.php'; //CAUSES PAGE TO STOP LOADING              ????
echo "<div id = 'tablediv'>";
if($result->num_rows >  0){
	$rownum = 1;
	echo "<table>";
	echo "<tr>";
	echo "<th>item_id</th>";
	echo "<th>item_name</th>";
	echo "<th>vendor_sell</th></tr>";
	while($row = $result->fetch_assoc()){
		echo '<tr class = "unselectedrow" > <td>' . $row["id_item_types"] . '</td> <td>' . $row["name_item_types"] . '</td> <td>' . $row["vendorpr_item_types"] . '</td> </tr>';
	}
	echo "</table>";
	}
	
	

?>


<div id = "selectbutton">
<form action="buybutton.php" method="get">
	<input id="browserow" type="hidden" name="b" value="">
	<input type="submit" id = "buybut" value="Browse item" ></input>
</form>
</div>
</div>



<div id = "chat">
	<div id = "recievedchat">
		
	</div>
	<form id = "chatform" method = "POST" onsubmit = "return false">
		<input type = "text" id = "sendtext">
		<input id = "sendbut" type = "submit" value = "send">
	</form>
</div>


</body>
</html>