<?php
// Include necessary files
require_once __DIR__.'/../../classes/userClass.php';

// Initialize User class
$user = new User();

try {
    // Fetch the latest about data
    $about_data = $user->getAboutMSAData();

    // Set default values if no data exists
    $mission = $about_data['mission'] ?? "Default mission text if none in database";
    $vision = $about_data['vision'] ?? "Default vision text if none in database";
    $description = $about_data['description'] ?? "Our website is dedicated to connecting volunteers...";
    
    // Fetch downloadable files
    $downloadableFiles = $user->fetchDownloadableFiles();
    
    // Debug: print the downloadable files
    echo "<!-- DEBUG: Files found: " . count($downloadableFiles) . " -->";
    if (empty($downloadableFiles)) {
        error_log("No downloadable files found in database");
    }
} catch (Exception $e) {
    // Handle the error gracefully
    error_log($e->getMessage());
    $mission = "Our mission statement";
    $vision = "Our vision statement";
    $description = "Our website is dedicated to connecting volunteers...";
    $downloadableFiles = [];
}

// Get base_url from header.php or define it here if not available
if (!isset($base_url)) {
    $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/msaconnect/';
}
?>
<?php include '../../includes/header.php'; ?>
<link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $base_url; ?>css/aboutus.css">

<!-- Hero Section -->
<section class="hero">
    <div class="hero-background"></div>
    <div class="hero-content">
        <h2>About Us</h2>
        <p><?php echo htmlspecialchars($description); ?></p>
    </div>
</section>

<!-- Mission and Vision Section -->
<section id="about" class="about-section">
    <div class="container">
        <div class="mission-vision">
            <div class="mission">
                <h3>Our Mission</h3>
                <p><?php echo htmlspecialchars($mission); ?></p>
            </div>
            <div class="vision">
                <h3>Our Vision</h3>
                <p><?php echo htmlspecialchars($vision); ?></p>
            </div>
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
            <ul class="social-links">
                <li><a href="#"><i class="fas fa-envelope"></i></a></li>
                <li><a href="#"><i class="fas fa-linkedin"></i></a></li>
            </ul>
        </div>
    </div>
    
    <!-- Preload Font Awesome script for icons -->
    <script>
        // Preload Font Awesome if not already loaded
        if (!document.querySelector('link[href*="font-awesome"]')) {
            const link = document.createElement('link');
            link.rel = 'preload';
            link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css';
            link.as = 'style';
            link.onload = function() { this.onload = null; this.rel = 'stylesheet'; };
            document.head.appendChild(link);
        }
    </script>
</section>

<section class="downloadable-files">
    <div class="container">
        <h2>Downloadable Resources</h2>
        <div class="downloads-list">
            <?php if (!empty($downloadableFiles)): ?>
                <?php foreach ($downloadableFiles as $file): ?>
                    <?php 
                        $fileExtension = pathinfo($file['file_name'], PATHINFO_EXTENSION);
                        $iconClass = 'file'; // Default icon class
                        
                        // Set icon class based on file type
                        if (stripos($file['file_type'], 'pdf') !== false) {
                            $iconClass = 'pdf';
                        } elseif (stripos($file['file_type'], 'word') !== false || $fileExtension == 'docx' || $fileExtension == 'doc') {
                            $iconClass = 'docx';
                        } elseif (stripos($file['file_type'], 'excel') !== false || $fileExtension == 'xlsx' || $fileExtension == 'xls') {
                            $iconClass = 'xlsx';
                        } elseif (stripos($file['file_type'], 'power') !== false || $fileExtension == 'pptx' || $fileExtension == 'ppt') {
                            $iconClass = 'pptx';
                        } elseif (stripos($file['file_type'], 'text') !== false || $fileExtension == 'txt') {
                            $iconClass = 'txt';
                        } elseif (stripos($file['file_type'], 'zip') !== false || $fileExtension == 'zip' || $fileExtension == 'rar') {
                            $iconClass = 'zip';
                        }
                        
                        // Format file size
                        $fileSize = isset($file['file_size']) ? intval($file['file_size']) : 0;
                        $formattedSize = '';
                        if ($fileSize < 1024) {
                            $formattedSize = $fileSize . ' B';
                        } elseif ($fileSize < 1048576) {
                            $formattedSize = round($fileSize / 1024, 2) . ' KB';
                        } else {
                            $formattedSize = round($fileSize / 1048576, 2) . ' MB';
                        }
                        
                        // Format date
                        $createdDate = '';
                        if (isset($file['created_at'])) {
                            $date = new DateTime($file['created_at']);
                            $createdDate = $date->format('F j, Y');
                        }
                    ?>
                    <a href="<?php echo $base_url; ?>handler/user/download.php?file_id=<?= $file['file_id'] ?>" class="download-card">
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
<?php include '../../includes/footer.php'; ?>