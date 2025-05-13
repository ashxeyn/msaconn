<?php
session_start();
require_once '../../classes/userClass.php';

$user = new User();

// Check for URL parameter as fallback
if (isset($_GET['registration_success']) && $_GET['registration_success'] == '1') {
    $_SESSION['registration_success'] = true;
}

// Add debug message for session variable
$debug_session = isset($_SESSION['registration_success']) ? "Registration success is set" : "Registration success is NOT set";
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
    /* Add this to ensure modal displays properly */
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
    <!-- Debug message display -->
    <div style="background: yellow; padding: 5px; display: none;">
        <?php echo $debug_session; ?>
    </div>
    
    <?php include '../../includes/header.php'; ?>
    
    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-background"></div> <!-- Background image container -->
        <div class="hero-content">
            <h2>About Volunteering</h2>
            <p>
                Volunteering is about giving your time and skills to help others without expecting financial reward. 
                It's a way to contribute to your community, make a difference, and gain new experiences. 
                Whether it's helping at a local shelter, teaching, or cleaning up the environment, 
                volunteering brings people together and creates positive change.
            </p>
            <!-- Volunteer Now Button -->
                    <div class="volunteer-button-container">
                        <a href="regVolunteer.php" class="volunteer-button">Volunteer Now!</a>
                    </div>
        </div>
    </div>

    <?php include '../../includes/footer.php'; ?>

    <!-- Include the modal at the end of the body -->
    <?php
    // Use either session variable or URL parameter
    $show_modal = isset($_SESSION['registration_success']) || (isset($_GET['registration_success']) && $_GET['registration_success'] == '1');
    
    if ($show_modal) {
        include '../usermodals/registrationforvolunteermodal.php';
        // Clear the session flag
        unset($_SESSION['registration_success']);
        echo '<script>console.log("Modal included");</script>';
    } else {
        echo '<script>console.log("Modal not included: no success flag found");</script>';
    }
    ?>

    <script src="<?php echo $base_url; ?>js/user.js"></script>
</body>
</html>