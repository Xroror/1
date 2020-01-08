<?php
session_start();
if(isset($_SESSION['login_nick'])){
	session_unset();
	session_destroy();
	echo "Logged out";
}else{
	die("NOT LOGGED");
}
