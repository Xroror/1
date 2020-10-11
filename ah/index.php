<?php include $_SERVER['DOCUMENT_ROOT'] . '/code/topbar/topbar_html.php';
	  session_start();
 ?>
<html>
<head>
<script type="text/javascript" src = "ah.js"></script>
<link rel="stylesheet" type="text/css" href="ah.css">
</head>
<body>
<div id = "searchdiv">
	<form onsubmit = "return false";>
		<input autocomplete="off"   id = "searchfield" type = "text" name = "search">
	</form>
</div>
	<div id = "results"></div>
	<div id = "tooltip"></div>
	
	<div id = "shoppinglist"> </div>
	
</body>
</html>