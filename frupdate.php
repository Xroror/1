<?php
session_start();
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
$file2 = $_POST['name'] . "-" . $_SESSION['login_nick'] . ".txt";
$file1 = $_SESSION['login_nick'] . "-" . $_POST['name'] . ".txt";
if(!file_exists($file1)){
	$chatfile = fopen($file2, "a+");
	echo fread($chatfile, filesize($file2));
}else{
	$chatfile = fopen($file1, "a+");
	echo fread($chatfile, filesize($file1));
}

fclose($chatfile);
?>