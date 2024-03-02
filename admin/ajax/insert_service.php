<?php
require_once('../../config.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    $stmt = $con->prepare("INSERT INTO services (name, description, status) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $name, $description, $status);
    if ($stmt->execute()) {
        echo '1';
    } else {
        echo '0';
    }

    $stmt->close();
}
?>