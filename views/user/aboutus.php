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

// try {
//     // Fetch the latest about data
//     $about_data = $userObj->getAboutMSAData();

//     // Set default values if no data exists
//     $mission = $about_data['mission'] ?? "Default mission text if none in database";
//     $vision = $about_data['vision'] ?? "Default vision text if none in database";
//     $description = $about_data['description'] ?? "Our website is dedicated to connecting volunteers...";
    
//     // Fetch downloadable files
//     $downloadableFiles = $userObj->fetchDownloadableFiles();
    
//     // Debug: print the downloadable files
//     echo "<!-- DEBUG: Files found: " . count($downloadableFiles) . " -->";
//     if (empty($downloadableFiles)) {
//         error_log("No downloadable files found in database");
//     }
// } catch (Exception $e) {
//     error_log($e->getMessage());
//     $mission = "Our mission statement";
//     $vision = "Our vision statement";
//     $description = "Our website is dedicated to connecting volunteers...";
//     $downloadableFiles = [];
// }

if (!isset($base_url)) {
    $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/msaconnect/';
}
?>
<!-- Inline style for fixing sticky header specifically for aboutus page -->
<style>
body {
    margin: 0 !important;
    padding: 0 !important;
}
header {
    position: fixed !important;
    top: 0 !important;
    z-index: 999999 !important;
    width: 100% !important;
    left: 0 !important;
}
.header-top, .navbar {
    width: 100% !important;
}
main {
    margin-top: 0 !important;
    padding-top: 0 !important;
}
/* Ensure the hero section stays properly positioned with fixed header */
.hero {
    margin-top: 140px !important; /* Match the header height */
    min-height: 400px !important;
    height: auto !important;
}
</style>
<?php include '../../includes/header.php'; ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no, shrink-to-fit=no">
<link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $base_url; ?>css/aboutus.css">

<!-- Hero Section -->
<section class="hero">
    <?php foreach ($backgroundImage as $image) : ?>
        <div class="hero-background" style="background-image: url('<?php echo $base_url . $image['image_path']; ?>');">
        <?php endforeach; ?>
        </div>
    <div class="hero-content">
        <?php foreach ($aboutInfo as $info) : ?>
            <h2><?php echo clean_input($info['title']); ?></h2>
            <p><?php echo clean_input($info['description']); ?></p>
        <?php endforeach; ?>
    </div>
</section>

<!-- Mission and Vision Section -->
<section id="about" class="about-section">
    <div class="container">
        <div class="mission-vision">
            <div class="mission">
                <?php foreach ($missionVision as $info) : ?>
                <h3>Our Mission</h3>
                <p><?php echo clean_input($info['mission']); ?></p>
            </div>
            <div class="vision">
                <h3>Our Vision</h3>
                <p><?php echo clean_input($info['vision']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
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

<script src="<?php echo $base_url; ?>js/user.js"></script>
<script src="<?php echo $base_url; ?>js/designuser.js"></script>

<!-- Enhanced fix for sticky header -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Force header to be fixed with more aggressive approach
        const header = document.querySelector('header');
        if (header) {
            // Set fixed positioning with high z-index
            const headerStyles = {
                position: 'fixed !important',
                top: '0 !important',
                left: '0 !important',
                right: '0 !important',
                width: '100% !important',
                zIndex: '9999999 !important',
                backgroundColor: '#ffffff !important',
                boxShadow: '0 2px 10px rgba(0,0,0,0.2) !important'
            };
            
            // Apply styles directly to the element
            Object.entries(headerStyles).forEach(([key, value]) => {
                header.style.setProperty(key, value, 'important');
            });
            
            // Also set as inline style with !important to override any other styles
            header.setAttribute('style', 'position: fixed !important; top: 0 !important; left: 0 !important; right: 0 !important; width: 100% !important; z-index: 9999999 !important; background-color: #ffffff !important; box-shadow: 0 2px 10px rgba(0,0,0,0.2) !important;');
            
            // Get header height
            const headerHeight = header.offsetHeight;
            
            // Apply margin to the hero section
            const heroSection = document.querySelector('.hero');
            if (heroSection) {
                heroSection.style.setProperty('margin-top', headerHeight + 'px', 'important');
                
                // Apply consistent height
                heroSection.style.setProperty('min-height', '400px', 'important');
                
                console.log('Hero section configured: margin-top=' + headerHeight + 'px, min-height=400px');
            }
            
            // For small screens, adjust the margin
            function adjustHeroMargin() {
                if (window.innerWidth <= 768) {
                    heroSection.style.setProperty('margin-top', '120px', 'important');
                    
                    if (window.innerWidth <= 576) {
                        heroSection.style.setProperty('margin-top', '100px', 'important');
                    }
                    
                    if (window.innerWidth <= 480) {
                        heroSection.style.setProperty('margin-top', '90px', 'important');
                    }
                } else {
                    // Reset to header height for larger screens
                    heroSection.style.setProperty('margin-top', headerHeight + 'px', 'important');
                }
            }
            
            // Call once and add resize listener
            adjustHeroMargin();
            window.addEventListener('resize', adjustHeroMargin);
            
            console.log('Fixed header implemented with height: ' + headerHeight + 'px');
        }
    });
</script>

<?php include '../../includes/footer.php'; ?>