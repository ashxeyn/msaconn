<?php
// Remove all whitespace before DOCTYPE to prevent rendering issues
ob_start();
include '../../includes/header.php';
require_once '../../classes/userClass.php';

$userObj = new User();
?>

<link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $base_url; ?>css/user.landingpage.css">

<section id="home" class="carousel">
    <!-- Slide 1 -->
    <div class="carousel-slide active">
        <div class="carousel-background" style="background-image: url('<?php echo $base_url; ?>assets/images/msa-hero-collage.jpg');"></div>
        <div class="carousel-overlay"></div>
        <div class="hero-content">
            <h2>Welcome to MSA CONNECT</h2>
            <p>Your gateway to the Muslim Student Association community and activities.</p>
        </div>
    </div>
    <!-- Slide 2 -->
    <div class="carousel-slide">
        <div class="carousel-background" style="background-image: url('<?php echo $base_url; ?>assets/images/msa-hero-collage.jpg');"></div>
        <div class="carousel-overlay"></div>
        <div class="hero-content">
            <h2>Prayer Times</h2>
            <p>Stay updated with daily prayer schedules and Friday prayer information.</p>
        </div>
    </div>
    <!-- Slide 3 -->
    <div class="carousel-slide">
        <div class="carousel-background" style="background-image: url('<?php echo $base_url; ?>assets/images/msa-hero-collage.jpg');"></div>
        <div class="carousel-overlay"></div>
        <div class="hero-content">
            <h2>Events & Activities</h2>
            <p>Discover upcoming events, workshops, and community gatherings.</p>
        </div>
    </div>
    <!-- Slide 4 -->
    <div class="carousel-slide">
        <div class="carousel-background" style="background-image: url('<?php echo $base_url; ?>assets/images/msa-hero-collage.jpg');"></div>
        <div class="carousel-overlay"></div>
        <div class="hero-content">
            <h2>Educational Resources</h2>
            <p>Access learning materials, Islamic studies, and educational programs.</p>
        </div>
    </div>
    <!-- Slide 5 -->
    <div class="carousel-slide">
        <div class="carousel-background" style="background-image: url('<?php echo $base_url; ?>assets/images/msa-hero-collage.jpg');"></div>
        <div class="carousel-overlay"></div>
        <div class="hero-content">
            <h2>Volunteer Opportunities</h2>
            <p>Get involved in community service and make a positive impact.</p>
        </div>
    </div>
    <!-- Slide 6 -->
    <div class="carousel-slide">
        <div class="carousel-background" style="background-image: url('<?php echo $base_url; ?>assets/images/msa-hero-collage.jpg');"></div>
        <div class="carousel-overlay"></div>
        <div class="hero-content">
            <h2>Community Support</h2>
            <p>Find resources, guidance, and support for your academic journey.</p>
        </div>
    </div>
    <!-- Navigation Controls -->
    <button class="carousel-button prev" aria-label="Previous slide">❮</button>
    <button class="carousel-button next" aria-label="Next slide">❯</button>

    <!-- Adding Slide Indicators -->
    <div class="carousel-indicators">
        <span class="indicator active" data-slide="0"></span>
        <span class="indicator" data-slide="1"></span>
        <span class="indicator" data-slide="2"></span>
        <span class="indicator" data-slide="3"></span>
        <span class="indicator" data-slide="4"></span>
        <span class="indicator" data-slide="5"></span>
    </div>
</section>
<!-- filepath: c:\xampp\htdocs\msaconnect\views\user\landing_page.php -->
<section id="latest-updates" class="latest-updates">
    <h2>LATEST UPDATES</h2>
    <div id="updates-container" class="updates-container">
        <!-- Static placeholder updates -->
        <div class="update-item">
            <div class="update-details">
                <img src="<?php echo $base_url; ?>assets/images/login.jpg" alt="Community Event" class="update-image">
                <p class="update-date">August 15, 2023</p>
                <h3 class="update-title">Community Iftar Gathering</h3>
                <p class="update-content">Join us for a community iftar gathering at the campus mosque. Everyone is welcome!</p>
            </div>
        </div>
        <div class="update-item">
            <div class="update-details">
            <img src="<?php echo $base_url; ?>assets/images/login.jpg" alt="Community Event" class="update-image">
            <p class="update-date">August 10, 2023</p>
                <h3 class="update-title">Islamic Finance Workshop</h3>
                <p class="update-content">Learn about Islamic finance principles and how to apply them in modern life.</p>
            </div>
        </div>
        <div class="update-item">
            <div class="update-details">
            <img src="<?php echo $base_url; ?>assets/images/login.jpg" alt="Community Event" class="update-image">
            <p class="update-date">August 5, 2023</p>
                <h3 class="update-title">Weekly Quran Study Circle</h3>
                <p class="update-content">Our weekly Quran study circle will be held every Wednesday at 7 PM.</p>
            </div>
        </div>
        <div class="update-item">
            <div class="update-details">
            <img src="<?php echo $base_url; ?>assets/images/login.jpg" alt="Community Event" class="update-image">
            <p class="update-date">July 28, 2023</p>
                <h3 class="update-title">Community Service Day</h3>
                <p class="update-content">Join us for a day of community service and giving back to our local community.</p>
            </div>
        </div>
    </div>
</section>

<section id="prayer-schedule" class="prayer-schedule">
    <h2>FRIDAY PRAYER SCHEDULE</h2>
    <div class="table-container">
        <div class="prayer-schedule-content" id="prayer-schedule-content">
            <!-- Static placeholder prayer schedule -->
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
                    <tr>
                        <td>2023-08-18</td>
                        <td>Friday</td>
                        <td>Imam Abdullah</td>
                        <td>Importance of Community</td>
                        <td>Campus Mosque</td>
                    </tr>
                    <tr>
                        <td>2023-08-25</td>
                        <td>Friday</td>
                        <td>Dr. Ahmed Hassan</td>
                        <td>Seeking Knowledge</td>
                        <td>Campus Mosque</td>
                    </tr>
                    <tr>
                        <td>2023-09-01</td>
                        <td>Friday</td>
                        <td>Imam Mustafa</td>
                        <td>Preparing for Ramadan</td>
                        <td>Campus Mosque</td>
                    </tr>
                    <tr>
                        <td>2023-09-08</td>
                        <td>Friday</td>
                        <td>Dr. Saeed Ali</td>
                        <td>Islamic Ethics</td>
                        <td>Campus Mosque</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</section>


<?php include '../../includes/footer.php'; ?>
<script src="<?php echo $base_url; ?>js/landingpage.js"></script>
<script>
  // Force header to be fixed with JavaScript
  document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('header');
    if (header) {
      // Apply styles directly with !important
      header.style.cssText = `
        position: fixed !important;
        top: 0 !important;
        left: 0 !important;
        right: 0 !important;
        width: 100% !important;
        z-index: 9999999 !important;
      `;
      
      // Set body padding based on header height
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