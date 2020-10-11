<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

$acc_id = $_SESSION['login_id'];
//check for admin acc?

$dbname = "at";
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * FROM `travel_list` INNER JOIN `hero` ON hero.location_id = travel_list.start_pos INNER JOIN loc_list ON loc_list.loc_id = travel_list.end_pos WHERE hero.acc_id = $acc_id";
$result = $conn->query($sql);

echo '<button id = "starttravel">START TRAVEL</button>';
echo '<select id = "tselect">';
while ($row = $result->fetch_assoc()) {
	echo '<option value = "' . $row['end_pos'] . '">' . $row['loc_name'] . '</option>';
}
echo '</select>';

mysqli_data_seek($result, 0);
while ($row = $result->fetch_assoc()) {
	echo '<div class = "hidedetails" id = "' . $row['loc_name'] . '">';
	echo '<p>Travel to: ' . $row['loc_name'] . '</p>';
	echo '<p>Location Description: ' . $row['loc_desc'] . '</p>';
	echo '<p>Time to arive: ' . $row['time'] . ' seconds</p>';
	echo '</div>';
}

?>