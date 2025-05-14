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
<link rel="stylesheet" href="<?php echo $base_url; ?>css/transparencyreport.css">
<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

<div class="hero">
        <?php foreach ($backgroundImage as $image) : ?>
    <div class="hero-background" style="background-image: url('<?php echo $base_url . $image['image_path']; ?>');">
        <?php endforeach; ?>
    </div>
    <div class="hero-content">
            <?php foreach ($transparencyInfo as $info) : ?>
                <h2><?php echo $info['title']; ?></h2>
                <p><?php echo $info['description']; ?></p> 
            <?php endforeach; ?>
        </div>
    </div>

<!-- Transparency Report Section -->
<section class="transparency-report">
  <div class="container">
    <h2>Transaction Details</h2>
    
    <h3>Cash In</h3>
    <div class="table-container">
      <div class="prayer-schedule-content">
        <table id="cashinTable" class="display prayer-table" style="width:100%">
          <thead>
            <tr>
              <th>Date</th>
              <th>Day</th>
              <th>Detail</th>
              <th>Category</th>
              <th>Amount</th>
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
                      <td><?php echo $dateDisplay; ?></td>
                      <td><?php echo $dayDisplay; ?></td>
                      <td><?php echo clean_input($transaction['expense_detail']); ?></td>
                      <td><?php echo clean_input($transaction['expense_category']); ?></td>
                      <td>₱<?php echo number_format($transaction['amount'], 2); ?></td>
                  </tr>
              <?php endforeach; ?>
          <?php else: ?>
              <tr><td colspan="5" class="text-center">No cash-in transactions found.</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    
    <h3>Cash Out</h3>
    <div class="table-container">
      <div class="prayer-schedule-content">
        <table id="cashoutTable" class="display prayer-table" style="width:100%">
          <thead>
            <tr>
              <th>Date</th>
              <th>Day</th>
              <th>Detail</th>
              <th>Category</th>
              <th>Amount</th>
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
                      <td><?php echo $dateDisplay; ?></td>
                      <td><?php echo $dayDisplay; ?></td>
                      <td><?php echo clean_input($transaction['expense_detail']); ?></td>
                      <td><?php echo clean_input($transaction['expense_category']); ?></td>
                      <td>₱<?php echo number_format($transaction['amount'], 2); ?></td>
                  </tr>
              <?php endforeach; ?>
          <?php else: ?>
              <tr><td colspan="5" class="text-center">No cash-out transactions found.</td></tr>
          <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
    
    <!-- Summary Table -->
    <div id="summaryTableContainer">
      <h3>Financial Summary</h3>
      <div class="table-container">
        <div class="prayer-schedule-content">
          <table class="summary-table display prayer-table" style="width:100%">
            <thead>
              <tr>
                <th>Transaction Type</th>
                <th>Amount</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <td>Total Cash-In</td>
                <td>₱<?php echo number_format($totalCashIn, 2); ?></td>
              </tr>
              <tr>
                <td>Total Cash-Out</td>
                <td>₱<?php echo number_format($totalCashOut, 2); ?></td>
              </tr>
              <tr>
                <td><strong>TOTAL FUNDS:</strong></td>
                <td><strong>₱<?php echo number_format($totalFunds, 2); ?></strong></td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../../includes/footer.php'; ?>
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="../../js/website.js"></script>
