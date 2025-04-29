<?php
require_once '../../classes/userClass.php';
$user = new User();

// Fetch FAQs from the database
$faqs = $user->fetchUserFaqs();
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
</head>
<body>
    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-background"></div> <!-- Background image container -->
        <div class="hero-content">
            <h2>Frequently Asked Questions</h2>
            <p>
                Find answers to common questions about our organization, activities, and how you can get involved.
            </p>
        </div>
    </div>

    <!-- FAQs Content -->
    <div class="faqs-content">
        <?php
        $currentCategory = null;
        foreach ($faqs as $faq) {
            if ($currentCategory !== $faq['category']) {
                if ($currentCategory !== null) {
                    echo '</div>'; // Close previous category section
                }
                $currentCategory = $faq['category'];
                echo '<h3>' . htmlspecialchars($currentCategory) . '</h3>';
                echo '<div class="faq-category">';
            }
            ?>
            <div class="faq-item">
                <div class="faq-question">
                    <?php echo htmlspecialchars($faq['question']); ?>
                    <span class="arrow">▼</span>
                </div>
                <div class="faq-answer">
                    <?php echo nl2br(htmlspecialchars($faq['answer'])); ?>
                </div>
            </div>
            <?php
        }
        if ($currentCategory !== null) {
            echo '</div>'; // Close the last category section
        }
        ?>
    </div>

    <?php include '../../includes/footer.php'; ?>
    <script src="<?php echo $base_url; ?>js/faqs.js"></script>
</body>
</html>