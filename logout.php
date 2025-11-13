<?php
// Initialize the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
 
// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
if (session_destroy()) {
    // Destroy successful.
} else {
    // Optional: Log error if destroy fails
    error_log("Session destroy failed.");
}
 
// Redirect to login page (or home page)
header("location: index.php");
exit;
?> 