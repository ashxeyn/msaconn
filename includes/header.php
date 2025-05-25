<?php
require_once '../../classes/userClass.php';
require_once '../../tools/function.php';
$userObj = new User();
$footer = $userObj->fetchFooterInfo();
$logo = $userObj->fetchLogo();

// Improved current page detection
$current_page = basename($_SERVER['PHP_SELF']);
$current_page_without_ext = pathinfo($current_page, PATHINFO_FILENAME);

// Helper function to check if current page matches
function is_current_page($page_names) {
    global $current_page, $current_page_without_ext;
    if (!is_array($page_names)) {
        $page_names = [$page_names];
    }
    
    foreach ($page_names as $page) {
        // Check with and without .php extension
        if ($current_page === $page || $current_page === "$page.php" || 
            $current_page_without_ext === $page) {
            return true;
        }
    }
    return false;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MSA Connect</title>
    <link rel="stylesheet" href="../../css/standardized-fonts.css?v=<?php echo time(); ?>">    
    <link rel="stylesheet" href="../../css/header.css?v=<?php echo time(); ?>">  
    <link rel="stylesheet" href="../../css/no-scrollbar.css?v=<?php echo time(); ?>">   
    <link rel="stylesheet" href="../../css/sticky-header-fix.css?v=<?php echo time(); ?>">
    <link rel="stylesheet" href="../../css/shared-tables.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Debug information
        console.log('Current PHP page: <?php echo $current_page; ?>');
        console.log('Full path: <?php echo $_SERVER["PHP_SELF"]; ?>');
    </script>
</head>
<body>
<header style="position: sticky !important; top: 0 !important; z-index: 99999 !important;">
    <!-- Top Section: Logo and MSA CONNECT -->
    <div class="header-top">
        <div class="logo">
            <a href="../../views/user/landing_page">
                <?php foreach ($logo as $logoItem): ?>
                    <img src="../../<?= clean_input($logoItem['image_path']); ?>" alt="MSA Connect Logo" class="logo">
                <?php endforeach; ?>
                <div class="logo-text-container">
                    <?php foreach ($footer as $foot): ?>
                        <span class="logo-text"><?= clean_input($foot['web_name']) ?></span>
                        <span class="logo-subtext"><?= clean_input($foot['org_name']) . ' | ' . clean_input($foot['school_name']) ?></span>
                    <?php endforeach; ?>
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
            <li><a href="../../views/user/landing_page" class="<?php echo is_current_page('landing_page.php') ? 'active' : ''; ?>">Home</a></li>
            <li><a href="../../views/user/volunteer" class="<?php echo is_current_page('volunteer.php') || is_current_page('regVolunteer.php') ? 'active' : ''; ?>">Be a Volunteer</a></li>
            <li class="dropdown">
                <a href="javascript:void(0);" class="<?php echo is_current_page('aboutus.php') || is_current_page('Registrationmadrasa.php') || is_current_page('transparencyreport.php') ? 'active' : ''; ?>">About MSA <span class="arrow"></span></a>
                <ul class="dropdown-content">
                    <li><a href="../../views/user/aboutus" class="<?php echo is_current_page('aboutus.php') ? 'active' : ''; ?>">About Us</a></li>
                    <li><a href="../../views/user/Registrationmadrasa" class="<?php echo is_current_page('Registrationmadrasa.php') ? 'active' : ''; ?>">Registration</a></li>
                    <li><a href="../../views/user/transparencyreport" class="<?php echo is_current_page('transparencyreport.php') ? 'active' : ''; ?>">Transparency</a></li>
                </ul>
            </li>
            <li><a href="../../views/user/calendar" class="<?php echo is_current_page('calendar.php') ? 'active' : ''; ?>">Calendar</a></li>
            <li><a href="../../views/user/faqs" class="<?php echo is_current_page('faqs.php') ? 'active' : ''; ?>">FAQs</a></li>
        </ul>
    </nav>
</header>

<main id="content">
<!-- Page content will be loaded here -->
</main>

<script src="../../js/header.js?v=<?php echo time(); ?>"></script>
</body>
</html>