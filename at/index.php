<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

?>
<?php include $_SERVER['DOCUMENT_ROOT'] . '/code/topbar/topbar_html.php' ?>

<html>
<head>
<link rel="stylesheet" type="text/css" href="index.css">
<script type="text/javascript" src="index.js"></script>
</head>
<body>
<div class = "wrapper">
	<div id = "leftNAV">
	<button id = "lminv" class = "lmbut">Inventory</button></br>
	<button id = "lmfight" class = "lmbut">Fight</button></br>
	<button id = "lmheal" class = "lmbut">Heal</button></br>
	<button id = "lmtravel" class = "lmbut">Travel</button></br>
	<button id = "lmwork" class = "lmbut">Work</button></br>
	<button id = "lmcraft" class = "lmbut">Craft</button></br>
	<button id = "lmgather" class = "lmbut">Gather</button>
	
	</div>
	
	<div class = "midwin" id = "fightwin">
	<button>
	
	
	</div>

	<div id = 'censcreen'>
	</div>

	<div id = "herostats">
	<table id = "herotable">
	
	<tr>
	<td><button id = "mapicon"></button></td>
	<td colspan=4 id = "location"></td>
	</tr>
	<tr>
	
	</tr>
	<tr>
	<td id = "hpiconcell"></td>
	<td id = "hpcur">0</td>
	<td id = "slash">/<td>
	<td id = "hpmax">0</td>
	</tr>
	<tr>
	<td id = "aticon"></td>
	<td id = "dps">
	</tr>
	</table>
	</div>
	<div class = "clocalchat">
		<div class = "localchatcont">
		</div>
		<form>
			<input type = "text">
			<input type="submit" name="s">
		</form>
	</div>
</div>
</body>
</html>