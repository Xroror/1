<?php
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT hp_cur, hp_max FROM `hero` WHERE acc_id = $acc_id;";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
$hp_cur = $row["hp_cur"];
$healing = round($row["hp_max"]/60*$time);
$newcur = $hp_cur + $healing;
if($newcur > $row["hp_max"]){$healing = $row["hp_max"] - $row["hp_cur"];}
$start = date("Y-m-d H-i-s");
$end = date("Y-m-d H-i-s", strtotime("+$time minutes"));
$cR = new stdClass();
$cR->hp = $healing;
$changes = json_encode($cR);
$sql = "INSERT INTO `active` (acc_id, act_id, start, end, changes) VALUES ($acc_id, $act_id, '$start', '$end', '$changes');";
$conn->query($sql);

?>