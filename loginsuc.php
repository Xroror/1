<?php  
session_start();
if(isset($_SESSION['login_nick'])){
echo $_SESSION['login_id'] . "&" . $_SESSION['login_nick'];
}