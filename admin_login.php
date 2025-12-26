<?php
// admin_login.php
session_start();
require 'includes/config.php'; // Your database connection

// Redirect if already logged in
if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) {
    header('Location: admin_dashboard.php');
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = $_POST['password'] ?? '';
    
    if (empty($username) || empty($password)) {
        $error = "Please enter both username and password";
    } else {
        // Check credentials against database
        $stmt = $con->prepare("SELECT id, username, password_hash, role FROM AdminUsers WHERE username = ? AND is_active = 1");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            if (password_verify($password, $user['password_hash'])) {
                // Regenerate session ID to prevent fixation
                session_regenerate_id(true);
                
                // Set session variables
                $_SESSION['admin_logged_in'] = true;
                $_SESSION['admin_id'] = $user['id'];
                $_SESSION['admin_username'] = $user['username'];
                $_SESSION['admin_role'] = $user['role'];
                
                // Update last login time
                $updateStmt = $con->prepare("UPDATE AdminUsers SET last_login = NOW() WHERE id = ?");
                $updateStmt->bind_param('i', $user['id']);
                $updateStmt->execute();
                
                // Redirect to dashboard
                header('Location: admin_dashboard.php');
                exit;
            }
        }
        
        // If we get here, credentials were invalid
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            max-width: 400px;
            margin-top: 100px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container login-container">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Admin Login</h2>
                
                <?php if (isset($_SESSION['registration_success'])): ?>
                    <div class="alert alert-success">Registration successful! Please login.</div>
                    <?php unset($_SESSION['registration_success']); ?>
                <?php endif; ?>
                
                <?php if (!empty($error)): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                
                <form method="POST" novalidate>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Login</button>
                    
                    <div class="text-center mt-3">
                        <a href="admin_register.php">Need an account? Register</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html> 