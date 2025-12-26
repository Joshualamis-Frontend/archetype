<?php
// register.php
session_start();
require 'includes/config.php'; // Include database connection

// Define log file path
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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GASTRONET REGISTER</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
     :root {
    /* Refined Filipino color palette */
    --brown: #BF9264;
    --gold: #FFC107;
    --cream: #FFF9C4;
    --red: #D32F2F;
    --blue: #1976D2;
    --white: #FFFFFF;
    --off-white: #F8F9FA;
    --dark-brown: #5D4037;
    --light-gray: #EEEEEE;
    --dark-gray: #424242;
}

body {
    min-height: 100vh;
    background: var(--brown);
    margin: 0;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

/* CENTER WRAPPER */
.main-container {
    min-height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    padding: 10px;
}

/* SMALLER CARD */
.register-container {
    background: rgb(226, 217, 181);
    border-radius: 30px;
    box-shadow: 0 12px 25px rgba(0, 0, 0, 0.2);
    overflow: hidden;
    width: 100%;
    max-width: 680px; /* smaller */
    display: flex;
    min-height: 420px; /* smaller */
}

/* IMAGE SIDE */
.register-image {
    flex: 1;
    background: linear-gradient(
        rgba(128, 128, 128, 0.1),
        rgba(128, 128, 128, 0.7)
    ),
    url('images/vb.png');
    background-size: cover;
    background-position: center;
    display: flex;
    justify-content: center;
    align-items: center;
    color: var(--off-white);
    padding: 25px;
    text-align: center;
}

/* FORM SIDE */
.register-form {
    flex: 1.2;
    padding: 30px; /* reduced */
    display: flex;
    flex-direction: column;
    justify-content: center;
}

/* LOGO */
.logo {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    background: white;
    padding: 4px;
    margin-bottom: 15px;
    box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
}

/* INPUT GROUP */
.form-group {
    margin-bottom: 15px;
    position: relative;
}

.form-control {
    border: none;
    border-bottom: 2px solid #e0e0e0;
    border-radius: 0;
    padding: 10px 35px 10px 12px;
    font-size: 14px; /* smaller text */
    background: transparent;
}

.form-control:focus {
    box-shadow: none;
    border-color: var(--accent-color);
}

.form-group i {
    position: absolute;
    right: 10px;
    top: 50%;
    transform: translateY(-50%);
    color: var(--dark-gray);
    font-size: 14px;
}

/* PASSWORD BAR */
.password-strength {
    height: 4px;
    margin-top: 4px;
    border-radius: 2px;
}

/* BUTTON */
.btn-register {
    background: var(--accent-color);
    color: var(--dark-gray);
    padding: 10px 25px;
    border-radius: 25px;
    font-size: 14px;
    font-weight: 600;
    letter-spacing: 0.5px;
    margin-top: 15px;
    box-shadow: 0 4px 12px rgba(41, 98, 255, 0.3);
}

.btn-register:hover {
    background: var(--secondary-color);
    transform: translateY(-2px);
}

/* LINKS */
.login-link {
    text-align: center;
    margin-top: 18px;
    font-size: 13px;
    color: var(--dark-gray);
}

.login-link a {
    color: var(--dark-gray);
    font-weight: 600;
    text-decoration: none;
}

.login-link a:hover {
    color: var(--off-white);
}

/* TEXT INFO */
.requirements,
.age-warning {
    font-size: 11px;
    color: var(--dark-gray);
    margin-top: 4px;
}

.requirement {
    display: flex;
    align-items: center;
    margin: 2px 0;
}

.requirement i {
    margin-right: 5px;
    font-size: 9px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .register-container {
        max-width: 380px;
        flex-direction: column;
        min-height: auto;
    }

    .register-image {
        display: none;
    }

    .register-form {
        padding: 25px;
    }
}

    </style>
</head>
<body>
    <div class="main-container">
        <div class="register-container">
            <div class="register-image">
            <h1 class="mb-4">ARCHETYPE</h1>
            <p>Discover your archetype uncover your hidden personality traits</P>
            </div>
            <div class="register-form">
                <h3 class="text-center mb-4">Create Your Account</h3>
                <form method="POST" action="" id="registerForm">
                    <div class="form-group">
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" required>
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" name="email" placeholder="Email Address" required>
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="form-group">
                        <input type="date" class="form-control" name="birthdate" id="birthdate" placeholder="Birthdate" required>
                        <i class="fas fa-calendar"></i>
                        <div class="age-warning">You must be 18 years or older to register</div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="password" id="password" placeholder="Password" required>
                        <i class="fas fa-lock"></i>
                        <div class="password-strength"></div>
                        <div class="requirements">
                            <div class="requirement"><i class="fas fa-circle"></i> At least 8 characters</div>
                            <div class="requirement"><i class="fas fa-circle"></i> Contains uppercase & lowercase</div>
                            <div class="requirement"><i class="fas fa-circle"></i> Contains numbers</div>
                        </div>
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm Password" required>
                        <i class="fas fa-lock"></i>
                    </div>
                    <button type="submit" class="btn btn-register btn-block">Create Account</button>
                    <div class="login-link">
                        Already have an account? <a href="user_login.php">Login here</a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <script>
        // Capitalize username first letter
        document.getElementById('username').addEventListener('input', function() {
            this.value = this.value.charAt(0).toUpperCase() + this.value.slice(1);
        });

        // Set max date for birthdate (18 years ago)
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const minDate = new Date();
            minDate.setFullYear(today.getFullYear() - 100); // 100 years ago
            const maxDate = new Date();
            maxDate.setFullYear(today.getFullYear() - 18); // 18 years ago
            
            const birthdateInput = document.getElementById('birthdate');
            birthdateInput.max = maxDate.toISOString().split('T')[0];
            birthdateInput.min = minDate.toISOString().split('T')[0];
        });

        // Password strength indicator
        document.getElementById('password').addEventListener('input', function() {
            const password = this.value;
            const strength = document.querySelector('.password-strength');
            const requirements = document.querySelectorAll('.requirement i');
            
            // Check requirements
            const hasLength = password.length >= 8;
            const hasCase = /[a-z]/.test(password) && /[A-Z]/.test(password);
            const hasNumber = /\d/.test(password);
            
            requirements[0].className = hasLength ? 'fas fa-check' : 'fas fa-circle';
            requirements[1].className = hasCase ? 'fas fa-check' : 'fas fa-circle';
            requirements[2].className = hasNumber ? 'fas fa-check' : 'fas fa-circle';
            
            let strengthValue = 0;
            if (hasLength) strengthValue += 33;
            if (hasCase) strengthValue += 33;
            if (hasNumber) strengthValue += 34;
            
            strength.style.width = `${strengthValue}%`;
            strength.style.background = 
                strengthValue <= 33 ? '#ff4444' :
                strengthValue <= 66 ? '#ffa700' : '#00C851';
        });

        // Client-side age validation
