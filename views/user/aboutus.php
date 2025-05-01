<?php
// Include necessary files
require_once __DIR__.'/../../classes/userClass.php';
require_once __DIR__.'/../../includes/helpers.php'; // Make sure this includes the helper functions

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/aboutus.css">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic:wght@400;600;700&display=swap" rel="stylesheet">
</head>
<body>
    <?php include '../../includes/header.php'; ?>

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
    <section class="org-chart">
        <h2>Executive Officers</h2>
        <div class="org-tree">
            <!-- Level 1 - CEO -->
            <div class="level-1">
                <div class="org-node">
                    <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="Sarah Johnson">
                    <div class="org-details">
                        <p class="org-name">Sarah Johnson</p>
                        <p class="org-position">Chief Executive Officer</p>
                    </div>
                    <div class="connector connector-1"></div>
                </div>
            </div>
            
            <!-- Level 2 - Department Heads -->
            <div class="level-2">
                <div class="connector connector-2"></div>
                
                <!-- CTO -->
                <div class="org-node">
                    <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="Michael Chen">
                    <div class="org-details">
                        <p class="org-name">Michael Chen</p>
                        <p class="org-position">Chief Technology Officer</p>
                    </div>
                    <div class="connector connector-3"></div>
                </div>
                
                <!-- CFO -->
                <div class="org-node">
                    <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="David Wilson">
                    <div class="org-details">
                        <p class="org-name">David Wilson</p>
                        <p class="org-position">Chief Financial Officer</p>
                    </div>
                    <div class="connector connector-3"></div>
                </div>
                
                <!-- CMO -->
                <div class="org-node">
                    <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="Emily Rodriguez">
                    <div class="org-details">
                        <p class="org-name">Emily Rodriguez</p>
                        <p class="org-position">Chief Marketing Officer</p>
                    </div>
                    <div class="connector connector-3"></div>
                </div>
            </div>
            
            <!-- Level 3 - Managers -->
            <div class="level-3">
                <!-- Tech Department -->
                <div class="org-node">
                    <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="James Park">
                    <div class="org-details">
                        <p class="org-name">James Park</p>
                        <p class="org-position">Tech Lead</p>
                    </div>
                </div>
                
                <div class="org-node">
                    <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="Lisa Wong">
                    <div class="org-details">
                        <p class="org-name">Lisa Wong</p>
                        <p class="org-position">UX Manager</p>
                    </div>
                </div>
                
                <!-- Finance Department -->
                <div class="org-node">
                    <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="Robert Kim">
                    <div class="org-details">
                        <p class="org-name">Robert Kim</p>
                        <p class="org-position">Finance Manager</p>
                    </div>
                </div>
                
                <!-- Marketing Department -->
                <div class="org-node">
                    <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="Sophia Martinez">
                    <div class="org-details">
                        <p class="org-name">Sophia Martinez</p>
                        <p class="org-position">Digital Marketing Manager</p>
                    </div>
                </div>
                
                <div class="org-node">
                    <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="Thomas Brown">
                    <div class="org-details">
                        <p class="org-name">Thomas Brown</p>
                        <p class="org-position">Community Manager</p>
                    </div>
                </div>
                
                <!-- HR Department -->
                <div class="org-node">
                    <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="Jennifer Lee">
                    <div class="org-details">
                        <p class="org-name">Jennifer Lee</p>
                        <p class="org-position">HR Manager</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="downloads-section">
    <div class="content-wrapper">
        <h2 class="section-title">Downloadable Files</h2>
        <div id="downloads-list" class="downloads-list">
            <?php if (!empty($downloadableFiles)): ?>
                <?php foreach ($downloadableFiles as $file): ?>
                    <div class="download-item" data-file-id="<?= $file['file_id'] ?>">
                        <div class="file-info">
                            <div class="file-icon"><?= getFileIcon($file['file_type']) ?></div>
                            <div class="file-details">
                                <h3 class="file-name"><?= htmlspecialchars($file['file_name']) ?></h3>
                                <div class="file-meta">
                                    <span class="file-size"><?= formatFileSize($file['file_size']) ?></span>
                                    <span class="file-date"><?= formatDate($file['created_at']) ?></span>
                                </div>
                            </div>
                        </div>
                        <a href="../../handler/user/download.php?file_id=<?= $file['file_id'] ?>" 
                           class="download-btn" 
                           download="<?= htmlspecialchars($file['file_name']) ?>"
                           title="Download <?= htmlspecialchars($file['file_name']) ?>">
                            Download
                        </a>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="no-files">No downloadable files available.</div>
            <?php endif; ?>
        </div>
    </div>
</section>

    <script src="<?php echo $base_url; ?>js/user.js"></script>
    <?php include '../../includes/footer.php'; ?>
</body>
</html>