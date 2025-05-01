<?php include '../../includes/header.php';
require_once '../../classes/userClass.php';

$userObj = new User();
?>
<link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?php echo $base_url; ?>css/user.landingpage.css">

<section id="home" class="carousel">
    <!-- Carousel Slides -->
    <div class="carousel-slide active">
        <div class="carousel-background" style="background-image: url('<?php echo $base_url; ?>assets/images/login.jpg');"></div>
        <div class="carousel-overlay"></div>
        <div class="hero-content">
            <h2>Welcome to Our Community</h2>
            <p>Join us in making a difference through volunteering and community initiatives.</p>
        </div>
    </div>
</section>

<section id="prayer-schedule" class="prayer-schedule">
    <div class="table-container">
        <div class="prayer-schedule-content" id="prayer-schedule-content">
            <!-- Prayer schedules will be dynamically loaded here -->
        </div>
    </div>
</section>

<section id="volunteer" class="volunteer">
    <div class="volunteer-content">
        <h2>Join our Volunteers!</h2>
        <p>Volunteering is a great way to give back to the community, develop new skills, and make a positive impact. Whether you're helping with events, organizing activities, or supporting our initiatives, your contribution matters!</p>
        <a href="volunteer.php" class="cta-button">Join Now!</a>
    </div>
</section>
<?php include '../../includes/footer.php'; ?>
<script src="<?php echo $base_url; ?>js/user.js"></script>
</body>
</html>