<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Tone Header Design</title>
    <?php $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/msaconnect/'; ?>
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/header.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">
</head>
<body>
<header>
    <!-- Top Section: Logo and MSA CONNECT -->
    <div class="header-top">
        <div class="logo">
            <a href="#" onclick="loadHomePage()">
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
        </button>
    </div>

    <!-- Bottom Section: Navigation Bar -->
    <nav class="navbar">
        <ul class="nav-links">
            <li><a href="#" onclick="loadHomePage()" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'landing_page') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="#" onclick="loadVolunteerPage()" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'volunteer' || basename($_SERVER['PHP_SELF']) == 'regVolunteer') ? 'active' : ''; ?>">Be a Volunteer</a></li>
            <li class="dropdown">
                <a href="#" onclick="loadAboutUsPage()" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'aboutus') ? 'active' : ''; ?>">About MSA <span class="arrow"></span></a>
                <ul class="dropdown-content">
                    <li><a href="#" onclick="loadAboutUsPage()" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'aboutus') ? 'active' : ''; ?>">About Us</a></li>
                    <li><a href="#" onclick="loadRegistrationPage()" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'Registrationmadrasa') ? 'active' : ''; ?>">Registration</a></li>
                    <li><a href="#" onclick="loadTransparencyPage()" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'transparencyreport') ? 'active' : ''; ?>">Transparency</a></li>
                </ul>
            </li>
            <li><a href="#" onclick="loadCalendarPage()" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'calendar') ? 'active' : ''; ?>">Calendar</a></li>
            <li><a href="#" onclick="loadFAQsPage()" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'faqs') ? 'active' : ''; ?>">FAQs</a></li>
        </ul>
    </nav>
</header>
<script src="<?php echo $base_url; ?>js/header.js?v=<?php echo time(); ?>"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
</html>