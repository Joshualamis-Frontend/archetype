<?php
// admin_login.php
session_start();
require 'config.php'; // Your database connection

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
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #fff789ff 0%, #ffe48aff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .login-container {
            width: 100%;
            max-width: 380px;
            margin: 0 auto;
        }

        .card {
            background: #ffe77dff;
            border: none;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.4);
        }

        .card-body {
            padding: 2rem 2rem;
        }

        .card-title {
            color: #1a1a1a;
            font-size: 1.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            position: relative;
            padding-bottom: 0.75rem;
        }

        .card-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 2px;
            background: linear-gradient(90deg, #1a1a1a 0%, #4a4a4a 100%);
            border-radius: 2px;
        }

        .alert {
            border: none;
            border-radius: 8px;
            padding: 0.75rem;
            margin-bottom: 1rem;
            font-size: 0.85rem;
            animation: slideDown 0.3s ease;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background-color: #f0f0f0;
            color: #1a1a1a;
            border-left: 4px solid #2d2d2d;
        }

        .alert-danger {
            background-color: #f5f5f5;
            color: #1a1a1a;
            border-left: 4px solid #4a4a4a;
        }

        .form-label {
            color: #2d2d2d;
            font-weight: 600;
            font-size: 0.85rem;
            margin-bottom: 0.4rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-control {
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            padding: 0.6rem 0.9rem;
            font-size: 0.95rem;
            transition: all 0.3s ease;
            background-color: #fafafa;
        }

        .form-control:focus {
            border-color: #2d2d2d;
            box-shadow: 0 0 0 0.2rem rgba(45, 45, 45, 0.1);
            background-color: #ffffff;
            outline: none;
        }

        .form-control:hover {
            border-color: #c0c0c0;
        }

        .mb-3 {
            margin-bottom: 1.2rem;
        }

        .btn-primary {
            background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            border: none;
            border-radius: 8px;
            padding: 0.7rem;
            font-size: 0.95rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.2), transparent);
            transition: left 0.5s ease;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, #2d2d2d 0%, #1a1a1a 100%);
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.3);
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-primary:active {
            transform: translateY(0);
        }

        .text-center a {
            color: #2d2d2d;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
        }

        .text-center a::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 2px;
            background: #1a1a1a;
            transition: width 0.3s ease;
        }

        .text-center a:hover {
            color: #1a1a1a;
        }

        .text-center a:hover::after {
            width: 100%;
        }

        /* Responsive Design */
        @media (max-width: 576px) {
            .card-body {
                padding: 2rem 1.5rem;
            }

            .card-title {
                font-size: 1.5rem;
            }

            .form-control {
                font-size: 0.95rem;
                padding: 0.65rem 0.9rem;
            }

            .btn-primary {
                padding: 0.75rem;
                font-size: 0.95rem;
            }
        }

        @media (max-width: 400px) {
            body {
                padding: 15px;
            }

            .card-body {
                padding: 1.5rem 1.25rem;
            }

            .card-title {
                font-size: 1.35rem;
            }
        }

        /* Loading Animation */
        @keyframes pulse {
            0%, 100% {
                opacity: 1;
            }
            50% {
                opacity: 0.5;
            }
        }

        .btn-primary:disabled {
            animation: pulse 1.5s ease-in-out infinite;
        }
    </style>
</head>
<body>
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
