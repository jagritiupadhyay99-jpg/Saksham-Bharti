<?php
require_once __DIR__ . '/../../backend/config/db.php';
require_once __DIR__ . '/../../backend/includes/functions.php';

// Page-level SEO defaults (can be overridden by individual pages before including header)
$page_title       = $page_title       ?? 'Saksham Bharti | Empowering Youth Through Skill & Education';
$page_description = $page_description ?? 'Saksham Bharti empowers underprivileged youth aged 17-23 through free vocational training in IT, beauty culture, and stitching across 5 centers in New Delhi.';

// Load site settings for dynamic top-bar contact info + social links
$site = get_all_site_settings();
$site_email    = $site['contact_email']  ?? 'info@sakshambharti.org';
$site_phone    = $site['contact_phone']  ?? '+91 98765 43210';
$site_phone_raw = preg_replace('/[^0-9+]/', '', $site_phone);
$site_fb       = $site['facebook_url']   ?? 'https://www.facebook.com/ngosakshambharti/';
$site_tw       = $site['twitter_url']    ?? 'https://x.com/bhartisaksham';
$site_ig       = $site['instagram_url']  ?? 'https://www.instagram.com/ngosakshambharti/';
$site_li       = $site['linkedin_url']   ?? 'https://in.linkedin.com/in/sakshambharti';

