<?php
require_once('../../config.php');
session_start();
if (isset($_POST['get_general'])) {
    $id = 1;
    $stmt = $con->prepare("SELECT * FROM system_information WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $json_data = json_encode($row);
        echo $json_data;
    } else {
        echo json_encode(array('error' => 'No data found'));
    }
    $stmt->close();
    exit();
}

if (isset($_POST['update_settings'])) {
    $shutdown = isset($_POST['etat']) ? $_POST['etat'] : 0;
    $name = isset($_POST['name']) ? $_POST['name'] : '';
    $shortName = isset($_POST['short_name']) ? $_POST['short_name'] : '';
    $welcomeContent = isset($_POST['welcome_content']) ? $_POST['welcome_content'] : '';
    $aboutUsContent = isset($_POST['about_us_content']) ? $_POST['about_us_content'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $contact = isset($_POST['contact']) ? $_POST['contact'] : '';
    $officeAddress = isset($_POST['address']) ? $_POST['address'] : '';

    // Retrieve existing image paths
    $stmt = $con->prepare("SELECT system_logo, cover_image FROM system_information WHERE id = 1");
    $stmt->execute();
    $result = $stmt->get_result();
    $existingPaths = $result->fetch_assoc();
    $stmt->close();

    $logoTargetPath = $existingPaths['system_logo'];
    $coverTargetPath = $existingPaths['cover_image'];

    if (isset($_FILES['logo']['name']) && isset($_FILES['cover']['name'])) {
        // New files are uploaded
        $logoTargetDir = "../images/";
        $coverTargetDir = "../images/";
        $logoTargetPath = $logoTargetDir . basename($_FILES['logo']['name']);
        $coverTargetPath = $coverTargetDir . basename($_FILES['cover']['name']);
        move_uploaded_file($_FILES['logo']['tmp_name'], $logoTargetPath);
        move_uploaded_file($_FILES['cover']['tmp_name'], $coverTargetPath);

        // Remove old images if they exist
        if (file_exists($existingPaths['system_logo'])) {
            unlink($existingPaths['system_logo']);
        }
        if (file_exists($existingPaths['cover_image'])) {
            unlink($existingPaths['cover_image']);
        }
    }

    $updateStmt = $con->prepare("UPDATE system_information SET shutdown=?, name=?, short_name=?, welcome_content=?, about_us_content=?, system_logo=?, cover_image=?, email=?, contact_number=?, office_address=? WHERE id=1");
    $updateStmt->bind_param("isssssssss", $shutdown, $name, $shortName, $welcomeContent, $aboutUsContent, $logoTargetPath, $coverTargetPath, $email, $contact, $officeAddress);

    if ($updateStmt->execute()) {
        echo '1'; // Success
        
    } else {
        echo '0'; // Failure
    }

    $updateStmt->close();
    $con->close();
}
?>