<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Database configuration
$host = "localhost";
$user = "root";
$password = "";
$database = "arc";

// Create connection
$con = mysqli_connect($host, $user, $password, $database);

// Check connection
if (mysqli_connect_errno()) {
    die(json_encode([
        'status' => 'error',
        'message' => 'Failed to connect to MySQL: ' . mysqli_connect_error()
    ]));
}

// Set charset to utf8mb4 for proper Unicode support
mysqli_set_charset($con, "utf8mb4");

// Function to safely escape strings
function sanitize_input($con, $data) {
    return mysqli_real_escape_string($con, trim($data));
}

// Set default timezone (adjust to your location)
date_default_timezone_set('Asia/Manila');

// Define log directory
define('LOG_DIR', __DIR__ . '/../logs/');
if (!file_exists(LOG_DIR)) {
    mkdir(LOG_DIR, 0755, true);
}
?>
