<?php
ob_start();
include '../../includes/header.php';
require_once '../../classes/userClass.php';
require_once '../../classes/adminClass.php';

$userObj = new User();
$carousel = $userObj->fetchCarousel();
$home = $userObj->fetchHome();
$orgUpdates = $userObj->fetchOrgUpdatesWithImages();

$adminObj = new Admin();
$prayerSchedule = $adminObj->fetchPrayerSchedule();
?>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="../../js/website.js"></script>
<link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">
<link rel="stylesheet" href="../../css/user.landingpage.css">
<link rel="stylesheet" href="../../css/shared-tables.css">

<style>
    /* Make update items show cursor pointer and have a hover effect */
    .update-link {
        cursor: pointer;
        transition: transform 0.3s ease;
        display: block;
    }
    
    .update-link:hover .update-item {
        transform: translateY(-5px);
        box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
    }
</style>

<section id="home" class="carousel">
    <?php 
    $activeCarousel = array_slice($carousel, 0, 4);
    foreach ($activeCarousel as $key => $carouselItem) : 
        $isActive = ($key === 0) ? 'active' : '';
    ?>
    <div class="carousel-slide <?php echo $isActive; ?>">
        <div class="carousel-background" style="background-image: url('../../<?= $carouselItem['image_path']; ?>');"></div>
        <div class="carousel-overlay"></div>
        <?php if ($key === 0) : ?>
        <div class="hero-content">
            <?php foreach ($home as $homeItem) : ?>
                <h2><?php echo $homeItem['title']; ?></h2>
                <p><?php echo $homeItem['description']; ?></p>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endforeach; ?>
    
    <button class="carousel-button prev" aria-label="Previous slide">❮</button>
    <button class="carousel-button next" aria-label="Next slide">❯</button>

    <div class="carousel-indicators">
        <?php for ($i = 0; $i < count($activeCarousel); $i++) : ?>
            <span class="indicator <?php echo ($i === 0) ? 'active' : ''; ?>" data-slide="<?php echo $i; ?>"></span>
        <?php endfor; ?>
    </div>
</section>
<section id="latest-updates" class="latest-updates">
    <h2>LATEST UPDATES</h2>
    <div id="updates-container" class="updates-container">
        <?php 
        $limitedUpdates = array_slice($orgUpdates, 0, 4);
        foreach ($limitedUpdates as $update) : 
            $formattedDate = date('F j, Y', strtotime($update['created_at']));
            $imagePath = !empty($update['image_path']) ? '../../assets' . $update['image_path'] : '../../assets/images/login.jpg';
            
            // Count words instead of characters
            $words = explode(' ', $update['content']);
            $truncatedContent = (count($words) > 95) ? implode(' ', array_slice($words, 0, 95)) . '...' : $update['content'];
        ?>
        <div class="update-item" data-update-id="<?php echo $update['update_id']; ?>">
            <div class="update-details">
                <img src="<?php echo $imagePath; ?>" alt="Update Image" class="update-image">
                <p class="update-date"><?php echo $formattedDate; ?></p>
                <h3 class="update-title"><?php echo clean_input($update['title']); ?></h3>
                <p class="update-content"><?php echo clean_article_content($truncatedContent); ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<!-- News article container for dynamic loading -->
<div id="dynamic-news-container" style="display: none;"></div>

<!-- Prayer Schedule Section -->
<section id="prayer-schedule" class="table-section">
  <div class="container" style="max-width: 1140px; width: 100%; margin-left: auto; margin-right: auto; padding-left: 15px; padding-right: 15px;">
    <h2>KHUTBAH SCHEDULE</h2>
    <div class="table-container" style="background-color: #ffffff; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15); border: 1px solid #f0f0f0; overflow-x: auto; -webkit-overflow-scrolling: touch;">
      <table class="msa-table" style="min-width: 650px;">
        <thead>
          <tr>
            <th style="min-width: 120px;">Date</th>
            <th style="min-width: 80px;">Time</th>
            <th style="min-width: 80px;">Day</th>
            <th style="min-width: 100px;">Khateeb</th>
            <th style="min-width: 120px;">Topic</th>
            <th style="min-width: 100px;">Location</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($prayerSchedule as $prayer) : 
              $dayName = date('l', strtotime($prayer['date']));
          ?>
          <tr>
            <td><?php echo date('F j, Y', strtotime($prayer['date'])); ?></td>
            <td><?php echo isset($prayer['time']) ? date('h:i A', strtotime($prayer['time'])) : 'N/A'; ?></td>
            <td><?php echo $dayName; ?></td>
            <td><?php echo $prayer['speaker']; ?></td>
            <td><?php echo $prayer['topic']; ?></td>
            <td><?php echo $prayer['location']; ?></td>
          </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- Add responsive styles -->