document.getElementById('registerForm').addEventListener('submit', function(e) {
    const birthdate = new Date(document.getElementById('birthdate').value);
    if (!birthdate) {
        e.preventDefault();
        Swal.fire({
            icon: 'error',
            title: 'Invalid Birthdate',
            text: 'Please enter a valid birthdate.',
            confirmButtonColor: '#2962ff'
        });
        return;
    }
    
    const today = new Date();
    let age = today.getFullYear() - birthdate.getFullYear();
    const monthDiff = today.getMonth() - birthdate.getMonth();
    
    if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthdate.getDate())) {
        age--;
    }
    
    if (age < 18) {
        e.preventDefault();
        // Clear the birthdate field
        document.getElementById('birthdate').value = '';
        Swal.fire({
            icon: 'error',
            title: 'Age Restriction',
            text: 'You must be at least 18 years old to register.',
            confirmButtonColor: '#2962ff'
        });
    }
});

        // Alert messages
        var alertMessage = "<?php echo $alertMessage; ?>";
        if (alertMessage === "age_restriction") {
            Swal.fire({
                icon: 'error',
                title: 'Age Restriction',
                text: 'You must be at least 18 years old to register.',
                confirmButtonColor: '#2962ff'
            });
        } else if (alertMessage === "password_mismatch") {
            Swal.fire({
                icon: 'error',
                title: 'Passwords Do Not Match',
                text: 'Please ensure both passwords are identical.',
                confirmButtonColor: '#2962ff'
            });
        } else if (alertMessage === "email_exists") {
            Swal.fire({
                icon: 'warning',
                title: 'Email Already Registered',
                text: 'Please use a different email address or login to your existing account.',
                confirmButtonColor: '#2962ff'
            });
        } else if (alertMessage === "registration_success") {
            Swal.fire({
                icon: 'success',
                title: 'Welcome Aboard!',
                text: 'Your account has been created successfully.',
                showConfirmButton: true,
                confirmButtonColor: '#2962ff'
            }).then(() => {
                window.location = 'user_login.php';
            });
        } else if (alertMessage === "registration_error") {
            Swal.fire({
                icon: 'error',
                title: 'Registration Failed',
                text: 'An error occurred during registration. Please try again.',
                confirmButtonColor: '#2962ff'
            });
        }
    </script>
</body>
</html>