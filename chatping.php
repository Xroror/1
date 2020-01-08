<?php
session_start();
header("Content-Type: text/event-stream");
header('Cache-Control: no-cache');


$fn1 = $_POST['name'] . "-" . $_SESSION['login_nick'] . ".txt";
$fn2 = $_SESSION['login_nick'] . "-" . $_POST['name'] . ".txt";
if(!file_exists($fn1)){
	$chatfile = $fn2;
	}else{
	$chatfile = $fn1;
}
$lt = filemtime($chatfile);

	if($lt < filemtime($chatfile)){
		echo "data: 1";
		$lt = filemtime($chatfile);
	}else{
		echo "data: error";
	}

 ob_end_flush();
 flush();
?>
