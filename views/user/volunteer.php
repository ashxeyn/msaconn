<?php
require_once '../../classes/userClass.php';

$user = new User();
$volunteerInfo = $user->fetchVolunteerInfo();
$backgroundImage = $user->fetchBackgroundImage();

if (isset($_GET['registration_success']) && $_GET['registration_success'] == '1') {
    $_SESSION['registration_success'] = true;
}

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
    <div class="hero-background" style="background-image: url('<?php echo $base_url . $image['image_path']; ?>');">
        <?php endforeach; ?>
    </div>
    <div class="hero-content">
            <?php foreach ($volunteerInfo as $info) : ?>
                <h2><?php echo $info['title']; ?></h2>
                <p><?php echo $info['description']; ?></p> 
            <?php endforeach; ?>
                    <div class="volunteer-button-container">
                        <a href="regVolunteer.php" class="volunteer-button">Volunteer Now!</a>
                    </div>
        </div>
    </div>

    <div class="volunteer-section">
        <h3>Our Volunteers</h3>
        <div id="volunteer-grid" class="volunteer-grid">
            <!-- Volunteers will be loaded here dynamically -->
        </div>
    </div>

    <?php include '../../includes/footer.php'; ?>

    <?php
    $show_modal = isset($_SESSION['registration_success']) || (isset($_GET['registration_success']) && $_GET['registration_success'] == '1');
    
    if ($show_modal) {
        include '../usermodals/registrationforvolunteermodal.php';
        unset($_SESSION['registration_success']);
        echo '<script>console.log("Modal included");</script>';
    } else {
        echo '<script>console.log("Modal not included: no success flag found");</script>';
    }
    ?>
    <script src="<?php echo $base_url; ?>js/user.js"></script>
</body>
</html>