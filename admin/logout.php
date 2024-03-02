<?php
require_once('../config.php');
// Start the session
session_start();
$_SESSION = array();
session_destroy();
header("Location: " . base_url . "admin/index.php");
exit();
?>