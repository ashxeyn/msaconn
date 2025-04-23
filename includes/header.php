<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Two-Tone Header Design</title>
    <?php $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/msaconnect/'; ?>
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/header.css">
</head>
<body>
<header>
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
        </button>
    </div>

    <!-- Bottom Section: Navigation Bar -->
    <nav class="navbar">
        <ul class="nav-links">
            <li><a href="<?php echo $base_url; ?>views/user/landing_page" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'landing_page.php') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="<?php echo $base_url; ?>views/user/volunteer" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'volunteer.php' || basename($_SERVER['PHP_SELF']) == 'regVolunteer.php') ? 'active' : ''; ?>">Be a Volunteer</a></li>
            <li class="dropdown">
                <a href="<?php echo $base_url; ?>views/user/aboutus" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'aboutus.php') ? 'active' : ''; ?>">About MSA <span class="arrow"></span></a>
                <ul class="dropdown-content">
                    <li><a href="<?php echo $base_url; ?>views/user/aboutus" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'aboutus.php') ? 'active' : ''; ?>">About Us</a></li>
                    <li><a href="<?php echo $base_url; ?>views/user/Registrationmadrasa" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'Bylaws.php') ? 'active' : ''; ?>">Registration</a></li>
                    <li><a href="<?php echo $base_url; ?>views/user/transparencyreport" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'transparencyreport.php') ? 'active' : ''; ?>">Transparency</a></li>
                </ul>
            </li>
            <li><a href="<?php echo $base_url; ?>views/user/calendar" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'calendar.php') ? 'active' : ''; ?>">Calendar</a></li>
            <li><a href="<?php echo $base_url; ?>views/user/faqs" class="<?php echo (basename($_SERVER['PHP_SELF']) == 'faqs.php') ? 'active' : ''; ?>">FAQs</a></li>
        </ul>
    </nav>
</header>
<script src="<?php echo $base_url; ?>js/header.js"></script>
</body>
</html>