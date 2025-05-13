<?php
require_once '../../classes/userClass.php';
$user = new User();

$faqs = $user->fetchFaqsInfo();
$backgroundImage = $user->fetchBackgroundImage();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs</title>
    <?php include '../../includes/header.php'; ?>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/faqs.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="../../js/website.js"></script>
</head>
<body>
    <!-- Hero Section -->
    <div class="hero">
        <?php foreach ($backgroundImage as $image) : ?>
        <div class="hero-background" style="background-image: url('<?php echo $base_url . $image['image_path']; ?>');"></div>
        <?php endforeach; ?>
            <div class="hero-content">
            <?php foreach ($faqs as $faq) : ?>
            <h2><?php echo $faq['title']; ?></h2>
            <p><?php echo $faq['description']; ?></p>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- FAQs Content -->
    <div class="faqs-content" id="faqs-content">  
        <!-- FAQs will be dynamically loaded here -->
    </div>

    <?php include '../../includes/footer.php'; ?>
    <script src="<?php echo $base_url; ?>js/user.js"></script>
</body>
</html>