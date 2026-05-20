<?php
// admin/includes/header.php
require_once 'auth.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - Saksham Bharti</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f4f6f9;
        }

        .sidebar {
            min-height: 100vh;
            background-color: #1a2242;
            position: sticky;
            top: 0;
        }

        .sidebar a {
            color: #aeb4d1;
            text-decoration: none;
            padding: 12px 20px;
            display: block;
            border-radius: 8px;
            margin-bottom: 5px;
            transition: 0.3s;
            font-weight: 500;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background-color: #2f3e7a;
            color: white;
        }

        .hover-lift {
            transition: transform 0.2s ease;
        }

        .hover-lift:hover {
            transform: translateY(-5px);
        }

        .card {
            transition: box-shadow 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 1rem 3rem rgba(0, 0, 0, .1) !important;
        }
    </style>
</head>

<body>
    <div class="d-flex">
        <!-- Sidebar -->
        <div class="sidebar p-3 text-white d-flex flex-column" style="width: 260px;">
            <h4 class="fw-bold mb-4 text-center mt-3">Admin Panel</h4>
            <div class="mb-4 text-center px-2">
                <div class="small opacity-50 mb-1">Signed in as</div>
                <div class="fw-bold"><?= htmlspecialchars($_SESSION['admin_username']) ?></div>
            </div>
            <a href="index.php" class="<?= basename($_SERVER['PHP_SELF']) == 'index.php' ? 'active' : '' ?>"><i class="fas fa-chart-line me-2"></i> Dashboard</a>
            <a href="programs.php" class="<?= basename($_SERVER['PHP_SELF']) == 'programs.php' ? 'active' : '' ?>"><i class="fas fa-graduation-cap me-2"></i> Programs</a>
            <a href="activities.php" class="<?= basename($_SERVER['PHP_SELF']) == 'activities.php' ? 'active' : '' ?>"><i class="fas fa-newspaper me-2"></i> Activities/Blogs</a>
            <a href="donations.php" class="<?= basename($_SERVER['PHP_SELF']) == 'donations.php' ? 'active' : '' ?>"><i class="fas fa-hand-holding-heart me-2"></i> Donations</a>
            <a href="volunteers.php" class="<?= basename($_SERVER['PHP_SELF']) == 'volunteers.php' ? 'active' : '' ?>"><i class="fas fa-users me-2"></i> Volunteers</a>
            <a href="contacts.php" class="<?= basename($_SERVER['PHP_SELF']) == 'contacts.php' ? 'active' : '' ?>"><i class="fas fa-envelope me-2"></i> Messages</a>
            <a href="site_settings.php" class="<?= basename($_SERVER['PHP_SELF']) == 'site_settings.php' ? 'active' : '' ?>"><i class="fas fa-globe me-2"></i> Site Settings</a>
            <a href="settings.php" class="<?= basename($_SERVER['PHP_SELF']) == 'settings.php' ? 'active' : '' ?>"><i class="fas fa-cog me-2"></i> Account Settings</a>

            <a href="logout.php" class="text-danger mt-auto mb-3 border-top pt-3"><i class="fas fa-sign-out-alt me-2"></i> Logout</a>
        </div>
        <!-- Main Content -->
        <div class="flex-grow-1 p-4 p-md-5 w-100 overflow-auto" style="height: 100vh;">