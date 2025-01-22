<?php
session_start();
session_unset();  // Remove all session variables
$_SESSION['last_logout'] = date("Y-m-d H:i:s");
session_destroy();  // Destroy the session

// Optionally, remove cookies
setcookie('status', '', time() - 3600, '/');  // Expire the cookie

header('location: login.html');  // Redirect to login page
exit();
?>
