<?php
require_once '../../classes/userClass.php';
require_once '../../tools/function.php';
$userObj = new User();
$footer = $userObj->fetchFooterInfo();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer with Logo</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/footer.css">
    <!-- Add Font Awesome for social media icons -->
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">
</head>
<body>
    <footer>
        <div class="footer-content">
            <!-- Upper Left: Logo, MSA CONNECT, and University Name -->
            <div class="footer-upper-left">
                <img src="<?php echo $base_url; ?>assets/images/msa_logo.png" alt="MSA Connect Logo" class="logo">
                <div class="logo-text">
                    <p><strong>MSA CONNECT</strong></p>
                    <p>Western Mindanao State University</p>
                </div>
            </div>

            <!-- Horizontal Line -->
            <hr class="footer-divider">

            <!-- Middle: Socials and Contact -->
            <div class="footer-middle">
            <?php foreach ($footer as $foot): ?>
                <div class="socials">
                    <a href="https://www.facebook.com/msawmsuofficial" target="_blank"><i class="fab fa-facebook"></i></a>
                </div>
                <div class="contact-info">
                    <p>Contact Us: <?= clean_input($foot['contact_no']) ?></p>
                    <p>Email:<?= clean_input($foot['email']) ?></p>
                </div>
            </div>
            <?php endforeach ?>
        </div>
    </footer>
</body>
</html>