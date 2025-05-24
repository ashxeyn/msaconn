<?php include '../../includes/header.php'; 
require_once '../../classes/userClass.php';
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$userObj = new User();
$transparencyInfo = $userObj->fetchTransparencyInfo();
$backgroundImage = $userObj->fetchBackgroundImage();

$adminObj = new Admin();
$cashIn = $adminObj->getCashInTransactions();
$cashOut = $adminObj->getCashOutTransactions();

$totalCashIn = 0;
foreach ($cashIn as $transaction) {
    $totalCashIn += $transaction['amount'];
}
$totalCashOut = 0;
foreach ($cashOut as $transaction) {
    $totalCashOut += $transaction['amount'];
}
$totalFunds = $totalCashIn - $totalCashOut;
?>
<link rel="stylesheet" href="../../css/transparencyreport.css">
<link rel="stylesheet" href="../../css/shared-tables.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<div class="hero">
    <?php foreach ($backgroundImage as $image) : ?>
    <div class="hero-background" style="background-image: url('../../<?= $image['image_path']; ?>');">
    <?php endforeach; ?>
    </div>
    <div class="hero-content">
        <?php foreach ($transparencyInfo as $info) : ?>
            <h2><?php echo $info['title']; ?></h2>
            <p><?php echo $info['description']; ?></p> 
        <?php endforeach; ?>
    </div>
</div>

<!-- Add these styles to the head section to ensure they override other styles -->
<style>
  /* Override DataTables styling to ensure consistent row heights */
  #cashinTable td, 
  #cashinTable th,
  #cashoutTable td, 
  #cashoutTable th,
  #summaryTableContainer .msa-table td,
  #summaryTableContainer .msa-table th {
    padding: 15px 20px !important;
    height: auto !important;
    line-height: 1.5 !important;
    border-left: none !important;
    border-right: none !important;
  }
  
  /* Remove vertical borders and keep only horizontal ones */
  .msa-table {
    border-collapse: collapse !important;
    border-left: none !important;
    border-right: none !important;
    min-width: 650px; /* Ensure minimum width for scrolling */
    width: 100%;
  }
  
  .msa-table th {
    border-top: none !important;
    border-left: none !important;
    border-right: none !important;
    border-bottom: 1px solid #e0e0e0 !important;
  }
  
  .msa-table td {
    border-left: none !important;
    border-right: none !important;
    border-top: none !important;
    border-bottom: 1px solid #e0e0e0 !important;
  }
  
  .msa-table tr:last-child td {
    border-bottom: none !important;
  }
  
  /* Table container should have clean borders and scrolling */
  .table-container {
    border-radius: 8px !important;
    overflow-x: auto !important;
    border: 1px solid #e0e0e0 !important;
    -webkit-overflow-scrolling: touch !important; /* Smooth scrolling on iOS */
    margin-bottom: 20px !important;
  }
  
  /* Ensure DataTables doesn't override our styles */
  .dataTables_wrapper .dataTables_length, 
  .dataTables_wrapper .dataTables_filter, 
  .dataTables_wrapper .dataTables_info, 
  .dataTables_wrapper .dataTables_processing, 
  .dataTables_wrapper .dataTables_paginate {
    margin-top: 10px !important;
    margin-bottom: 10px !important;
    padding: 8px !important;
  }
  
  /* Fix pagination position */
  .dataTables_wrapper .dataTables_paginate {
    position: static !important;
    float: none !important;
    text-align: left !important;
    margin-top: 15px !important;
    width: auto !important;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button {
    padding: 5px 10px !important;
    margin: 0 2px !important;
    border-radius: 4px !important;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button.current {
    background: #1a541c !important;
    color: white !important;
    border: none !important;
  }

  .dataTables_wrapper .dataTables_paginate .paginate_button:hover {
    background: #134015 !important;
    color: white !important;
    border: none !important;
  }
  
  /* Make sure the table rows have consistent heights even after DataTables loads */
  .msa-table tr {
    height: auto !important;
    min-height: 50px !important;
  }
  
  /* Transaction Details Title Style */
  .transaction-title {
    font-size: 1.8rem;
    color: #1a541c;
    text-align: center;
    text-transform: uppercase;
    font-weight: 600;
    letter-spacing: 1px;
    margin-bottom: 30px;
    margin-top: 30px;
  }
  
  @media (max-width: 768px) {
    #cashinTable td, 
    #cashinTable th,
    #cashoutTable td, 
    #cashoutTable th,
    #summaryTableContainer .msa-table td,
    #summaryTableContainer .msa-table th {
      padding: 10px 12px !important;
    }
    
    /* Add scroll hint for small screens */
    .table-container::after {
      content: "Scroll horizontally to view full table →";
      display: block;
      text-align: center;
      padding: 8px 0;
      font-size: 12px;
      color: #666;
      background-color: #f8f8f8;
      border-top: 1px solid #eee;
    }

    /* Ensure pagination stays left-aligned on mobile */
    .dataTables_wrapper .dataTables_paginate {
      margin-top: 10px !important;
      text-align: left !important;
      width: auto !important;
    }

    .dataTables_wrapper .dataTables_paginate .paginate_button {
      padding: 4px 8px !important;
      font-size: 12px !important;
    }
  }
  
  @media (max-width: 480px) {
    #cashinTable td, 
    #cashinTable th,
    #cashoutTable td, 
    #cashoutTable th,
    #summaryTableContainer .msa-table td,
    #summaryTableContainer .msa-table th {
      padding: 8px 10px !important;
      font-size: 12px !important;
    }

    /* Adjust pagination for very small screens */
    .dataTables_wrapper .dataTables_paginate .paginate_button {
      padding: 3px 6px !important;
      font-size: 11px !important;
    }
  }
