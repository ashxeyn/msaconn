<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Madrasa</title>
</head>
<body>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">  
    <?php include '../../includes/header.php'; ?>
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/registrationmadrasa.css">
    
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
            tailored to different age groups. Don’t miss the opportunity to give your child a strong foundation in faith and knowledge.
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