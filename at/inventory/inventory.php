<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

$dbname = "at";
$conn = new mysqli($servername, $username, $password, $dbname);

$bagsize = 30;
$bagwidth = 5;
echo "<table><tr>";
for($i = 1;$i<=$bagsize;$i++){
	echo "<td>empty</td>";
	if($i%$bagwidth == 0){
		echo "</tr><tr>";
	}
	
}
echo "</table>";


?>
<head>
	<link rel="stylesheet" type="text/css" href="index.css">
	<script type="text/javascript" src="index.js"></script>
</head>

