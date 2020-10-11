<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();
if(isset($_SESSION['login_id'])){
	$id = $_SESSION['login_id'];
}else{
	$id = '0';
}

function getUserIP() {
    $userIP =   '';
    if(isset($_SERVER['HTTP_CLIENT_IP'])){
        $userIP =   $_SERVER['HTTP_CLIENT_IP'];
    }elseif(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $userIP =   $_SERVER['HTTP_X_FORWARDED_FOR'];
    }elseif(isset($_SERVER['HTTP_X_FORWARDED'])){
        $userIP =   $_SERVER['HTTP_X_FORWARDED'];
    }elseif(isset($_SERVER['HTTP_X_CLUSTER_CLIENT_IP'])){
        $userIP =   $_SERVER['HTTP_X_CLUSTER_CLIENT_IP'];
    }elseif(isset($_SERVER['HTTP_FORWARDED_FOR'])){
        $userIP =   $_SERVER['HTTP_FORWARDED_FOR'];
    }elseif(isset($_SERVER['HTTP_FORWARDED'])){
        $userIP =   $_SERVER['HTTP_FORWARDED'];
    }elseif(isset($_SERVER['REMOTE_ADDR'])){
        $userIP =   $_SERVER['REMOTE_ADDR'];
    }else{
        $userIP =   'UNKNOWN';
    }
    return $userIP;
}
$loc = $_POST['loc'];
$ip = getUserIp();
$date = date("Y-m-d H-i-s");

$conn = new mysqli($servername, $username, $password, $dbname);
$sql = "INSERT INTO visits (visit_acc_id, visit_ip, visit_date, visit_page)
	VALUES ('$id', '$ip', '$date', '$loc')";
$conn->query($sql);


?>