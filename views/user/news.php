<?php
ob_start();

$isAjax = isset($_GET['ajax']) && $_GET['ajax'] == 1;
$isSidebarUpdate = $isAjax && isset($_GET['sidebar_only']) && $_GET['sidebar_only'] == 1;


require_once '../../classes/userClass.php';
require_once '../../tools/function.php';

$updateId = isset($_GET['id']) ? intval($_GET['id']) : 0;

$userObj = new User();

if (!$isSidebarUpdate) {
    $article = $userObj->fetchOrgUpdateById($updateId);

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

$allUpdates = $userObj->fetchAllOrgUpdates();

if ($isSidebarUpdate) {
    include_sidebar($updateId, $allUpdates);
    exit();
}

$formattedDate = date('F j, Y', strtotime($article['created_at']));

$defaultImagePath = !empty($article['image_path']) ? '../../assets' . $article['image_path'] : '../../assets/images/login.jpg';

function include_sidebar($currentId, $updates) {
    ?>
    <div class="sidebar-container">
        <div class="sidebar-header">Latest Updates</div>
        <?php 
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
                        
                        $content = '';
                        if (isset($update['content'])) {
                            $cleanContent = html_entity_decode(strip_tags($update['content']));
                            $cleanContent = preg_replace('/\s+/', ' ', trim($cleanContent));
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

if (!$isAjax || !isset($_GET['no_css'])) {
?>
<link rel="stylesheet" href="../../css/user.landingpage.css">
<link rel="stylesheet" href="../../css/news.css">
<link rel="stylesheet" href="../../css/news-header-fix.css">

<style>
.page-container {
    display: flex;
    min-height: calc(100vh - 120px);
    height: 100%; 
    flex-direction: row;
}

.article-container {
    flex: 1;
    padding-right: 20px;
    max-height: calc(100vh - 120px); 
    height: calc(100vh - 120px); 
    min-height: calc(100vh - 120px); 
    overflow-y: auto; 
    position: relative;
    scrollbar-width: none; 
    -ms-overflow-style: none; 
    background: #fff;
}

.article-container::-webkit-scrollbar {
    display: none;
}

.article-content {
    width: 100%;
    height: auto;
    min-height: 100%;
    display: block;
}

.short-content {
    overflow: visible !important; 
    height: auto !important;     
    min-height: auto !important; 
    max-height: none !important; 
}

.sidebar-container {
    width: 350px;
    overflow-y: auto;
    height: 100vh; 
    position: sticky;
    top: 0;
    padding-left: 10px;
    border-left: 1px solid #e0e0e0;
    scrollbar-width: none; 
    -ms-overflow-style: none; 
    background: #fff;
}

.sidebar-container::-webkit-scrollbar {
    display: none; 
}

.sidebar-header {
    background-color: #f5f5f5; 
    color: #000; 
    padding: 10px;
    padding-top: 20px; 
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
<meta name="article-id" content="<?php echo $updateId; ?>">
<meta name="base-url" content="<?php echo $base_url; ?>">
<script src="../../js/news.js"></script>
<script src="../../js/news-header-fix.js"></script>
<script>
function checkForArticleUpdates() {
    const articleId = document.querySelector('meta[name="article-id"]').content;
    const baseUrl = document.querySelector('meta[name="base-url"]').content;
    
    fetch(`${baseUrl}handler/user/get_article.php?id=${articleId}&timestamp=${new Date().getTime()}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                const currentTitle = document.querySelector('.article-title').innerText;
                if (data.article.title !== currentTitle) {
                    document.querySelector('.article-title').innerText = data.article.title;
                }
                
                const currentDate = document.querySelector('.article-date').innerText;
                const newDate = new Date(data.article.created_at).toLocaleDateString('en-US', {
                    year: 'numeric', month: 'long', day: 'numeric'
                });
                if (newDate !== currentDate) {
                    document.querySelector('.article-date').innerText = newDate;
                }
                
                const articleContent = document.querySelector('.article-content');
                if (articleContent.innerHTML !== data.article.content) {
                    articleContent.innerHTML = data.article.content;
                }
                
                const mainImage = document.querySelector('.article-main-image');
                if (mainImage && data.article.image_path) {
                    const newImagePath = baseUrl + 'assets' + data.article.image_path;
                    if (mainImage.src !== newImagePath) {
                        mainImage.src = newImagePath;
                    }
                }

                if (data.article.images && data.article.images.length > 0) {
                    const galleryContainer = document.querySelector('.article-gallery') || document.createElement('div');
                    if (!document.querySelector('.article-gallery')) {
                        galleryContainer.className = 'article-gallery';
                        
                        const singleImageContainer = document.querySelector('.article-image-container');
                        if (singleImageContainer) {
                            singleImageContainer.parentNode.replaceChild(galleryContainer, singleImageContainer);
                        } else {
                            document.querySelector('.article-header').after(galleryContainer);
                        }
                    }
                    
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

setInterval(checkForArticleUpdates, 5000);

document.addEventListener('DOMContentLoaded', function() {
    const articleContainer = document.querySelector('.article-container');
    const articleContent = document.querySelector('.article-content');
    
    function adjustArticleHeight() {
        articleContainer.style.overflow = 'visible';
        const containerHeight = articleContainer.clientHeight;
        const contentHeight = Math.max(
            articleContent.scrollHeight,
            articleContent.offsetHeight,
            articleContent.getBoundingClientRect().height
        );
        
        console.log('Container height:', containerHeight, 'Content height:', contentHeight);
        
        if (contentHeight <= containerHeight) {
            articleContainer.classList.add('short-content');
            articleContainer.style.overflow = 'visible';
            articleContainer.style.display = 'flex';
            articleContainer.style.flexDirection = 'column';
            articleContent.style.flex = '1';
        } else {
            articleContainer.classList.remove('short-content');
            articleContainer.style.overflow = 'auto';
            articleContainer.style.overflowX = 'hidden';
        }
    }
    
    adjustArticleHeight();
    
    window.addEventListener('load', adjustArticleHeight);
    
    window.addEventListener('resize', adjustArticleHeight);
    
    setTimeout(adjustArticleHeight, 1000);
    
    articleContainer.addEventListener('wheel', function(e) {
        if (articleContainer.classList.contains('short-content')) {
            return;
        }
        
        const { scrollTop, scrollHeight, clientHeight } = this;
        
        if(scrollTop === 0 && e.deltaY < 0) {
            e.preventDefault();
        }
        
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

<?php if (!$isAjax) {  ?>
<?php 
    include '../../includes/footer.php'; 
} 
?>
