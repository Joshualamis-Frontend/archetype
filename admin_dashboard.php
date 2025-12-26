<?php
session_start();

// Authentication check
if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: admin_login.php');
    exit;
    // Destroy all session data
$_SESSION = [];
session_destroy();

// Redirect to login page
header("Location: admin_login.php");
exit;
}

// Database connection
require 'config.php'; // Your database connection

// Define log directory if not already defined
if (!defined('LOG_DIR')) {
    define('LOG_DIR', __DIR__ . '/logs/'); // Change this if your logs are in a different directory
}

// Fetch all admin users    
$adminUsers = [];
$adminResult = mysqli_query($con, "SELECT username, email FROM Admin");
if ($adminResult && mysqli_num_rows($adminResult) > 0) {
    while ($row = mysqli_fetch_assoc($adminResult)) {
        $adminUsers[] = $row;
    }
}
$totalAdmins = count($adminUsers);

// Fetch log files
$logFiles = glob(LOG_DIR . 'registrations_*.log');
usort($logFiles, function ($a, $b) {
    return filemtime($b) - filemtime($a); // Sort by last modified date, newest first
});

// Select log
$selectedLog = $_GET['log'] ?? 'current';
$currentLog = ($selectedLog === 'current') 
    ? LOG_DIR . 'registrations_' . date('Y-m') . '.log' 
    : LOG_DIR . basename($selectedLog);

// Read log entries
$entries = [];
if (file_exists($currentLog)) {
    $lines = file($currentLog, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        $decoded = json_decode($line, true);
        if (is_array($decoded)) {
            $entries[] = $decoded;
        }
    }
    $entries = array_reverse($entries);
}

