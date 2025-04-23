<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us</title>
</head>
<body>
  <?php include '../../includes/header.php'; ?>
  <link rel="stylesheet" href="<?php echo $base_url; ?>css/aboutus.css">

  <!-- Hero Section -->
  <div class="hero">
    <div class="hero-background"></div>
    <div class="hero-content">
      <h2>About Us</h2>
      <p>
        Our website is dedicated to connecting volunteers with opportunities to make a difference in their communities. 
        We believe in the power of volunteering to bring people together and create positive change.
      </p>
    </div>
  </div>

  <!-- Mission Section -->
  <div class="mission-section">
    <h3>Our Mission</h3>
    <p>
    Our mission is to empower individuals from all walks of life to contribute their time, talents, and passion toward meaningful causes that foster lasting,
     positive change. We believe that everyone has something valuable to offer, and by connecting people with opportunities to serve, we help ignite a spirit of purpose, community, and shared impact. 
    Through volunteering, we strive to create a more compassionate, connected, and resilient world—one action at a time. </p>
  </div>

  <!-- Vision Section -->
  <div class="vision-section">
    <h3>Our Vision</h3>
    <p>
    We envision a world where every individual is inspired to take part in volunteering—where acts of kindness, empathy, and support are not only encouraged but celebrated.
     In this world, the simple decision to give one’s time or lend a helping hand creates a powerful ripple effect that extends far beyond a single moment or act.
     It builds bridges across communities, strengthens social bonds, and inspires others to do the same. We believe that when people come together with the shared goal of making a difference, the impact can be transformative—reaching across neighborhoods, generations, and even borders.
  </div>

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
          <img src="<?php echo $base_url; ?>assets/images/officer.jpg " alt="Jennifer Lee">
          <div class="org-details">
            <p class="org-name">Jennifer Lee</p>
            <p class="org-position">HR Manager</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Downloads Section -->
  <section class="downloads-section">
    <div class="content-wrapper">
        <h2 class="section-title">Downloadable Files</h2>
        
        <div class="downloads-list">
            <!-- File 1 -->
            <div class="file-item">
                <div class="file-info">
                    <span class="file-icon">📄</span>
                    <div class="file-details">
                        <h3>User Guide.pdf</h3>
                        <p>2.4 MB • Updated 12/05/2023</p>
                    </div>
                </div>
                <a href="#" class="download-link">Download</a>
            </div>
            
            <!-- File 2 -->
            <div class="file-item">
                <div class="file-info">
                    <span class="file-icon">🗂️</span>
                    <div class="file-details">
                        <h3>Resources.zip</h3>
                        <p>156 MB • Updated 04/02/2024</p>
                    </div>
                </div>
                <a href="#" class="download-link">Download</a>
            </div>
        </div>
    </div>
  </section>

  <?php include '../../includes/footer.php'; ?>
</body>
</html>