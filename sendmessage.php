<?php
session_start();
header('Content-Type: text/event-stream');
header('Cache-Control: no-cache');
$file2 = $_POST['name'] . "-" . $_SESSION['login_nick'] . ".txt";
$file1 = $_SESSION['login_nick'] . "-" . $_POST['name'] . ".txt";
if(!file_exists($file1)){
	$chatfile = fopen($file2, "a+");
	}else{
	$chatfile = fopen($file1, "a+");
}
$names = $_SESSION['login_nick'] . "-" . $_POST['name'];
$div = "%Щ1%$%$";
$senton = date("Y-m-d H-i-s");
$mes = $senton . $div . $names . $div . $_POST['message'] . "\n";
echo fwrite($chatfile, $mes);

?>