// Statistics
$totalRegistrations = count($entries);
$todayCount = 0;
$currentDate = date('Y-m-d');
foreach ($entries as $entry) {
    if (!empty($entry['timestamp']) && date('Y-m-d', strtotime($entry['timestamp'])) === $currentDate) {
        $todayCount++;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Premium Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            --secondary-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
            --success-gradient: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%);
            --warning-gradient: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);
            --dark-bg: #0f1419;
            --sidebar-bg: #1a1d29;
            --card-bg: #ffffff;
            --text-primary: #2d3748;
            --text-secondary: #718096;
            --border-color: #e2e8f0;
            --shadow-light: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-medium: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
            --shadow-large: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            font-size: 14px;
            line-height: 1.6;
        }

        .sidebar {
            background: var(--sidebar-bg);
            min-height: 100vh;
            width: 280px;
            position: fixed;
            left: 0;
            top: 0;
            z-index: 1000;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-large);
        }

        .sidebar-header {
            padding: 2rem 1.5rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-title {
            color: #ffffff;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .sidebar-nav {
            padding: 1.5rem 0;
        }

        .nav-item {
            margin: 0.25rem 1rem;
        }

        .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 0.875rem 1.25rem;
            border-radius: 12px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.875rem;
            transition: all 0.3s ease;
            font-weight: 500;
        }

        .nav-link:hover,
        .nav-link.active {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transform: translateX(4px);
        }

        .main-content {
            margin-left: 280px;
            padding: 2rem;
            transition: all 0.3s ease;
        }

        .dashboard-header {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-light);
            margin-bottom: 2rem;
            border: 1px solid var(--border-color);
        }

        .dashboard-title {
            font-size: 2.25rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .dashboard-subtitle {
            color: var(--text-secondary);
            font-size: 1rem;
            margin-top: 0.5rem;
            font-weight: 400;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 2rem;
        }

        .stat-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 2rem;
            box-shadow: var(--shadow-light);
            border: 1px solid var(--border-color);
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-medium);
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-gradient);
        }

        .stat-card.warning::before {
            background: var(--warning-gradient);
        }

        .stat-card.success::before {
            background: var(--success-gradient);
        }

        .stat-card.secondary::before {
            background: var(--secondary-gradient);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 1rem;
        }

        .stat-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: var(--text-secondary);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            margin: 0;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            color: #ffffff;
            background: var(--primary-gradient);
        }

        .stat-card.warning .stat-icon {
            background: var(--warning-gradient);
        }

        .stat-card.success .stat-icon {
            background: var(--success-gradient);
        }

        .stat-card.secondary .stat-icon {
            background: var(--secondary-gradient);
        }

        .stat-value {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            line-height: 1;
        }

        .stat-change {
            font-size: 0.875rem;
            color: #10b981;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.25rem;
            margin-top: 0.5rem;
        }

        .data-card {
            background: var(--card-bg);
            border-radius: 20px;
            box-shadow: var(--shadow-light);
            border: 1px solid var(--border-color);
            overflow: hidden;
        }

        .data-card-header {
            padding: 2rem 2rem 1rem;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
        }

        .data-card-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin: 0;
            display: flex;
            align-items: center;
            gap: 0.75rem;
        }

        .data-card-body {
            padding: 0;
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            margin: 0;
            border-collapse: separate;
            border-spacing: 0;
        }

        .table thead th {
            background: #f8fafc;
            border: none;
            padding: 1.25rem 1.5rem;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .table tbody td {
            padding: 1.25rem 1.5rem;
            border-top: 1px solid var(--border-color);
            color: var(--text-primary);
            font-weight: 500;
        }

        .table tbody tr:hover {
            background: #f8fafc;
        }

        .user-avatar {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: var(--primary-gradient);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.875rem;
        }

        .user-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .user-details h6 {
            margin: 0;
            font-weight: 600;
            color: var(--text-primary);
            font-size: 0.875rem;
        }

        .user-details span {
            color: var(--text-secondary);
            font-size: 0.75rem;
        }

        .badge-status {
            padding: 0.375rem 0.75rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .badge-active {
            background: #dcfce7;
            color: #166534;
        }

        .badge-inactive {
            background: #fef3c7;
            color: #92400e;
        }

        /* DataTables Customization */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter,
        .dataTables_wrapper .dataTables_info,
        .dataTables_wrapper .dataTables_paginate {
            margin: 1rem 1.5rem;
        }

        .dataTables_wrapper .dataTables_filter input {
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 0.5rem 1rem;
            margin-left: 0.5rem;
        }

        .dataTables_wrapper .dataTables_length select {
            border: 2px solid var(--border-color);
            border-radius: 10px;
            padding: 0.5rem;
            margin: 0 0.5rem;
        }

        .page-link {
            border: none;
            padding: 0.5rem 1rem;
            margin: 0 0.125rem;
            border-radius: 8px;
            color: var(--text-primary);
            font-weight: 500;
        }

        .page-link:hover {
            background: var(--primary-gradient);
            color: #ffffff;
        }

        .page-item.active .page-link {
            background: var(--primary-gradient);
            border: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
                padding: 1rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .dashboard-title {
                font-size: 1.75rem;
            }
        }

        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid rgba(255, 255, 255, 0.3);
            border-radius: 50%;
            border-top-color: #ffffff;
            animation: spin 1s ease-in-out infinite;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .btn-premium {
            background: var(--primary-gradient);
            border: none;
            color: #ffffff;
            padding: 0.75rem 1.5rem;
            border-radius: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            font-size: 0.875rem;
            transition: all 0.3s ease;
            box-shadow: var(--shadow-light);
        }

        .btn-premium:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-medium);
            color: #ffffff;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <nav class="sidebar">
        <div class="sidebar-header">
            <h3 class="sidebar-title">
                <i class="fas fa-crown"></i>
                Admin Panel
            </h3>
        </div>
        <div class="sidebar-nav">
            <div class="nav-item">
                <a href="#" class="nav-link active">
                    <i class="fas fa-tachometer-alt"></i>
                    Dashboard
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-users"></i>
                    User Management
                </a>
            </div>
            <!-- <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-chart-bar"></i>
                    Analytics
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-cog"></i>
                    Settings
                </a>
            </div>
            <div class="nav-item">
                <a href="#" class="nav-link">
                    <i class="fas fa-file-alt"></i>
                    Reports
                </a>
            </div> -->
            <div class="nav-item">
    <a href="logout.php" class="nav-link">
        <i class="fas fa-sign-out-alt"></i>
        Logout
    </a>
</div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Dashboard Header -->
        <div class="dashboard-header">
            <h1 class="dashboard-title">
                <i class="fas fa-chart-line"></i>
                Dashboard Overview
            </h1>
            <p class="dashboard-subtitle">Welcome back! Here's what's happening with your platform today.</p>
        </div>

        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div>
                        <h5 class="stat-title">Total Users Attemp</h5>
                        <h2 class="stat-value"><?= number_format($totalAdmins) ?></h2>
                       
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>

            <!-- <div class="stat-card success">

                <div class="stat-header">
                    <div>
                        <h5 class="stat-title">Total Registrations</h5>
                        <h2 class="stat-value"><?= number_format($totalRegistrations) ?></h2>
                        <div class="stat-change">
                            <i class="fas fa-arrow-up"></i>
                            +8% from last week
                        </div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-user-plus"></i>
                    </div>
                </div>
            </div> -->

            <!-- <div class="stat-card warning">
                <div class="stat-header">
                    <div>
                        <h5 class="stat-title">Today's Registrations</h5>
                        <h2 class="stat-value"><?= number_format($todayCount) ?></h2>
                        <div class="stat-change">
                            <i class="fas fa-arrow-up"></i>
                            +5% from yesterday
                        </div>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-calendar-day"></i>
                    </div>
                </div>
            </div> -->

                <!-- <div class="stat-card secondary">
                    <div class="stat-header">
                        <div>
                            <h5 class="stat-title">Active Sessions</h5>
                            <h2 class="stat-value">1,247</h2>
                            <div class="stat-change">
                                <i class="fas fa-arrow-up"></i>
                                Live tracking
                            </div>
                        </div>
                        <div class="stat-icon">
                            <i class="fas fa-signal"></i>
                        </div>
                    </div>
                </div> -->
            </div>

        <!-- Users Table -->
        <div class="data-card">
            <div class="data-card-header">
                <h3 class="data-card-title">
                    <i class="fas fa-users-cog"></i>
                    User Management
                </h3>
            </div>
            <div class="data-card-body">
                <div class="table-container">
                    <table class="table" id="adminTable">
                        <thead>
                            <tr>
                                <th>User</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Last Login</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($adminUsers as $index => $admin): ?>
                                <tr>
                                    <td>
                                        <div class="user-info">
                                            <div class="user-avatar">
                                                <?= strtoupper(substr(htmlspecialchars($admin['username']), 0, 2)) ?>
                                            </div>
                                            <div class="user-details">
                                                <h6><?= htmlspecialchars($admin['username']) ?></h6>
                                                <span>Administrator</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td><?= htmlspecialchars($admin['email']) ?></td>
                                    <td>
                                        <span class="badge-status <?= ($index % 3 === 0) ? 'badge-active' : 'badge-active' ?>">
                                            <?= ($index % 3 === 0) ? 'Active' : 'Active' ?>
                                        </span>
                                    </td>
                                    <td><?= date('M j, Y g:i A', strtotime('-' . rand(1, 48) . ' hours')) ?></td>
                                    <td>
                                        <button class="btn btn-sm btn-premium">
                                            <i class="fas fa-edit"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
    
    <script>
        $(document).ready(function() {
            // Initialize DataTable with enhanced options
            $('#adminTable').DataTable({
                order: [[0, 'asc']],
                pageLength: 25,
                responsive: true,
                language: {
                    search: "Search users:",
                    lengthMenu: "Show _MENU_ users per page",
                    info: "Showing _START_ to _END_ of _TOTAL_ users",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columnDefs: [
                    { orderable: false, targets: [4] } // Disable sorting on Actions column
                ]
            });

            // Add smooth animations
            $('.stat-card').each(function(index) {
                $(this).css('animation-delay', (index * 0.1) + 's');
                $(this).addClass('animate__animated animate__fadeInUp');
            });

            // Add hover effects for navigation
            $('.nav-link').hover(
                function() {
                    $(this).find('i').addClass('fa-spin');
                },
                function() {
                    $(this).find('i').removeClass('fa-spin');
                }
            );

            // Add click animation for buttons
            $('.btn-premium').click(function(e) {
                e.preventDefault();
                $(this).addClass('loading');
                $(this).html('<span class="loading-spinner"></span>');
                
                setTimeout(() => {
                    $(this).removeClass('loading');
                    $(this).html('<i class="fas fa-edit"></i>');
                }, 2000);
            });
        });

        // Add some dynamic stats animation
        function animateValue(obj, start, end, duration) {
            let startTimestamp = null;
            const step = (timestamp) => {
                if (!startTimestamp) startTimestamp = timestamp;
                const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                obj.innerHTML = Math.floor(progress * (end - start) + start).toLocaleString();
                if (progress < 1) {
                    window.requestAnimationFrame(step);
                }
            };
            window.requestAnimationFrame(step);
        }

        // Animate stat values on page load
        window.addEventListener('load', function() {
            setTimeout(() => {
                const statValues = document.querySelectorAll('.stat-value');
                statValues.forEach(stat => {
                    const finalValue = parseInt(stat.textContent.replace(/,/g, ''));
                    animateValue(stat, 0, finalValue, 2000);
                });
            }, 500);
        });
    </script>
</body>

</html>
