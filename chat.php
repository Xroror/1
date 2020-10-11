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
$output = "";
$c = "";
$i = 0;
$poss = -1;
while($i < 15){
	$output = $c . $output;
	fseek($chatfile, $poss--, SEEK_END);
	$c = fgetc($chatfile);
	if($c == "\n"){$i++;}
	if(feof($chatfile)){$i = 15;}
}
echo $output;
// $ready[] = explode('%Щ1%$%$', $output);
// $len = $readt.length / 3;
// for($i = 0; i<$len;
// $send = "t=" . $ready[0] . "w=" . $ready[1] . "m=" . $ready[2];
// echo $send;
fclose($chatfile);
?>