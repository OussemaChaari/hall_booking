<?php
if (!defined('base_url')) define('base_url', 'http://localhost/HallBooking/');
define('DB_SERVER', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'hallbooking');
$con = mysqli_connect(DB_SERVER, DB_USER, DB_PASS, DB_NAME);
// Check connection
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
$id = 1;
$stmt = $con->prepare("SELECT * FROM system_information WHERE id = ?");
if (!$stmt) {
    die("Error in preparing statement: " . $con->error);
}
$stmt->bind_param("i", $id);
if (!$stmt->execute()) {
    die("Error in executing statement: " . $stmt->error);
}
$result = $stmt->get_result();
if (!$result) {
    die("Error in getting result: " . $stmt->error);
}
$setting_info = $result->fetch_assoc();
$stmt->close();
?>