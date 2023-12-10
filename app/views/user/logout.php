<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Redirect to the login page (index.php) using a relative path
header("Location: ../../../index.php");
exit;

