<?php
require_once('../../config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $serviceId = mysqli_real_escape_string($con, $_POST['id']);
    $query = "SELECT * FROM services WHERE id = '$serviceId'";
    $result = mysqli_query($con, $query);

    if ($result) {
        $serviceDetails = mysqli_fetch_assoc($result);
        echo json_encode($serviceDetails);
    } else {
        echo json_encode(['error' => 'Failed to retrieve service details']);
    }
} else {
    echo json_encode(['error' => 'Invalid request']);
}
?>