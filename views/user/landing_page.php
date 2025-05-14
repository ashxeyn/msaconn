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

<section id="home" class="carousel">
    <?php 
    $activeCarousel = array_slice($carousel, 0, 4);
    foreach ($activeCarousel as $key => $carouselItem) : 
        $isActive = ($key === 0) ? 'active' : '';
    ?>
    <div class="carousel-slide <?php echo $isActive; ?>">
        <div class="carousel-background" style="background-image: url('<?php echo $base_url . $carouselItem['image_path']; ?>');"></div>
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
            $imagePath = !empty($update['image_path']) ? $base_url . 'assets' . $update['image_path'] : $base_url . 'assets/images/login.jpg';
            
            // Count words instead of characters
            $words = explode(' ', $update['content']);
            $truncatedContent = (count($words) > 95) ? implode(' ', array_slice($words, 0, 95)) . '...' : $update['content'];
        ?>
        <div class="update-item">
            <div class="update-details">
                <img src="<?php echo $imagePath; ?>" alt="Update Image" class="update-image">
                <p class="update-date"><?php echo $formattedDate; ?></p>
<<<<<<< HEAD
                <h3 class="update-title"><?php echo $update['title']; ?></h3>
                <p class="update-content"><?php echo $truncatedContent; ?></p>
=======
                <h3 class="update-title"><?php echo clean_input($update['title']); ?></h3>
                <p class="update-content"><?php echo clean_article_content($update['content']); ?></p>
>>>>>>> e0ddf494fb59f4133807d71a85ddbe61e8882db2
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<section id="prayer-schedule" class="prayer-schedule">
    <h2>KHUTBAH SCHEDULE</h2>
    <div class="table-container">
        <div class="prayer-schedule-content" id="prayer-schedule-content">
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Day</th>
                        <th>Khateeb</th>
                        <th>Topic</th>
                        <th>Location</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($prayerSchedule as $prayer) : 
                        $dayName = date('l', strtotime($prayer['date']));
                    ?>
                    <tr>
                        <td><?php echo date('F j, Y', strtotime($prayer['date'])); ?></td>
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

<?php include '../../includes/footer.php'; ?>
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
</body>
</html>