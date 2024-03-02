<?php
require_once('../../config.php');

$result = array();

$sql = "SELECT bookings.*, users.middlename, halls.name
        FROM bookings
        INNER JOIN users ON bookings.client_id = users.id
        INNER JOIN halls ON bookings.hall_id = halls.id";

$query = mysqli_query($con, $sql);

if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = $row;
    }
}

echo json_encode($result);
?>