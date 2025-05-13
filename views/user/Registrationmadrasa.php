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
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">  
    <?php include '../../includes/header.php'; ?>
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/registrationmadrasa.css">
    
    <!-- Success Message Modal -->
    <?php if (isset($_SESSION['registration_success']) && $_SESSION['registration_success']): ?>
    <div id="successModal" class="success-modal">
        <div class="success-modal-content">
            <span class="close-success-modal" onclick="closeSuccessModal()">&times;</span>
            <div class="success-icon">
                <i class="fa fa-check-circle"></i>
            </div>
            <h3>Registration Successful!</h3>
            <p><?php echo isset($_SESSION['registration_message']) ? $_SESSION['registration_message'] : 'Your registration has been submitted successfully.'; ?></p>
        </div>
    </div>
    <style>
        .success-modal {
            display: block;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
        }
        .success-modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 5px;
            width: 50%;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .success-icon {
            font-size: 50px;
            color: #4CAF50;
            margin-bottom: 15px;
        }
        .close-success-modal {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
    </style>
    <script>
        function closeSuccessModal() {
            document.getElementById("successModal").style.display = "none";
        }
        // Auto-close after 5 seconds
        setTimeout(function() {
            closeSuccessModal();
        }, 5000);
    </script>
    <?php 
    // Clear the session variables after showing the message
    unset($_SESSION['registration_success']);
    unset($_SESSION['registration_message']);
    ?>
    <?php endif; ?>
    
    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-background"></div> <!-- Background image container -->
        <div class="hero-content">
            <h2>About Registation For Madrasa</h2>
            <p>
            Registration for madrasa classes is now open for the upcoming term.
             Parents and guardians are encouraged to enroll their children early to secure a spot,
              as spaces are limited. The registration process is simple and can be completed online or in person at the madrasa office.
               Classes will cover Quranic studies, Islamic teachings, and basic Arabic, 
            tailored to different age groups. Don't miss the opportunity to give your child a strong foundation in faith and knowledge.
            </p>
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