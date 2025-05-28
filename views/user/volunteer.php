<?php
require_once '../../classes/userClass.php';

$user = new User();
$volunteerInfo = $user->fetchVolunteerInfo();
$backgroundImage = $user->fetchBackgroundImage();

// Set session flag if URL parameter is present
if (isset($_GET['registration_success']) && $_GET['registration_success'] == '1') {
    $_SESSION['volunteer_registration_success'] = true;
}

$debug_session = isset($_SESSION['volunteer_registration_success']) ? "Registration success is set" : "Registration success is NOT set";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer</title>
    <link rel="stylesheet" href="../../css/volunteering.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">
    <style>
    #successModal.modal {
        display: block !important;
        position: fixed;
        z-index: 9999;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
    }
    </style>
</head>
<body>
    <div style="background: yellow; padding: 5px; display: none;">
        <?php echo $debug_session; ?>
    </div>
    
    <?php include '../../includes/header.php'; ?>
    
    <div class="hero">
        <?php foreach ($backgroundImage as $image) : ?>
    <div class="hero-background" style="background-image: url('../../<?= $image['image_path']; ?>');">
        <?php endforeach; ?>
    </div>
    <div class="hero-content">
            <?php foreach ($volunteerInfo as $info) : ?>
                <h2><?php echo $info['title']; ?></h2>
                <p><?php echo $info['description']; ?></p> 
            <?php endforeach; ?>
                    <div class="volunteer-button-container">
                        <a href="regVolunteer" class="volunteer-button">Volunteer Now</a>
                    </div>
        </div>
    </div>

    <div class="volunteer-section">
        <h2 style="font-size: 1.8rem; color: #1a541c; text-align: center; text-transform: uppercase; font-weight: 600; letter-spacing: 1px; margin-bottom: 30px; margin-top: -10px;">OUR DEDICATED VOLUNTEERS</h2>
        
        <div id="volunteer-grid" class="volunteer-grid">
            <!-- Volunteers will be loaded here dynamically -->
        </div>
        
    </div>

    <?php include '../../includes/footer.php'; ?>

    <?php
    // Show modal only once, then clear the session flag
    if (isset($_SESSION['volunteer_registration_success'])) {
        include '../usermodals/registrationforvolunteermodal.php';
        unset($_SESSION['volunteer_registration_success']);
        echo '<script>console.log("Registration success modal shown");</script>';
    }
    ?>
    <script src="../../js/user.js"></script>
</body>
</html>