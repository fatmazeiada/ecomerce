<?php
// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'hexashop');

// Attempt to connect to MySQL database
$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

// Check connection
if($mysqli === false){
    // Use die() which will output the message and terminate the script.
    // Avoid echoing sensitive error details in production environments.
    die("ERROR: Could not connect. " . $mysqli->connect_error);
}

// Set character set to utf8mb4 for full Unicode support
if (!$mysqli->set_charset("utf8mb4")) {
    // Handle error if charset setting fails (optional, but good practice)
    // In production, log this error instead of outputting directly.
    error_log("Error loading character set utf8mb4: %s\n", $mysqli->error);
    // Optionally die or proceed with caution if charset isn't critical initially
    // die("Error loading character set utf8mb4.");
}

// Optional: You can include other global configurations here if needed.

?> 