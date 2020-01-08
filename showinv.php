<?php
if(!isset($_SESSION)){session_start();}
?>

<html>
<head>
<script>
var response;
function loadpageJS(){
	var xhttp;									// ajax request for inventory data
	xhttp = new XMLHttpRequest();
	
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log(this.responseText);
			response = this.responseText;
			fillitup();			//fill cells
		}
	};
	xhttp.open("POST", "/fillinv.php", true);
	xhttp.send();
	cellevents();		//addevent listeners for table cells
}

function fillitup(){		//replace empty cells with inventory data
	var inv = response.split("??");
	for(i = 0;i < inv.length - 1; i++){
		item = inv[i].split("&");
		for (j=0;j < item.length;j++){
			console.log(item[j]);
			var name = item[2];
			document.getElementById(name).innerHTML = item[0] + " x " + item[1];
		}
	}
}

function allowDrop(ev){
	ev.preventDefault();
}

function drag(ev){
	ev.dataTransfer.setData("text/plain", ev.target.id);
}

function drop(ev){
	ev.preventDefault();
	var data = ev.dataTransfer.getData("text");
	ev.target.appendChild(document.getElementById(data));
}

function cellevents(){		//add event listeners for all table cells
	var r = document.getElementsByClassName("unselcell");
	for(var i = 0;i<r.length; i++){
		r[i].addEventListener("click", itemclick);
		console.log("added listener for cell");
	}
}

function itemclick(){			//change style on clicked cell
	var e = document.getElementsByClassName("selcell");
	for(var i = 0; i < e.length; i++){
		e[i].className = "unselcell";
	}
	this.className = "selcell";
	document.getElementById('itemtopost').value = this.innerHTML;
	console.log(this.innerHTML);
}

function newauction(){
	var xhttp = new XMLHttpRequest;
	var amountpost = document.getElementById('amounttopost').value;
	var longpost = document.getElementById('howlongtopost').value;
	var pricepost = document.getElementById('pricetopost').value;
	var celldatacl = document.getElementById('itemtopost').value;
	var itempost = celldatacl.split(" x ");
	var datatosend = "amount="+amountpost+"&long="+longpost+"&price="+pricepost+"&item="+itempost[0];
	xhttp.onreadystatechange = function(){
		if(this.readyState == 4 && this.status == 200){
			console.log(this.responseText);
		}
	};
	
	xhttp.open("POST", "/newauc.php", true);
	xhttp.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
	xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
	console.log("sending: " + datatosend);
	xhttp.send(datatosend);
}

</script>
<link rel="stylesheet" type="text/css" href="showinv.css">
</head>
<body>
<?php include 'code/topbar/topbar_html.php' ?>
<div class = 'itemopt'>
<p id = 'itemname'>Item Name</p>
	<form method = 'POST' onsubmit = 'newauction()'>
		<input type = 'text' id = 'amounttopost' placeholder = 'number'> </br>
		<input type = 'text' id = 'howlongtopost' placeholder = 'time'> </br>
		<input type = 'text' id = 'pricetopost' placeholder = 'price'> </br>
		<input type = 'hidden' id = 'itemtopost' value = ''>
		<input type = 'submit' value = 'Post'>
	</form>

</div>

<?php
$cellid = 0;
echo "Logged in as: " .$_SESSION['login_nick'];
echo "<div class = 'invtable'> <table ondrop = 'drop(event)' ondragover = 'allowDrop(event)'>";
for ($x = 1;$x < 15;$x++){
	echo "<tr>";
	for($y = 1;$y < 12;$y++){
		$cellid++;
		echo "<td class = 'unselcell' dragable = 'true' ondragstart = 'drag(event)' id = " . $cellid . "></td>";
	}
	echo "</tr>";
}
echo "</table> </div>";

?>
</body>
</html>
