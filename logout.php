<?php
// Start the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session.
session_destroy();

// Redirect to login page or homepage after logging out
header("Location: login.php");
exit;
?>