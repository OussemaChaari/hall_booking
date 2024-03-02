<?php
require_once('../../config.php');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $code = $_POST['code'];
    $name = $_POST['name'];
    $price = $_POST['price'];
    $description = $_POST['description'];
    $status = $_POST['status'];
    if ($_FILES['img']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        $uploadPath = $uploadDir . basename($_FILES['img']['name']);
        move_uploaded_file($_FILES['img']['tmp_name'], $uploadPath);
        $imagePath = $uploadPath;

    }
    $stmt = $con->prepare("INSERT INTO halls (code, name, price, description, image_path, status) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssdssi", $code, $name, $price, $description, $imagePath, $status);

    if ($stmt->execute()) {
        echo '1';
    } else {
        echo '0';
    }

    $stmt->close();
}
?>