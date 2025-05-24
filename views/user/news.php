<?php
ob_start();

// Check if this is an AJAX request
$isAjax = isset($_GET['ajax']) && $_GET['ajax'] == 1;
// Check if this is a sidebar-only update request
$isSidebarUpdate = $isAjax && isset($_GET['sidebar_only']) && $_GET['sidebar_only'] == 1;

// If not an AJAX request, include the header

require_once '../../classes/userClass.php';
require_once '../../tools/function.php';

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
    include_sidebar($updateId, $allUpdates);
    exit();
}

// Format the date for full requests
$formattedDate = date('F j, Y', strtotime($article['created_at']));

// Get the default image path with fallback
$defaultImagePath = !empty($article['image_path']) ? '../../assets' . $article['image_path'] : '../../assets/images/login.jpg';

// Function to render the sidebar
function include_sidebar($currentId, $updates) {
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
                        $imagePath = !empty($update['image_path']) ? '../../assets' . $update['image_path'] : '../../assets/images/login.jpg';
                        
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
<link rel="stylesheet" href="../../css/news-header-fix.css">

<style>
.page-container {
    display: flex;
    min-height: calc(100vh - 120px);
    height: 100%; /* Ensure it takes full height */
    flex-direction: row;
}

.article-container {
    flex: 1;
    padding-right: 20px;
    max-height: calc(100vh - 120px); /* Maximum height for scrolling */
    height: calc(100vh - 120px); /* Fixed height to enable scrolling */
    min-height: calc(100vh - 120px); /* Minimum height to ensure it fills the screen */
    overflow-y: auto; /* Enable vertical scrolling */
    position: relative;
    scrollbar-width: none; /* Hide scrollbar in Firefox */
    -ms-overflow-style: none; /* Hide scrollbar in IE and Edge */
    background: #fff;
}

/* Hide scrollbar for Webkit browsers */
.article-container::-webkit-scrollbar {
    display: none;
}

/* Ensure content is properly positioned within the article container */
.article-content {
    width: 100%;
    height: auto;
    min-height: 100%;
    display: block;
}

/* For short content that doesn't fill the viewport */
.short-content {
    overflow: visible !important; /* Override auto-scrolling */
    height: auto !important;     /* Allow container to shrink to content */
    min-height: auto !important; /* Remove minimum height constraint */
    max-height: none !important; /* Remove maximum height constraint */
}

.sidebar-container {
    width: 350px;
    overflow-y: auto;
    height: 100vh; /* Full viewport height for sidebar */
    position: sticky;
    top: 0;
    padding-left: 10px;
    border-left: 1px solid #e0e0e0;
    scrollbar-width: none; /* Firefox */
    -ms-overflow-style: none; /* IE and Edge */
    background: #fff;
}

.sidebar-container::-webkit-scrollbar {
    display: none; /* Chrome, Safari, Opera */
}

.sidebar-header {
    background-color: #f5f5f5; /* Dirty white color */
    color: #000; /* Black text */
    padding: 10px;
    padding-top: 20px; /* Additional top padding to move text down */
    font-weight: bold;
}

@media (max-width: 900px) {
  .sidebar-container {
    width: 280px;
    padding-left: 0;
  }
  .article-container {
    padding-right: 10px;
  }
}

@media (max-width: 700px) {
  .page-container {
    flex-direction: column;
    min-height: 0 !important;
    height: auto !important;
  }
  .article-container {
    max-height: none !important;
    height: auto !important;
    min-height: 0 !important;
  }
  .sidebar-container {
    width: 100%;
    height: auto !important;
    min-height: 0 !important;
    max-height: none !important;
    position: static;
    border-left: none;
    border-top: 1px solid #e0e0e0;
    margin-top: 20px;
    padding: 0 0 20px 0;
  }
}

@media (max-width: 480px) {
  .sidebar-header {
    font-size: 1rem;
    padding: 8px 4px 8px 4px;
  }
  .sidebar-container {
    padding: 0 0 15px 0;
  }
  .article-header h1.article-title {
    font-size: 1.2rem;
  }
  .article-date {
    font-size: 0.9rem;
  }
}
</style>

<?php if (!$isAjax) { ?>
<!-- Meta tags for JavaScript -->
<meta name="article-id" content="<?php echo $updateId; ?>">
<meta name="base-url" content="<?php echo $base_url; ?>">
<!-- JavaScript -->
<script src="../../js/news.js"></script>
<script src="../../js/news-header-fix.js"></script>
<script>
// Function to check for article updates
function checkForArticleUpdates() {
    const articleId = document.querySelector('meta[name="article-id"]').content;
    const baseUrl = document.querySelector('meta[name="base-url"]').content;
    
    // Fetch the current article data from handler
    fetch(`${baseUrl}handler/user/get_article.php?id=${articleId}&timestamp=${new Date().getTime()}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Update article title if changed
                const currentTitle = document.querySelector('.article-title').innerText;
                if (data.article.title !== currentTitle) {
                    document.querySelector('.article-title').innerText = data.article.title;
                }
                
                // Update article date if changed
                const currentDate = document.querySelector('.article-date').innerText;
                const newDate = new Date(data.article.created_at).toLocaleDateString('en-US', {
                    year: 'numeric', month: 'long', day: 'numeric'
                });
                if (newDate !== currentDate) {
                    document.querySelector('.article-date').innerText = newDate;
                }
                
                // Update article content if changed
                const articleContent = document.querySelector('.article-content');
                if (articleContent.innerHTML !== data.article.content) {
                    articleContent.innerHTML = data.article.content;
                }
                
                // Update image if changed
                const mainImage = document.querySelector('.article-main-image');
                if (mainImage && data.article.image_path) {
                    const newImagePath = baseUrl + 'assets' + data.article.image_path;
                    if (mainImage.src !== newImagePath) {
                        mainImage.src = newImagePath;
                    }
                }

                // If there are gallery images, update them
                if (data.article.images && data.article.images.length > 0) {
                    const galleryContainer = document.querySelector('.article-gallery') || document.createElement('div');
                    if (!document.querySelector('.article-gallery')) {
                        galleryContainer.className = 'article-gallery';
                        
                        // Replace the single image container with gallery if it exists
                        const singleImageContainer = document.querySelector('.article-image-container');
                        if (singleImageContainer) {
                            singleImageContainer.parentNode.replaceChild(galleryContainer, singleImageContainer);
                        } else {
                            // Add after the article header
                            document.querySelector('.article-header').after(galleryContainer);
                        }
                    }
                    
                    // Clear and rebuild gallery
                    galleryContainer.innerHTML = '';
                    data.article.images.forEach(image => {
                        const imagePath = baseUrl + 'assets' + image.file_path;
                        const imgDiv = document.createElement('div');
                        imgDiv.className = 'gallery-image';
                        imgDiv.innerHTML = `<img src="${imagePath}" alt="${data.article.title}" class="article-img">`;
                        galleryContainer.appendChild(imgDiv);
                    });
                }
            }
        })
        .catch(error => console.error('Error checking for updates:', error));
}

// Check for updates every 5 seconds
setInterval(checkForArticleUpdates, 5000);

// Add event listener to prevent scrolling beyond article container
document.addEventListener('DOMContentLoaded', function() {
    const articleContainer = document.querySelector('.article-container');
    const articleContent = document.querySelector('.article-content');
    
    // Ensure short content is fully visible and long content scrolls
    function adjustArticleHeight() {
        // Force reflow to get accurate measurements
        articleContainer.style.overflow = 'visible';
        const containerHeight = articleContainer.clientHeight;
        const contentHeight = Math.max(
            articleContent.scrollHeight,
            articleContent.offsetHeight,
            articleContent.getBoundingClientRect().height
        );
        
        console.log('Container height:', containerHeight, 'Content height:', contentHeight);
        
        // If content is shorter than container, make it fully visible
        if (contentHeight <= containerHeight) {
            articleContainer.classList.add('short-content');
            articleContainer.style.overflow = 'visible';
            articleContainer.style.display = 'flex';
            articleContainer.style.flexDirection = 'column';
            articleContent.style.flex = '1';
        } else {
            // Content is longer, enable scrolling
            articleContainer.classList.remove('short-content');
            articleContainer.style.overflow = 'auto';
            articleContainer.style.overflowX = 'hidden';
        }
    }
    
    // Initial adjustment
    adjustArticleHeight();
    
    // Run again after images and other resources load
    window.addEventListener('load', adjustArticleHeight);
    
    // Run on window resize
    window.addEventListener('resize', adjustArticleHeight);
    
    // Re-check periodically in case dynamic content changes (like images loading)
    setTimeout(adjustArticleHeight, 1000);
    
    articleContainer.addEventListener('wheel', function(e) {
        // If content is marked as short, allow normal page scrolling
        if (articleContainer.classList.contains('short-content')) {
            return;
        }
        
        const { scrollTop, scrollHeight, clientHeight } = this;
        
        // If scrolled to the top and trying to scroll further up
        if(scrollTop === 0 && e.deltaY < 0) {
            e.preventDefault();
        }
        
        // We allow natural scrolling at the article's bottom
    }, { passive: false });
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
                    <?php $imagePath = '../../assets' . $image['file_path']; ?>
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
        
        <?php include_sidebar($updateId, $allUpdates); ?>
    </div>
    
</main>

<?php if (!$isAjax) { // Only include these for non-AJAX requests ?>
<?php 
    include '../../includes/footer.php'; 
} 
?>
