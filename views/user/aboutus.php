<?php
require_once '../../classes/userClass.php';
require_once '../../tools/function.php';
require_once '../../classes/adminClass.php';

$userObj = new User();
$backgroundImage = $userObj->fetchBackgroundImage();
$aboutInfo = $userObj->fetchAboutInfo();

$adminObj = new Admin();
$missionVision = $adminObj->fetchAbouts();
$files = $adminObj->fetchDownloadableFiles();

if (!isset($base_url)) {
    $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/msaconn/';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/aboutus.css">
    <style>
        /* Essential fixes for sticky header */
        html, body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
            width: 100%;
        }
        
        body {
            padding-top: 0; /* Remove padding from body */
        }
        
        /* Move padding to main content instead of body */
        main#content {
            padding-top: 0; /* Let JS handle spacing */
        }
        
        /* Hero section specific fixes */
        .hero {
            position: relative;
            margin-top: 0; /* Let JS handle this dynamically */
            min-height: 400px;
            width: 100%;
            z-index: 1;
            box-sizing: border-box;
        }
        
        /* Fix any potential gap issues */
        header {
            margin-bottom: 0 !important;
        }
        
        /* Ensure hero background fills the space */
        .hero-background {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
        }
        
        @media (max-width: 768px) {
            main#content {
                padding-top: 0;
            }
            .hero {
                margin-top: 0; /* Let JS handle this */
            }
        }
        
        @media (max-width: 480px) {
            main#content {
                padding-top: 0;
            }
            .hero {
                margin-top: 0; /* Let JS handle this */
            }
        }
    </style>
</head>
<body>

<?php include '../../includes/header.php'; ?>

<!-- Hero Section -->
<section class="hero">
    <?php if(!empty($backgroundImage)): ?>
        <div class="hero-background" style="background-image: url('<?php echo $base_url . $backgroundImage[0]['image_path']; ?>');">
        </div>
    <?php endif; ?>
    <div class="hero-content">
        <?php if(!empty($aboutInfo)): ?>
            <h2><?php echo clean_input($aboutInfo[0]['title']); ?></h2>
            <p><?php echo clean_input($aboutInfo[0]['description']); ?></p>
        <?php endif; ?>
    </div>
</section>

<!-- Mission and Vision Section -->
<section id="about" class="about-section">
    <div class="container">
        <?php if(!empty($missionVision)): ?>
            <div class="mission-vision">
                <div class="mission">
                    <h3>Our Mission</h3>
                    <p><?php echo clean_input($missionVision[0]['mission']); ?></p>
                </div>
                <div class="vision">
                    <h3>Our Vision</h3>
                    <p><?php echo clean_input($missionVision[0]['vision']); ?></p>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Executive Team Section -->
<section class="executive-officers">
    <h2>Executive Officers</h2>
    
    <!-- Preload the default officer image -->
    <link rel="preload" href="<?php echo $base_url; ?>assets/images/officer.jpg" as="image">
    
    <div id="executive-officers-container">
        <!-- Initial placeholder card that will be replaced by JavaScript -->
        <div class="officer-card">
            <div class="blur-bg"></div>
            <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="Officer" class="officer-image">
            <h3 class="officer-name">Loading Officers...</h3>
            <p class="officer-position">Please wait a moment</p>
            <p class="officer-bio">Officer information is loading. This will only take a moment.</p>
        </div>
    </div>
</section>

<!-- Downloadable Files Section -->
<section class="downloadable-files">
    <div class="container">
        <h2>Downloadable Resources</h2>
        <div class="downloads-list">
            <?php if (!empty($files)): ?>
                <?php foreach ($files as $file): ?>
                    <?php 
                        $fileExtension = pathinfo($file['file_name'], PATHINFO_EXTENSION);
                        $iconClass = 'file'; 
                        
                        if (stripos($file['file_type'], 'pdf') !== false || $fileExtension == 'pdf') {
                            $iconClass = 'pdf';
                        } elseif (stripos($file['file_type'], 'word') !== false || $fileExtension == 'docx' || $fileExtension == 'doc') {
                            $iconClass = 'docx';
                        }
                        
                        $fileSize = isset($file['file_size']) ? intval($file['file_size']) : 0;
                        $formattedSize = '';
                        if ($fileSize < 1024) {
                            $formattedSize = $fileSize . ' B';
                        } elseif ($fileSize < 1048576) {
                            $formattedSize = round($fileSize / 1024, 2) . ' KB';
                        } else {
                            $formattedSize = round($fileSize / 1048576, 2) . ' MB';
                        }
                        
                        $createdDate = '';
                        if (isset($file['created_at'])) {
                            $date = new DateTime($file['created_at']);
                            $createdDate = $date->format('F j, Y');
                        }
                    ?>
                    <a href="<?php echo $base_url; ?>assets/downloadables/<?= clean_input($file['file_path']) ?>" download class="download-card">
                        <div class="download-icon <?= $iconClass ?>"></div>
                        <div class="download-info">
                            <span class="download-title"><?= htmlspecialchars($file['file_name']) ?></span>
                            <span class="download-type">(<?= strtoupper($fileExtension) ?>)</span>
                            <?php if ($formattedSize): ?>
                            <span class="download-size"><?= $formattedSize ?></span>
                            <?php endif; ?>
                            <?php if ($createdDate): ?>
                            <span class="download-date">Added: <?= $createdDate ?></span>
                            <?php endif; ?>
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="no-downloads">No downloadable resources available at this time.</p>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Scripts -->
<script src="<?php echo $base_url; ?>js/user.js"></script>
<script src="<?php echo $base_url; ?>js/designuser.js"></script>
<script src="<?php echo $base_url; ?>js/sticky-header.js"></script>

<?php include '../../includes/footer.php'; ?>
</body>
</html>