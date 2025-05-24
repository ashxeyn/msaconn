<?php
require_once '../../classes/userClass.php';
require_once '../../tools/function.php';
$userObj = new User();
$footer = $userObj->fetchFooterInfo();
$logo = $userObj->fetchLogo();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer with Logo</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/website.js"></script>
    <link rel="stylesheet" href="../../css/footer.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">
</head>
<body>
    <footer>
        <div class="footer-content">
            <div class="footer-upper-left">
                <?php foreach ($logo as $logoItem): ?>
                    <img src="../../<?= clean_input($logoItem['image_path']); ?>" alt="MSA Connect Logo" class="logo">
                <?php endforeach; ?>
                <div class="logo-text">
                    <?php foreach ($footer as $foot): ?>
                        <p><strong><?= clean_input($foot['web_name']) ?></strong></p>
                        <p><?= clean_input($foot['school_name']) ?></p>
                    <?php endforeach; ?>
                </div>
            </div>

            <hr class="footer-divider">

            <div class="footer-middle">
                <div class="socials">
                    <a href="<?= clean_input($foot['fb_link']) ?>" target="_blank"><i class="fab fa-facebook"></i><p>MSA Official Facebook Page</p></a>
                </div>
                <div class="contact-info">
                    <p>Contact Us: <?= clean_input($foot['contact_no']) ?></p>
                    <p>Email: <?= clean_input($foot['email']) ?></p>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>