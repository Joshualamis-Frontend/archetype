<?php
// register.php
session_start();
require 'config.php'; // Include database connection

// Define log file pathZZ
$logFile = 'registration_log.txt';
$alertMessage = ''; // Initialize a variable to store alert messages

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = htmlspecialchars($_POST['username']);
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $birthdate = $_POST['birthdate'];

    // Calculate age from birthdate
    $today = new DateTime();
    $birthdateObj = new DateTime($birthdate);
    $age = $today->diff($birthdateObj)->y;

    // Check if the user is at least 18 years old (server-side validation)
    if ($age < 18) {
        $alertMessage = "age_restriction";
        // Clear the birthdate to prevent form from keeping the underage value
        $_POST['birthdate'] = '';
    }
    // Check if the passwords match
    else if ($password !== $confirm_password) {
        $alertMessage = "password_mismatch";
    } else {
        $hashedPassword = password_hash($password, PASSWORD_ARGON2I);

        // Check if the email already exists
        $stmt = $con->prepare("SELECT * FROM Admin WHERE email = ?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $alertMessage = "email_exists";
        } else {
            // Insert new user into the database
            $stmt = $con->prepare("INSERT INTO Admin (username, email, password, birthdate) VALUES (?, ?, ?, ?)");
            $stmt->bind_param('ssss', $username, $email, $hashedPassword, $birthdate);
            if ($stmt->execute()) {
                $alertMessage = "registration_success";
                
                // Log the successful registration
                $logMessage = date('Y-m-d H:i:s') . " - New registration: " . $username . " (" . $email . ")\n";
                file_put_contents($logFile, $logMessage, FILE_APPEND);
                
                // Count total registrations (optional)
                $totalRegistrations = count(file($logFile));
                $_SESSION['total_registrations'] = $totalRegistrations;
            } else {
                $alertMessage = "registration_error";
            }
        }
    }
}
?>
