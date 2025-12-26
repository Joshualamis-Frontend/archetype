<?php
session_start();
require 'config.php'; // Include database connection

$errors = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $invite_code = trim($_POST['invite_code'] ?? '');

    // Validate inputs
    if (empty($username)) {
        $errors['username'] = 'Username is required';
    } elseif (!preg_match('/^[a-zA-Z0-9_]{4,20}$/', $username)) {
        $errors['username'] = 'Username must be 4-20 chars (letters, numbers, _)';
    }

    if (empty($email)) {
        $errors['email'] = 'Email is required';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = 'Invalid email format';
    }

    if (empty($password)) {
        $errors['password'] = 'Password is required';
    } elseif (strlen($password) < 8) {
        $errors['password'] = 'Password must be at least 8 characters';
    }

    if ($password !== $confirm_password) {
        $errors['confirm_password'] = 'Passwords do not match';
    }

    // Check invite code (in a real system, you might have invite codes in a database)
    $valid_invite_code = 'ADMIN2023'; // Change this or implement proper invite code system
    if ($invite_code !== $valid_invite_code) {
        $errors['invite_code'] = 'Invalid invite code';
    }

    // Check if username or email already exists
    if (empty($errors)) {
        $stmt = $con->prepare("SELECT id FROM AdminUsers WHERE username = ? OR email = ?");
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $errors['general'] = 'Username or email already exists';
        }
    }

    // If no errors, create the admin user
    if (empty($errors)) {
        $hashedPassword = password_hash($password, PASSWORD_ARGON2I);
        $role = 'admin'; // Default role
        
        $stmt = $con->prepare("INSERT INTO AdminUsers (username, email, password_hash, role) VALUES (?, ?, ?, ?)");
        $stmt->bind_param('ssss', $username, $email, $hashedPassword, $role);
        
        if ($stmt->execute()) {
            $_SESSION['registration_success'] = true;
            header('Location: admin_login.php');
            exit;
        } else {
            $errors['general'] = 'Registration failed. Please try again.';
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Registration</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .registration-container {
            max-width: 500px;
            margin-top: 50px;
        }
        .password-requirements {
            font-size: 0.9rem;
            color: #6c757d;
            margin-top: 5px;
        }
    </style>
</head>
<body class="bg-light">
    <div class="container registration-container">
        <div class="card shadow">
            <div class="card-body">
                <h2 class="card-title text-center mb-4">Admin Registration</h2>
                
                <?php if (!empty($errors['general'])): ?>
                    <div class="alert alert-danger"><?= htmlspecialchars($errors['general']) ?></div>
                <?php endif; ?>
                
                <form method="POST" novalidate>
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <input type="text" class="form-control <?= isset($errors['username']) ? 'is-invalid' : '' ?>" 
                               id="username" name="username" value="<?= htmlspecialchars($username ?? '') ?>" required>
                        <?php if (isset($errors['username'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['username']) ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control <?= isset($errors['email']) ? 'is-invalid' : '' ?>" 
                               id="email" name="email" value="<?= htmlspecialchars($email ?? '') ?>" required>
                        <?php if (isset($errors['email'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['email']) ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <input type="password" class="form-control <?= isset($errors['password']) ? 'is-invalid' : '' ?>" 
                               id="password" name="password" required>
                        <?php if (isset($errors['password'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['password']) ?></div>
                        <?php endif; ?>
                        <div class="password-requirements">
                            Minimum 8 characters
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="confirm_password" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control <?= isset($errors['confirm_password']) ? 'is-invalid' : '' ?>" 
                               id="confirm_password" name="confirm_password" required>
                        <?php if (isset($errors['confirm_password'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['confirm_password']) ?></div>
                        <?php endif; ?>
                    </div>
                    
                    <div class="mb-3">
                        <label for="invite_code" class="form-label">Invite Code</label>
                        <input type="text" class="form-control <?= isset($errors['invite_code']) ? 'is-invalid' : '' ?>" 
                               id="invite_code" name="invite_code" required>
                        <?php if (isset($errors['invite_code'])): ?>
                            <div class="invalid-feedback"><?= htmlspecialchars($errors['invite_code']) ?></div>
                        <?php endif; ?>
                        <small class="text-muted">Contact system administrator for invite code</small>
                    </div>
                    
                    <button type="submit" class="btn btn-primary w-100">Register</button>
                    
                    <div class="text-center mt-3">
                        <a href="admin_login.php">Already have an account? Login</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>