<style>
  @media (max-width: 768px) {
    #prayer-schedule .container {
      padding-left: 10px;
      padding-right: 10px;
    }
    
    #prayer-schedule h2 {
      font-size: 1.5rem;
      margin-bottom: 15px;
    }
    
    #prayer-schedule .table-container {
      margin-bottom: 20px;
    }
  }
  
  @media (max-width: 480px) {
    #prayer-schedule .container {
      padding-left: 5px;
      padding-right: 5px;
    }
    
    #prayer-schedule h2 {
      font-size: 1.3rem;
      margin-bottom: 10px;
    }
    
    /* Show a hint about scrolling on very small screens */
    #prayer-schedule .table-container::after {
      content: "Scroll horizontally to view full table →";
      display: block;
      text-align: center;
      padding: 8px 0;
      font-size: 12px;
      color: #666;
      background-color: #f8f8f8;
      border-top: 1px solid #eee;
    }
  }
</style>

<?php include '../../includes/footer.php'; ?>
<script src="../../js/table-fix.js"></script>
<script>
  document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('header');
    if (header) {
      header.style.cssText = `
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        z-index: 9999999 !important;
      `;
      
      const headerHeight = header.offsetHeight;
      document.body.style.paddingTop = headerHeight + 'px';
      
      console.log('Header fixed with JS:', {
        height: headerHeight,
        position: window.getComputedStyle(header).position
      });
    }
  });
</script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Get all update items
    const updateItems = document.querySelectorAll('.update-item');
    const updatesContainer = document.getElementById('updates-container');
    const dynamicNewsContainer = document.getElementById('dynamic-news-container');
    
    // Add click event listener to each update item
    updateItems.forEach(item => {
        item.addEventListener('click', function() {
            const updateId = this.getAttribute('data-update-id');
            loadNewsArticle(updateId);
        });
        
        // Make the cursor a pointer to indicate it's clickable
        item.style.cursor = 'pointer';
    });
    
    // Function to load news article
    function loadNewsArticle(updateId) {
        // Show loading indicator
        dynamicNewsContainer.innerHTML = '<div style="text-align: center; padding: 20px;"><h3>Loading article...</h3></div>';
        dynamicNewsContainer.style.display = 'block';
        
        // Hide the updates container
        updatesContainer.style.display = 'none';
        
        // Scroll to top
        window.scrollTo({ top: 0, behavior: 'smooth' });
        
        // Fetch the article content
        fetch(`news.php?id=${updateId}&ajax=1`)
            .then(response => response.text())
            .then(html => {
                dynamicNewsContainer.innerHTML = html;
                
                // Add a back button
                const backButton = document.createElement('button');
                backButton.textContent = 'Back to Updates';
                backButton.className = 'back-button';
                backButton.style.cssText = 'margin: 20px 0; padding: 10px 15px; background-color: var(--primary-color); color: white; border: none; border-radius: 4px; cursor: pointer;';
                
                backButton.addEventListener('click', function() {
                    // Hide news container and show updates again
                    dynamicNewsContainer.style.display = 'none';
                    updatesContainer.style.display = 'grid';
                    document.querySelector('.latest-updates h2').scrollIntoView({ behavior: 'smooth' });
                });
                
                // Insert back button at the top of the article
                const articleContainer = dynamicNewsContainer.querySelector('.article-container');
                if (articleContainer) {
                    articleContainer.insertBefore(backButton, articleContainer.firstChild);
                    
                    // Add another back button at the bottom
                    const bottomBackButton = backButton.cloneNode(true);
                    bottomBackButton.addEventListener('click', function() {
                        dynamicNewsContainer.style.display = 'none';
                        updatesContainer.style.display = 'grid';
                        document.querySelector('.latest-updates h2').scrollIntoView({ behavior: 'smooth' });
                    });
                    articleContainer.appendChild(bottomBackButton);
                }
            })
            .catch(error => {
                console.error('Error loading article:', error);
                dynamicNewsContainer.innerHTML = '<div style="text-align: center; padding: 20px;"><h3>Error loading article. Please try again.</h3></div>';
            });
    }
});
</script>
</body>
</html>