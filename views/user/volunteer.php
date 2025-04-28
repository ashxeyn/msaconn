<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Volunteer</title>
    <link rel="stylesheet" href="../../css/volunteering.css">
</head>
<body>
    <?php include '../../includes/header.php'; ?>
    
    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-background"></div> <!-- Background image container -->
        <div class="hero-content">
            <h2>About Volunteering</h2>
            <p>
                Volunteering is about giving your time and skills to help others without expecting financial reward. 
                It’s a way to contribute to your community, make a difference, and gain new experiences. 
                Whether it’s helping at a local shelter, teaching, or cleaning up the environment, 
                volunteering brings people together and creates positive change.
            </p>
            <!-- Volunteer Now Button -->
            <div class="volunteer-button-container">
                <button class="volunteer-button" onclick="window.location.href='regVolunteer'">Volunteer Now!</button>
            </div>
        </div>
    </div>

    <!-- Volunteer Section -->
    <div class="volunteer-section">
        <h3>VOLUNTEERS</h3>
        <div class="volunteer-grid">
            <!-- Volunteer 1 -->
            <div class="volunteer">
                <p class="name">John Doe</p>
            </div>
            <!-- Volunteer 2 -->
            <div class="volunteer">
                <p class="name">Jane Smith</p>
            </div>
            <!-- Volunteer 3 -->
            <div class="volunteer">
                <p class="name">Mike Johnson</p>
            </div>
            <!-- Volunteer 4 -->
            <div class="volunteer">
                <p class="name">Sarah Brown</p>
            </div>
            <!-- Volunteer 5 -->
            <div class="volunteer">
                <p class="name">Chris Green</p>
            </div>
            <!-- Volunteer 6 -->
            <div class="volunteer">
                <p class="name">Emily White</p>
            </div>
            <!-- Volunteer 7 -->
            <div class="volunteer">
                <p class="name">David Black</p>
            </div>
            <!-- Volunteer 8 -->
            <div class="volunteer">
                <p class="name">Laura Blue</p>
            </div>
            <!-- Volunteer 9 -->
            <div class="volunteer">
                <p class="name">Kevin Yellow</p>
            </div>
        </div>
    </div>

    <?php include '../../includes/footer.php'; ?>

    <!-- Include the modal at the end of the body -->
    <?php
    if (isset($_SESSION['registration_success'])) {
        include '../usermodals/registrationforvolunteermodal.php';
        unset($_SESSION['registration_success']); // Clear the flag
    }
    ?>
</body>
</html>