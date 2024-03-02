<?php
require_once('../../config.php');

$result = array();

$sql = "SELECT * FROM halls";
$query = mysqli_query($con, $sql);

if ($query) {
    while ($row = mysqli_fetch_assoc($query)) {
        $result[] = $row;
    }
}

echo json_encode($result);
?>