<?php
require_once '../../classes/userClass.php';
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$userObj = new User();
$backgroundImage = $userObj->fetchBackgroundImage();
$registrationInfo = $userObj->fetchRegistrationInfo();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Madrasa</title>
</head>
<body>
    <?php
    session_start(); // Start the session to access session variables
    ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/website.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">  
    <?php include '../../includes/header.php'; ?>
    <link rel="stylesheet" href="../../css/registrationmadrasa.css">
    
    <!-- Success Message Modal -->
    <?php if (isset($_SESSION['madrasa_registration_success']) && $_SESSION['madrasa_registration_success']): ?>
    <?php 
    $modalPath = dirname(dirname(dirname(__FILE__))) . '/views/usermodals/registerformadrasamodal.php';
    include $modalPath;
    
    // Clear the session variables after showing the message
    unset($_SESSION['madrasa_registration_success']);
    unset($_SESSION['registration_message']);
    ?>
    <?php endif; ?>
    
    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-background" style="background-image: url('../../<?= $backgroundImage[0]['image_path']; ?>');"></div>
        <div class="hero-content">
            <?php foreach ($registrationInfo as $info) : ?>
            <h2><?php echo $info['title']; ?></h2>
            <p><?php echo $info['description']; ?></p>
            <?php endforeach; ?>
            <!-- Volunteer Now Button -->
            <div class="volunteer-button-container">
            <button class="volunteer-button" onclick="window.location.href='Registermadrasaform'">Registration Form</button>            
            </div>
        </div>
    </div>

    <!-- Volunteer Section -->
  

    <?php include '../../includes/footer.php'; ?>
</body>
</html>