// Current page for active nav
$current_page = basename($_SERVER['PHP_SELF']);
function nav_active($page)
{
    global $current_page;
    return $current_page === $page ? 'active fw-bold' : '';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SEO: Title -->
    <title><?= htmlspecialchars($page_title) ?></title>
    <!-- SEO: Description -->
    <meta name="description" content="<?= htmlspecialchars($page_description) ?>">
    <!-- SEO: Keywords -->
    <meta name="keywords" content="Saksham Bharti, NGO India, vocational training, skill development, underprivileged youth, New Delhi NGO, free training, IT training, beauty culture, stitching">
    <!-- SEO: Robots -->
    <meta name="robots" content="index, follow">
    <!-- Open Graph for social sharing -->
    <meta property="og:title" content="<?= htmlspecialchars($page_title) ?>">
    <meta property="og:description" content="<?= htmlspecialchars($page_description) ?>">
    <meta property="og:type" content="website">
    <meta property="og:image" content="assets/images/about_who_we_are.png">
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="assets/images/image.png">
    <link rel="apple-touch-icon" href="assets/images/image.png">
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Outfit:wght@400;700;800&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="assets/css/style.css?v=<?= time() ?>">
    <!-- Chatbot CSS -->
    <link rel="stylesheet" href="assets/css/chatbot.css">
    <style>
        :root {
            --primary-bg: #1a2242;
            --accent-color: #f4a020;
        }

        .navbar-brand img {
            height: 45px;
            transition: 0.3s;
        }

        .brand-text {
            font-size: 1.3rem;
            letter-spacing: -0.5px;
            line-height: 1;
        }

        .top-info-link {
            font-size: 0.85rem;
            color: rgba(255, 255, 255, 0.9);
            text-decoration: none;
            transition: 0.3s;
            display: flex;
            align-items: center;
            font-weight: 500;
        }

        .top-info-link:hover {
            color: var(--accent-color);
        }

        .nav-link {
            font-weight: 500;
            font-size: 0.95rem;
            padding: 0.5rem 0.8rem !important;
            white-space: nowrap;
        }

        .nav-link.active {
            color: var(--accent-color) !important;
        }

        .btn-donate {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
            color: #fff;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-donate:hover {
            background-color: #e59410;
            border-color: #e59410;
            color: #fff;
            transform: translateY(-2px);
        }

        /* Form submit loading state */
        .btn-loading {
            position: relative;
            pointer-events: none;
            opacity: 0.75;
        }

        .btn-loading::after {
            content: '';
            display: inline-block;
            width: 14px;
            height: 14px;
            border: 2px solid rgba(255, 255, 255, 0.5);
            border-top-color: #fff;
            border-radius: 50%;
            animation: spin 0.7s linear infinite;
            margin-left: 8px;
            vertical-align: middle;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Dropdown Styling */
        .dropdown-menu {
            border-radius: 0.5rem;
            margin-top: 0;
        }
        .dropdown-item {
            font-weight: 500;
            transition: background-color 0.2s, color 0.2s;
        }
        .dropdown-item:hover, .dropdown-item:focus {
            background-color: var(--accent-color) !important;
            color: #fff !important;
        }
        .dropdown-item.active {
            background-color: var(--accent-color) !important;
            color: #fff !important;
            font-weight: bold;
        }
        
        /* Desktop Hover Dropdowns */
        @media (min-width: 992px) {
            .navbar-nav .nav-item.dropdown:hover .dropdown-menu {
                display: block;
                opacity: 1;
                visibility: visible;
                transform: translateY(0);
            }
            .navbar-nav .nav-item.dropdown .dropdown-menu {
                display: block;
                opacity: 0;
                visibility: hidden;
                transform: translateY(10px);
                transition: all 0.3s ease;
            }
        }
    </style>
</head>

<body>

    <!-- Unified Top Bar (dynamic from site_settings) -->
    <div class="top-bar py-2" style="background-color: var(--primary-bg); border-bottom: 1px solid rgba(255,255,255,0.1);">
        <div class="container-fluid px-lg-5 d-flex justify-content-between align-items-center">
            <div class="d-flex gap-4 align-items-center">
                <a href="mailto:<?= htmlspecialchars($site_email) ?>" class="top-info-link">
                    <i class="fas fa-envelope me-2" style="color: var(--accent-color);"></i>
                    <?= htmlspecialchars($site_email) ?>
                </a>
                <span class="text-white-50 d-none d-md-inline">|</span>
                <a href="tel:<?= htmlspecialchars($site_phone_raw) ?>" class="top-info-link d-none d-md-flex">
                    <i class="fas fa-phone-alt me-2" style="color: var(--accent-color);"></i>
                    <?= htmlspecialchars($site_phone) ?>
                </a>
            </div>
            <div class="d-flex gap-3">
                <?php if ($site_fb): ?><a href="<?= htmlspecialchars($site_fb) ?>" target="_blank" rel="noopener" class="text-white" style="font-size:0.9rem;"><i class="fab fa-facebook-f"></i></a><?php endif; ?>
                <?php if ($site_tw): ?><a href="<?= htmlspecialchars($site_tw) ?>" target="_blank" rel="noopener" class="text-white" style="font-size:0.9rem;"><i class="fab fa-twitter"></i></a><?php endif; ?>
                <?php if ($site_ig): ?><a href="<?= htmlspecialchars($site_ig) ?>" target="_blank" rel="noopener" class="text-white" style="font-size:0.9rem;"><i class="fab fa-instagram"></i></a><?php endif; ?>
                <?php if ($site_li): ?><a href="<?= htmlspecialchars($site_li) ?>" target="_blank" rel="noopener" class="text-white" style="font-size:0.9rem;"><i class="fab fa-linkedin-in"></i></a><?php endif; ?>
            </div>
        </div>
    </div>

    <nav class="navbar navbar-expand-lg sticky-top shadow-sm py-2" style="background-color: var(--primary-bg);">
        <div class="container-fluid px-lg-5">
            <a class="navbar-brand d-flex align-items-center" href="index.php">
                <img src="assets/images/image.png" alt="Saksham Bharti Logo" class="me-3">
                <div class="brand-text text-white fw-bold">
                    Saksham Bharti<br>
                    <span class="fw-normal" style="font-size: 0.55rem; text-transform: uppercase; letter-spacing: 1.5px; color: rgba(255,255,255,0.6);">AKSHAM SE SAKSHAM</span>
                </div>
            </a>

            <button class="navbar-toggler border-0 shadow-none" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-label="Toggle navigation">
                <i class="fas fa-bars text-white fs-2"></i>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <?php
                $resources_pages = ['blog.php', 'collaborators.php', 'gallery.php', 'annual-report.php', 'additional-activities.php', 'planet-friendly.php'];
                $get_involved_pages = ['volunteer.php', 'get-involved.php', 'scholarship.php'];
                $resources_active = in_array($current_page, $resources_pages) ? 'active fw-bold' : '';
                $get_involved_active = in_array($current_page, $get_involved_pages) ? 'active fw-bold' : '';
                ?>
                <ul class="navbar-nav ms-auto align-items-center gap-1">
                    <li class="nav-item"><a class="nav-link text-white <?= nav_active('index.php') ?>" href="index.php">Home</a></li>
                    <li class="nav-item"><a class="nav-link text-white <?= nav_active('about.php') ?>" href="about.php">About Us</a></li>
                    <li class="nav-item"><a class="nav-link text-white <?= nav_active('programs.php') ?>" href="programs.php">Programs</a></li>
                    <li class="nav-item"><a class="nav-link text-white <?= nav_active('impact.php') ?>" href="impact.php">Impact</a></li>
                    
                    <!-- Resources Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white <?= $resources_active ?>" href="#" id="navbarDropdownResources" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Resources
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark border-0 shadow-lg" aria-labelledby="navbarDropdownResources" style="background-color: var(--primary-bg);">
                            <li><a class="dropdown-item py-2 <?= nav_active('blog.php') ?>" href="blog.php">Blog</a></li>
                            <li><a class="dropdown-item py-2 <?= nav_active('collaborators.php') ?>" href="collaborators.php">Collaborators</a></li>
                            <li><a class="dropdown-item py-2 <?= nav_active('gallery.php') ?>" href="gallery.php">Gallery</a></li>
                            <li><a class="dropdown-item py-2 <?= nav_active('annual-report.php') ?>" href="annual-report.php">Annual Report</a></li>
                            <li><hr class="dropdown-divider border-white border-opacity-25 my-1"></li>
                            <li><a class="dropdown-item py-2 <?= nav_active('additional-activities.php') ?>" href="additional-activities.php"><i class="fas fa-star me-2 text-warning"></i>Additional Activities</a></li>
                            <li><a class="dropdown-item py-2 <?= nav_active('planet-friendly.php') ?>" href="planet-friendly.php"><i class="fas fa-leaf me-2 text-success"></i>Planet-Friendly Approaches</a></li>
                        </ul>
                    </li>

                    <!-- Get Involved Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle text-white <?= $get_involved_active ?>" href="#" id="navbarDropdownGetInvolved" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Get Involved
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark border-0 shadow-lg" aria-labelledby="navbarDropdownGetInvolved" style="background-color: var(--primary-bg);">
                            <li><a class="dropdown-item py-2 <?= nav_active('volunteer.php') ?>" href="volunteer.php">Volunteer</a></li>
                            <li><a class="dropdown-item py-2 <?= nav_active('get-involved.php') ?>" href="get-involved.php">Donate</a></li>
                            <li><a class="dropdown-item py-2 <?= nav_active('scholarship.php') ?>" href="scholarship.php">Scholarship</a></li>
                        </ul>
                    </li>

                    <li class="nav-item"><a class="nav-link text-white <?= nav_active('contact.php') ?>" href="contact.php">Contact Us</a></li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-donate rounded-pill px-4 py-2 shadow-sm" href="get-involved.php">Donate Now</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Form loading state script (applies site-wide to all form submit buttons) -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('form').forEach(function(form) {
                form.addEventListener('submit', function() {
                    const btn = form.querySelector('button[type="submit"]');
                    if (btn) {
                        const original = btn.innerHTML;
                        btn.classList.add('btn-loading');
                        btn.innerHTML = 'Submitting...';
                        // Safety: re-enable after 8s in case of error
                        setTimeout(function() {
                            btn.classList.remove('btn-loading');
                            btn.innerHTML = original;
                        }, 8000);
                    }
                });
            });
        });
    </script>

    <main class="min-vh-100">