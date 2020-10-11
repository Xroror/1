<?php include $_SERVER['DOCUMENT_ROOT'] . '/DBACCESS.php';
session_start();

$acc_id = $_SESSION['login_id'];
//check for admin acc?

$dbname = "at";
$conn = new mysqli($servername, $username, $password, $dbname);

$sql = "SELECT * FROM `fight_list` INNER JOIN `hero` ON hero.location_id = fight_list.fight_loc WHERE acc_id = $acc_id ORDER BY fight_id;";
$result = $conn->query($sql);

echo '<button id = "startfight"> START FIGHT </button>';
echo '<select id = "fselect">';
while ($row = $result->fetch_assoc()) {
	echo '<option value = "' . $row['fight_id'] . '">' . $row['fight_name'] . '</option>';
}
echo '</select>';

mysqli_data_seek($result, 0);
while ($row = $result->fetch_assoc()) {
	echo '<div class = "hidedetails" id = "' . $row['fight_name'] . '">';
	echo '<p>Health: ' . $row['fight_HP'] . '</p>';
	echo '<p>Attack Damage: ' . $row['fight_ATmin'] . ' - ' . $row['fight_ATmax'] . '</p>';
	echo '<p>Attack Speed: ' . $row['fight_AS'] . '</p>';
	echo '</div>';
}

?>