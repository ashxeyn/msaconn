<?php include '../../includes/header.php'; ?>
<link rel="stylesheet" href="<?php echo $base_url; ?>css/transparencyreport.css">

<!-- Hero Section -->
<div class="hero">
  <div class="hero-background"></div>
  <div class="hero-content">
    <h2>Transparency Report</h2>
    <p>We are committed to maintaining transparency in all our transactions. 
      Below is a detailed breakdown of our financial activities.</p>
  </div>
</div>

<!-- Transparency Report Section -->
<section class="transparency-report">
  <div class="container">
    <h2>Transaction Details</h2>
    
    <h3>Cash In</h3>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Date</th>
            <th>Detail</th>
            <th>Category</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody id="cash-in-tbody">
          <!-- Data will be populated here via AJAX -->
        </tbody>
      </table>
    </div>
    
    <h3>Cash Out</h3>
    <div class="table-container">
      <table>
        <thead>
          <tr>
            <th>Date</th>
            <th>Detail</th>
            <th>Category</th>
            <th>Amount</th>
          </tr>
        </thead>
        <tbody id="cash-out-tbody">
          <!-- Data will be populated here via AJAX -->
        </tbody>
      </table>
    </div>
  </div>
</section>

<?php include '../../includes/footer.php'; ?>
<script src="<?php echo $base_url; ?>js/user.js"></script>