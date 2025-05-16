<?php
ob_start();

// Check if this is an AJAX request
$isAjax = isset($_GET['ajax']) && $_GET['ajax'] == 1;
// Check if this is a sidebar-only update request
$isSidebarUpdate = $isAjax && isset($_GET['sidebar_only']) && $_GET['sidebar_only'] == 1;

// If not an AJAX request, include the header

require_once '../../classes/userClass.php';
require_once '../../tools/function.php';

// Define base_url if not already defined by header.php
if (!isset($base_url)) {
    $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/msaconn/';
}

// Get the update ID from the URL
$updateId = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Initialize user object
$userObj = new User();

// Fetch the specific update/article if not sidebar-only request
if (!$isSidebarUpdate) {
    $article = $userObj->fetchOrgUpdateById($updateId);

    // If no article found, redirect to homepage (only if not AJAX)
    if (!$article) {
        if (!$isAjax) {
            header("Location: landing_page.php");
            exit();
        } else {
            echo '<div class="error-message">Article not found.</div>';
            exit();
        }
    }
}

// Fetch all updates for the sidebar
$allUpdates = $userObj->fetchAllOrgUpdates();

// If this is a sidebar-only update request, only output the sidebar
if ($isSidebarUpdate) {
    include_sidebar($updateId, $allUpdates, $base_url);
    exit();
}

// Format the date for full requests
$formattedDate = date('F j, Y', strtotime($article['created_at']));

// Get the default image path with fallback
$defaultImagePath = !empty($article['image_path']) ? $base_url . 'assets' . $article['image_path'] : $base_url . 'assets/images/login.jpg';

// Function to render the sidebar
function include_sidebar($currentId, $updates, $base_url) {
    ?>
    <div class="sidebar-container">
        <div class="sidebar-header">Latest Updates</div>
        <?php 
        // Filter out the current article from the sidebar
        $filteredUpdates = array_filter($updates, function($update) use ($currentId) {
            return $update['id'] != $currentId;
        });
        
        if (!empty($filteredUpdates)): 
        ?>
            <ul class="updates-list">
                <?php foreach ($filteredUpdates as $update): ?>
                    <?php 
                        $updateDate = date('F j, Y', strtotime($update['created_at']));
                        $imagePath = !empty($update['image_path']) ? $base_url . 'assets' . $update['image_path'] : $base_url . 'assets/images/login.jpg';
                        
                        // Get content excerpt if available
                        $content = '';
                        if (isset($update['content'])) {
                            // Clean and decode HTML entities
                            $cleanContent = html_entity_decode(strip_tags($update['content']));
                            $cleanContent = preg_replace('/\s+/', ' ', trim($cleanContent));
                            // Count words for truncation
                            $words = explode(' ', $cleanContent);
                            $content = (count($words) > 30) ? implode(' ', array_slice($words, 0, 30)) . '...' : $cleanContent;
                        }
                    ?>
                    <li class="update-item <?php echo ($update['id'] == $currentId) ? 'active' : ''; ?>" data-id="<?php echo $update['id']; ?>">
                        <a href="news.php?id=<?php echo $update['id']; ?>" class="update-link">
                            <img src="<?php echo $imagePath; ?>" alt="" class="sidebar-image">
                            <div class="sidebar-content">
                                <div class="sidebar-date"><?php echo $updateDate; ?></div>
                                <h3 class="sidebar-title"><?php echo htmlspecialchars($update['title']); ?></h3>
                                <?php if (!empty($content)): ?>
                                <div class="sidebar-excerpt"><?php echo htmlspecialchars($content); ?></div>
                                <?php endif; ?>
                            </div>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php else: ?>
            <p class="no-updates">No other updates available.</p>
        <?php endif; ?>
    </div>
    <?php
}

// Include CSS only if not an AJAX request or if it's AJAX but first load
if (!$isAjax || !isset($_GET['no_css'])) {
?>
<link rel="stylesheet" href="../../css/user.landingpage.css">
<link rel="stylesheet" href="../../css/news.css">

<?php if (!$isAjax) { ?>
<!-- Meta tags for JavaScript -->
<meta name="article-id" content="<?php echo $updateId; ?>">
<meta name="base-url" content="<?php echo $base_url; ?>">
<!-- JavaScript -->
<script src="../../js/news.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Ensure the sidebar scrollbar works
    const sidebar = document.querySelector('.sidebar-container');
    if (sidebar) {
        sidebar.style.overflowY = 'auto';
    }
});
</script>
<?php } ?>
<?php 
}
?>
<?php include '../../includes/header.php'; ?>
<main>
    <div class="page-container">
        <div class="article-container">
            <div class="article-header">
                <h1 class="article-title"><?php echo clean_input($article['title']); ?></h1>
                <p class="article-date"><?php echo $formattedDate; ?></p>
            </div>
            
            <?php if (!empty($article['images']) && count($article['images']) > 0): ?>
            <div class="article-gallery">
                <?php foreach ($article['images'] as $image): ?>
                    <?php $imagePath = $base_url . 'assets' . $image['file_path']; ?>
                    <div class="gallery-image">
                        <img src="<?php echo $imagePath; ?>" alt="<?php echo clean_input($article['title']); ?>" class="article-img">
                    </div>
                <?php endforeach; ?>
            </div>
            <?php else: ?>
            <div class="article-image-container">
                <img src="<?php echo $defaultImagePath; ?>" alt="<?php echo clean_input($article['title']); ?>" class="article-main-image">
            </div>
            <?php endif; ?>
            
            <div class="article-content">
                <?php echo clean_article_content($article['content']); ?>
            </div>
            
        </div>
        
        <?php include_sidebar($updateId, $allUpdates, $base_url); ?>
    </div>
    
</main>

<?php if (!$isAjax) { // Only include these for non-AJAX requests ?>
<?php 
    include '../../includes/footer.php'; 
} 
?>
