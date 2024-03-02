<?php
require_once('../../config.php');
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['id'])) {
    $messageId = mysqli_real_escape_string($con, $_POST['id']);

    $query = "DELETE FROM messages WHERE id = '$messageId'";
    $result = mysqli_query($con, $query);
    if ($result) {
        echo json_encode(['status' => 'success']);
        exit();
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete message']);
        exit();
    }
}
?>