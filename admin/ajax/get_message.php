<?php 
require_once('../../config.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['get_messages'])) {
    $query = "SELECT * FROM messages";
    $result = mysqli_query($con, $query);
    if ($result) {
        $messages = array();
        while ($row = mysqli_fetch_assoc($result)) {
            $messages[] = $row;
        }
        header('Content-Type: application/json');
        echo json_encode($messages);
    } else {
        echo json_encode(array('error' => 'Failed to retrieve messages'));
    }
} else {
    echo json_encode(array('error' => 'Invalid request'));
}

?>