<?php  if(!isset($_SESSION)){session_start();} ?>
<html>
<link rel="stylesheet" type="text/css" href="index.css">
<script>
window.onload = function(){
	var tabr = document.getElementsByTagName("tr");
	
	for(var i = 1;i < tabr.length; i++){
		tabr[i].addEventListener("click", selectrow);
	}
}

function selectrow(){
	var selrow = document.getElementsByClassName("selectedrow");
	for(var i = 0; i < selrow.length; i++){
		selrow[i].className = "unselectedrow";
	}
	this.className = "selectedrow";
}
function buyrequest(){

	var itemamount = document.getElementById("selectedamount").value;
	var aucid = document.getElementById("aucid").innerText;
	var datatosend = "amount="+itemamount+"&id="+aucid;
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log(this.responseText);
		}
	};
	xhttp.open("POST", "/buyauction.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	xhttp.send(datatosend);
}


</script>
<body>
<?php include 'DBACCESS.php';

echo "TIME " . date("H:i:s");

$conn = new mysqli($servername, $username, $password, $dbname); # establish a connection

if ($conn->connect_error){ # check if connection failed
	die("Well shiet... " . $conn->mysqli->connection_error);
}

$buy = $_GET['b'];


$sqlaucsel = "SELECT * FROM auctions WHERE item_name_auctions='" . $buy . "' 
AND TO_SECONDS(now()) - auctions.duration_auctions < TO_SECONDS(auctions.postedon_auctions) 
AND forsale_auctions > 0 AND NOT seller_auctions = '" . $_SESSION['login_nick'] . "'";

$result = $conn->query($sqlaucsel);
if(!$result){echo $conn->error;}
if($result->num_rows >  0){
	$rownum = 1;
	echo "<table>";
	echo "<tr>";
	echo "<th>Item</th>";
	echo "<th>Available</th>";
	echo "<th>Price</th>";
	echo "<th>Seller</th></tr>";
	while($row = $result->fetch_assoc()){
		//if($row['postedon_auctions']
		echo '<tr class = "unselectedrow" > <td> <span id = "aucid">' . $row["id_auctions"] . '</span>' .
		$row["item_name_auctions"] . '</td> <td>' . $row["forsale_auctions"] . '</td> <td>' .
		$row["price_auctions"] .'</td><td>' . $row["seller_auctions"] . '</td><td>' .
		$row["postedon_auctions"] . '</td> </tr>';
	}
	echo "</table>";
	}else if($result->num_rows == 0){
		echo "</br> NO AUCTIONS";
	}
	

?>

<form onsubmit = buyrequest() method = "POST"> 
	<input type = "text" id = "selectedamount" placeholder = "amount">
	<input type = "hidden" id = "selecteditem" value = "">
	<input type = "hidden" id = "selectedseller" value = "">
	<input type = "hidden" id = "selectedprice" value = "">
	<input type = "submit" value = "Buy!">
</form>

 <div class = "loginform">
 <?php
	echo "Logged in as: " . $_SESSION['login_nick'] . "</br>";
	echo $_SESSION['currency'] . "</span> Gold";
?>
</div>
</body>
</html>