<?php
session_start();
if(isset($_SESSION['login_nick'])){
	echo $_SESSION['login_nick'];
}else{
	echo "notlogged";
}

?>
