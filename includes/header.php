<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Tone Header Design</title>
    <?php $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/msaconn/'; ?>
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/header.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/sticky-header.css">
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/no-scrollbar.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<header style="position: sticky !important; top: 0 !important; z-index: 99999 !important;">
    <!-- Top Section: Logo and MSA CONNECT -->
    <div class="header-top">
        <div class="logo">
            <a href="<?php echo $base_url; ?>views/user/landing_page">
                <img src="<?php echo $base_url; ?>assets/images/msa_logo.png" class="logo-image">
                <div class="logo-text-container">
                    <span class="logo-text">MSA CONNECT</span>
                    <span class="logo-subtext">Muslim Student Association | Western Mindanao State University</span>
                </div>
            </a>
        </div>
        <!-- Mobile Menu Toggle Button -->
        <button class="menu-toggle" aria-label="Toggle navigation">
            <span class="hamburger"></span>
            <span class="hamburger"></span>
            <span class="hamburger"></span>
        </button>
    </div>

    <!-- Bottom Section: Navigation Bar -->
    <nav class="navbar">
        <ul class="nav-links">
            <li><a href="<?php echo $base_url; ?>views/user/landing_page" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'landing_page') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="<?php echo $base_url; ?>views/user/volunteer" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'volunteer' || basename($_SERVER['PHP_SELF']) == 'regVolunteer') ? 'active' : ''; ?>">Be a Volunteer</a></li>
            <li class="dropdown">
                <a href="javascript:void(0);" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'aboutus' || basename($_SERVER['PHP_SELF']) == 'Registrationmadrasa' || basename($_SERVER['PHP_SELF']) == 'transparencyreport') ? 'active' : ''; ?>">About MSA <span class="arrow"></span></a>
                <ul class="dropdown-content">
                    <li><a href="<?php echo $base_url; ?>views/user/aboutus" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'aboutus') ? 'active' : ''; ?>">About Us</a></li>
                    <li><a href="<?php echo $base_url; ?>views/user/Registrationmadrasa" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'Registrationmadrasa') ? 'active' : ''; ?>">Registration</a></li>
                    <li><a href="<?php echo $base_url; ?>views/user/transparencyreport" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'transparencyreport') ? 'active' : ''; ?>">Transparency</a></li>
                </ul>
            </li>
            <li><a href="<?php echo $base_url; ?>views/user/calendar" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'calendar') ? 'active' : ''; ?>">Calendar</a></li>
            <li><a href="<?php echo $base_url; ?>views/user/faqs" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'faqs') ? 'active' : ''; ?>">FAQs</a></li>
        </ul>
    </nav>
</header>

<main id="content">
<!-- Page content will be loaded here -->
</main>

<script src="<?php echo $base_url; ?>js/header.js?v=<?php echo time(); ?>"></script>
</body>
</html>