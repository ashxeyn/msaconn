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
    <div id="executive-officers-container">
        <!-- Placeholder Executive Officers -->
        <div class="officer-card">
            <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="President" class="officer-image">
            <h3 class="officer-name">John Doe</h3>
            <p class="officer-position">President</p>
            <p class="officer-bio">Leading the MSA with dedication and vision.</p>
        </div>
        <div class="officer-card">
        <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="President" class="officer-image">
        <h3 class="officer-name">Jane Smith</h3>
            <p class="officer-position">Vice President</p>
            <p class="officer-bio">Supporting the organization's growth and development.</p>
        </div>
        <div class="officer-card">
        <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="President" class="officer-image">
        <h3 class="officer-name">Michael Johnson</h3>
            <p class="officer-position">Secretary</p>
            <p class="officer-bio">Managing communications and documentation.</p>
        </div>
        <div class="officer-card">
        <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="President" class="officer-image">
        <h3 class="officer-name">Sarah Williams</h3>
            <p class="officer-position">Treasurer</p>
            <p class="officer-bio">Overseeing financial matters and budgeting.</p>
        </div>
        <div class="officer-card">
        <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="President" class="officer-image">
        <h3 class="officer-name">David Brown</h3>
            <p class="officer-position">Event Coordinator</p>
            <p class="officer-bio">Planning and organizing MSA events and activities.</p>
        </div>
        <!-- 10 more officer cards -->
        <div class="officer-card">
        <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="President" class="officer-image">
        <h3 class="officer-name">Emily Clark</h3>
            <p class="officer-position">Public Relations Officer</p>
            <p class="officer-bio">Connecting MSA with the community and media.</p>
        </div>
        <div class="officer-card">
        <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="President" class="officer-image">
        <h3 class="officer-name">Chris Evans</h3>
            <p class="officer-position">Auditor</p>
            <p class="officer-bio">Ensuring transparency and accountability in all activities.</p>
        </div>
        <div class="officer-card">
        <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="President" class="officer-image">
        <h3 class="officer-name">Olivia Lee</h3>
            <p class="officer-position">Sports Coordinator</p>
            <p class="officer-bio">Promoting health and wellness through sports events.</p>
        </div>
        <div class="officer-card">
        <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="President" class="officer-image">
        <h3 class="officer-name">Daniel Kim</h3>
            <p class="officer-position">Logistics Head</p>
            <p class="officer-bio">Coordinating resources and event logistics.</p>
        </div>
        <div class="officer-card">
        <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="President" class="officer-image">
        <h3 class="officer-name">Sophia Martinez</h3>
            <p class="officer-position">Membership Chair</p>
            <p class="officer-bio">Welcoming and supporting new members.</p>
        </div>
        <div class="officer-card">
        <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="President" class="officer-image">
        <h3 class="officer-name">Liam Patel</h3>
            <p class="officer-position">IT Officer</p>
            <p class="officer-bio">Managing the MSA website and digital presence.</p>
        </div>
        <div class="officer-card">
        <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="President" class="officer-image">
        <h3 class="officer-name">Ava Garcia</h3>
            <p class="officer-position">Cultural Affairs</p>
            <p class="officer-bio">Celebrating diversity and organizing cultural events.</p>
        </div>
        <div class="officer-card">
        <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="President" class="officer-image">
        <h3 class="officer-name">Noah Wilson</h3>
            <p class="officer-position">Education Chair</p>
            <p class="officer-bio">Facilitating learning and educational programs.</p>
        </div>
        <div class="officer-card">
        <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="President" class="officer-image">
        <h3 class="officer-name">Mia Chen</h3>
            <p class="officer-position">Outreach Coordinator</p>
            <p class="officer-bio">Building partnerships and outreach initiatives.</p>
        </div>
        <div class="officer-card">
        <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="President" class="officer-image">
        <h3 class="officer-name">William Scott</h3>
            <p class="officer-position">Welfare Officer</p>
            <p class="officer-bio">Ensuring the well-being of all members.</p>
        </div>
        <div class="officer-card">
        <img src="<?php echo $base_url; ?>assets/images/officer.jpg" alt="President" class="officer-image">
        <h3 class="officer-name">Ella Rivera</h3>
            <p class="officer-position">Assistant Secretary</p>
            <p class="officer-bio">Assisting with records and correspondence.</p>
        </div>
    </div>
    <div class="scroll-buttons">
        <button class="scroll-button" onclick="scrollOfficers('left')">❮</button>
        <button class="scroll-button" onclick="scrollOfficers('right')">❯</button>
    </div>
</section>

<section class="downloadable-files">
    <div class="container">
        <h2>Downloadable Resources</h2>
        <div class="downloads-list">
            <a href="#" class="download-card">
                <div class="download-icon docx"></div>
                <div class="download-info">
                    <span class="download-title">Sample File</span>
                    <span class="download-type">(DOCX)</span>
                </div>
            </a>
            <a href="#" class="download-card">
                <div class="download-icon pdf"></div>
                <div class="download-info">
                    <span class="download-title">Sample File</span>
                    <span class="download-type">(PDF)</span>
                </div>
            </a>
        </div>
    </div>
</section>

<script src="<?php echo $base_url; ?>js/user.js"></script>
<script src="<?php echo $base_url; ?>js/designuser.js"></script>
<?php include '../../includes/footer.php'; ?>