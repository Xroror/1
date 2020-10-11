<?php
session_start();
?>

<html>
<head>
<style>
	
	body{
		background-color: #ffcc66;
	}
		
	#gamediv {
		position: absolute;
	}
	#gamehelp {
		position: relative;
		width: 15px;
		height: 15px;
		float: right;
	}
	
	#dropcontent {
			display: none;
			
			float: right;
			background-color: #f9f9f9;
			min-width: 160px;
			box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
			z-index: 1;
	}
	
	#dropbut {
		border-radius: 15px;
		border-color: red;
		float: right;
		color: black;
		background-color: #ff9966;
	}
	
	#myRange{
		-webkit-appearance: none;
		appearance: none;
		background: #d3d3d3;
		outline: none;
		opacity: 0.7;
		webskit-transition: .2s;
		transition: opacity .2s;
	}
	
</style>

<script src = snake.js> </script>
</head>
<body>
<div id = "gamediv"></div>
<div id = "gamehelp">
<button id = "dropbut">?</button>
<div id = "dropcontent">
<div class="slidecontainer">
  <input type="range" min="5" max="300" value="250" class="slider" id="myRange">
</div>
</div>

</div>
</body>
</html>