</style>

<!-- Transparency Report Section -->
<section class="table-section" style="background-color: #f5f5f5; padding: 40px 0;">
  <div class="container">
    <h2 class="transaction-title">TRANSACTION DETAILS</h2>
    
    <h3>Cash In</h3>
    <div class="table-container" style="background-color: #ffffff; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15); border: 1px solid #f0f0f0; overflow-x: auto; -webkit-overflow-scrolling: touch;">
      <table id="cashinTable" class="msa-table display" style="min-width: 650px; width: 100%">
        <thead>
          <tr>
            <th style="min-width: 120px; padding: 15px 20px;">Date</th>
            <th style="min-width: 80px; padding: 15px 20px;">Day</th>
            <th style="min-width: 150px; padding: 15px 20px;">Detail</th>
            <th style="min-width: 120px; padding: 15px 20px;">Category</th>
            <th style="min-width: 100px; padding: 15px 20px;">Amount</th>
          </tr>
        </thead>
        <tbody>
        <?php if ($cashIn): ?>
            <?php foreach ($cashIn as $transaction): ?>
                <?php
                    $dateDisplay = date('M d, Y', strtotime($transaction['report_date']));
                    if (!empty($transaction['end_date'])) {
                        $dateDisplay .= ' to ' . date('M d, Y', strtotime($transaction['end_date']));
                    }
                    $startDay = date('l', strtotime($transaction['report_date']));
                    if (!empty($transaction['end_date'])) {
                        $endDay = date('l', strtotime($transaction['end_date']));
                        $dayDisplay = ($startDay != $endDay) ? $startDay . ' - ' . $endDay : $startDay;
                    } else {
                        $dayDisplay = $startDay;
                    }
                ?>
                <tr>
                    <td style="padding: 15px 20px;"><?php echo $dateDisplay; ?></td>
                    <td style="padding: 15px 20px;"><?php echo $dayDisplay; ?></td>
                    <td style="padding: 15px 20px;"><?php echo clean_input($transaction['expense_detail']); ?></td>
                    <td style="padding: 15px 20px;"><?php echo clean_input($transaction['expense_category']); ?></td>
                    <td style="padding: 15px 20px;"><?php echo number_format($transaction['amount'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center" style="padding: 15px 20px;">No cash-in transactions found.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
    
    <h3>Cash Out</h3>
    <div class="table-container" style="background-color: #ffffff; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15); border: 1px solid #f0f0f0; overflow-x: auto; -webkit-overflow-scrolling: touch;">
      <table id="cashoutTable" class="msa-table display" style="min-width: 650px; width: 100%">
        <thead>
          <tr>
            <th style="min-width: 120px; padding: 15px 20px;">Date</th>
            <th style="min-width: 80px; padding: 15px 20px;">Day</th>
            <th style="min-width: 150px; padding: 15px 20px;">Detail</th>
            <th style="min-width: 120px; padding: 15px 20px;">Category</th>
            <th style="min-width: 100px; padding: 15px 20px;">Amount</th>
          </tr>
        </thead>
        <tbody>
        <?php if ($cashOut): ?>
            <?php foreach ($cashOut as $transaction): ?>
                <?php
                    $dateDisplay = date('M d, Y', strtotime($transaction['report_date']));
                    if (!empty($transaction['end_date'])) {
                        $dateDisplay .= ' to ' . date('M d, Y', strtotime($transaction['end_date']));
                    }
                    $startDay = date('l', strtotime($transaction['report_date']));
                    if (!empty($transaction['end_date'])) {
                        $endDay = date('l', strtotime($transaction['end_date']));
                        $dayDisplay = ($startDay != $endDay) ? $startDay . ' - ' . $endDay : $startDay;
                    } else {
                        $dayDisplay = $startDay;
                    }
                ?>
                <tr>
                    <td style="padding: 15px 20px;"><?php echo $dateDisplay; ?></td>
                    <td style="padding: 15px 20px;"><?php echo $dayDisplay; ?></td>
                    <td style="padding: 15px 20px;"><?php echo clean_input($transaction['expense_detail']); ?></td>
                    <td style="padding: 15px 20px;"><?php echo clean_input($transaction['expense_category']); ?></td>
                    <td style="padding: 15px 20px;"><?php echo number_format($transaction['amount'], 2); ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="5" class="text-center" style="padding: 15px 20px;">No cash-out transactions found.</td></tr>
        <?php endif; ?>
        </tbody>
      </table>
    </div>
    
    <!-- Summary Table -->
    <div id="summaryTableContainer">
      <h3>Financial Summary</h3>
      <div class="table-container" style="background-color: #ffffff; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15); border: 1px solid #f0f0f0; overflow-x: auto; -webkit-overflow-scrolling: touch;">
        <table class="msa-table" style="min-width: 450px; width: 100%">
          <thead>
            <tr>
              <th style="min-width: 200px; padding: 15px 20px;">Transaction Type</th>
              <th style="min-width: 150px; padding: 15px 20px;">Amount</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td style="padding: 15px 20px;">Total Cash-In</td>
              <td style="padding: 15px 20px;">₱<?php echo number_format($totalCashIn, 2); ?></td>
            </tr>
            <tr>
              <td style="padding: 15px 20px;">Total Cash-Out</td>
              <td style="padding: 15px 20px;">₱<?php echo number_format($totalCashOut, 2); ?></td>
            </tr>
            <tr class="total-row">
              <td style="padding: 15px 20px;"><strong>TOTAL FUNDS:</strong></td>
              <td style="padding: 15px 20px;"><strong>₱<?php echo number_format($totalFunds, 2); ?></strong></td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</section>

<!-- Add responsive styles -->
<style>
  @media (max-width: 768px) {
    .table-section .container {
      padding-left: 10px;
      padding-right: 10px;
    }
    
    .table-section h2, .table-section h3 {
      font-size: 1.5rem;
      margin-bottom: 15px;
    }
    
    .table-section .table-container {
      margin-bottom: 20px;
    }
    
    .msa-table th, 
    .msa-table td {
      padding: 10px 12px;
    }
  }
  
  @media (max-width: 480px) {
    .table-section .container {
      padding-left: 5px;
      padding-right: 5px;
    }
    
    .table-section h2, .table-section h3 {
      font-size: 1.3rem;
      margin-bottom: 10px;
    }
    
    .msa-table th, 
    .msa-table td {
      padding: 8px 10px;
      font-size: 12px;
    }
    
    /* Show a hint about scrolling on very small screens */
    .table-section .table-container::after {
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
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="../../js/website.js"></script>
<script src="../../js/table-fix.js"></script>
<script>
  $(document).ready(function() {
    // Apply custom styling to DataTables UI elements after tables are initialized
    function checkAndApplyStyles() {
      if ($('.dataTables_wrapper').length > 0) {
        customizeDataTablesUI();
      } else {
        // If not ready yet, wait a bit and try again
        setTimeout(checkAndApplyStyles, 100);
      }
    }
    
    // Start the check
    checkAndApplyStyles();
    
    // Function to apply custom styling
    function customizeDataTablesUI() {
      $('.dataTables_wrapper .dataTables_filter input').css({
        'border': '1px solid #eaecef',
        'border-radius': '6px',
        'padding': '6px 12px',
        'margin-left': '8px',
        'background-color': '#f8f9fa'
      });
      
      $('.dataTables_wrapper .dataTables_length select').css({
        'border': '1px solid #eaecef',
        'border-radius': '6px',
        'padding': '4px 8px',
        'background-color': '#f8f9fa'
      });
      
      // Add spacing at the bottom
      $('.dataTables_wrapper').css('margin-bottom', '20px');
      
      // Enforce consistent row heights even after DataTables initialization
      // Apply these styles after a short delay to ensure they override DataTables
      setTimeout(function() {
        $('#cashinTable td, #cashinTable th, #cashoutTable td, #cashoutTable th, #summaryTableContainer .msa-table td, #summaryTableContainer .msa-table th').css({
          'padding': '15px 20px',
          'height': 'auto',
          'line-height': '1.5',
          'border-left': 'none',
          'border-right': 'none'
        });
        
        // Remove vertical borders
        $('.msa-table').css({
          'border-collapse': 'collapse',
          'border-left': 'none',
          'border-right': 'none'
        });
        
        $('.msa-table th').css({
          'border-top': 'none',
          'border-left': 'none',
          'border-right': 'none',
          'border-bottom': '1px solid #e0e0e0'
        });
        
        $('.msa-table td').css({
          'border-left': 'none',
          'border-right': 'none',
          'border-top': 'none',
          'border-bottom': '1px solid #e0e0e0'
        });
        
        $('.msa-table tr:last-child td').css({
          'border-bottom': 'none'
        });
        
        // Table container should have clean borders
        $('.table-container').css({
          'border-radius': '8px',
          'overflow': 'hidden',
          'border': '1px solid #e0e0e0'
        });
        
        // Ensure rows have consistent height
        $('.msa-table tr').css({
          'height': 'auto',
          'min-height': '50px'
        });
      }, 200);
    }
    
    // Apply styles again whenever DataTables redraws the table (sorting, paging, etc.)
    $('#cashinTable, #cashoutTable').on('draw.dt', function() {
      // Re-apply row styling after table redraw
      $(this).find('td').css({
        'padding': '15px 20px',
        'height': 'auto',
        'line-height': '1.5',
        'border-left': 'none',
        'border-right': 'none',
        'border-top': 'none',
        'border-bottom': '1px solid #e0e0e0'
      });
      
      $(this).find('th').css({
        'border-left': 'none',
        'border-right': 'none',
        'border-top': 'none',
        'border-bottom': '1px solid #e0e0e0'
      });
      
      $(this).find('tr:last-child td').css({
        'border-bottom': 'none'
      });
      
      $(this).find('tr').css({
        'height': 'auto',
        'min-height': '50px'
      });
    });
  });
</script>
