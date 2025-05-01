<?php 
session_start(); 
require_once '../../classes/adminClass.php'; 
require_once '../../tools/function.php'; 
 
$adminObj = new Admin(); 
$schoolYears = $adminObj->getAllSchoolYears();
$currentSchoolYear = $adminObj->getCurrentSchoolYear();

$selectedSchoolYearId = isset($_GET['school_year_id']) ? $_GET['school_year_id'] : null;
$selectedSemester = isset($_GET['semester']) ? $_GET['semester'] : null;
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$cashIn = $adminObj->getCashInTransactions($selectedSchoolYearId, $selectedSemester, null, $startDate, $endDate);
$cashOut = $adminObj->getCashOutTransactions($selectedSchoolYearId, $selectedSemester, null, $startDate, $endDate);

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
 
<!DOCTYPE html> 
<html lang="en"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <title>Transparency Report</title> 
    <!-- <link rel="stylesheet" href="../../css/admintransparency.css?v=<?php echo time(); ?>">  -->
    <?php include '../../includes/head.php'; ?> 
    <script src="../../js/admin.js"></script>
    <script src="../../js/sideBar.js"></script>
    <script src="../../js/modals.js"></script>
</head> 
<body> 
    <div class="container"> 
        <h2 class="mb-4">Transparency Report</h2>
        
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="schoolYearSelect" class="form-label">School Year:</label>
                <select id="schoolYearSelect" class="form-select filter-control">
                    <option value="">All School Years</option>
                    <?php foreach ($schoolYears as $year): ?>
                        <option value="<?= $year['school_year_id'] ?>" 
                            <?= isset($_GET['school_year_id']) && $year['school_year_id'] == $selectedSchoolYearId ? 'selected' : '' ?>>
                            <?= clean_input($year['school_year']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="col-md-4">
                <label for="semesterSelect" class="form-label">Semester:</label>
                <select id="semesterSelect" class="form-select filter-control">
                    <option value="">All Semesters</option>
                    <option value="1st" <?= isset($_GET['semester']) && $selectedSemester == '1st' ? 'selected' : '' ?>>1st Semester</option>
                    <option value="2nd" <?= isset($_GET['semester']) && $selectedSemester == '2nd' ? 'selected' : '' ?>>2nd Semester</option>
                </select>
            </div>
        </div>
        
        <div class="row mb-4">
            <div class="col-md-4">
                <label for="startDate" class="form-label">From Date:</label>
                <div class="input-group date">
                    <input type="text" class="form-control filter-date" id="startDate" placeholder="From Date" value="<?= $startDate ?>" autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <label for="endDate" class="form-label">To Date:</label>
                <div class="input-group date">
                    <input type="text" class="form-control filter-date" id="endDate" placeholder="To Date" value="<?= $endDate ?>" autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                    </div>
                </div>
            </div>
            
            <div class="col-md-4">
                <label class="form-label">&nbsp;</label>
                <div>
                    <button id="clearDates" class="btn btn-secondary">Clear Dates</button>
                </div>
            </div>
        </div>
 
        <div class="mb-4">
            <h3>Cash-In Transactions</h3>
            <button class="btn btn-success mb-3" onclick="openTransactionModal('addEditCashInModal', null, 'add', 'Cash In')"> 
                Add Cash-In 
            </button>
            
            <table id="cashinTable" class="table table-bordered table-striped">
                <thead> 
                    <tr> 
                        <th>Date</th> 
                        <th>Detail</th>
                        <th>Category</th> 
                        <th>Amount</th> 
                        <th>Action</th> 
                    </tr> 
                </thead> 
                <tbody> 
                    <?php if ($cashIn): ?> 
                        <?php foreach ($cashIn as $transaction): ?> 
                            <tr> 
                                <td><?= clean_input($transaction['report_date']) ?></td> 
                                <td><?= clean_input($transaction['expense_detail']) ?></td> 
                                <td><?= clean_input($transaction['expense_category']) ?></td>
                                <td>₱<?= number_format($transaction['amount'], 2) ?></td> 
                                <td> 
                                    <button class="btn btn-primary btn-sm" onclick="openTransactionModal('addEditCashInModal', <?= $transaction['report_id'] ?>, 'edit', 'Cash In')">Edit</button> 
                                    <button class="btn btn-danger btn-sm" onclick="openTransactionModal('deleteCashInModal', <?= $transaction['report_id'] ?>, 'delete', 'Cash In')">Delete</button> 
                                </td> 
                            </tr> 
                        <?php endforeach; ?> 
                    <?php else: ?> 
                        <tr> 
                            <td colspan="5" class="text-center">No cash-in transactions found.</td> 
                        </tr> 
                    <?php endif; ?> 
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total Cash-In:</th>
                        <th id="totalCashInValue">₱<?= number_format($totalCashIn, 2) ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="mb-4">
            <h3>Cash-Out Transactions</h3>
            <button class="btn btn-success mb-3" onclick="openTransactionModal('addEditCashOutModal', null, 'add', 'Cash Out')"> 
                Add Cash-Out 
            </button>
            
            <table id="cashoutTable" class="table table-bordered table-striped">
                <thead> 
                    <tr> 
                        <th>Date</th> 
                        <th>Detail</th> 
                        <th>Category</th>
                        <th>Amount</th> 
                        <th>Action</th> 
                    </tr> 
                </thead> 
                <tbody> 
                    <?php if ($cashOut): ?> 
                        <?php foreach ($cashOut as $transaction): ?> 
                            <tr> 
                                <td><?= clean_input($transaction['report_date']) ?></td> 
                                <td><?= clean_input($transaction['expense_detail']) ?></td> 
                                <td><?= clean_input($transaction['expense_category']) ?></td>
                                <td>₱<?= number_format($transaction['amount'], 2) ?></td> 
                                <td> 
                                    <button class="btn btn-primary btn-sm" onclick="openTransactionModal('addEditCashOutModal', <?= $transaction['report_id'] ?>, 'edit', 'Cash Out')">Edit</button> 
                                    <button class="btn btn-danger btn-sm" onclick="openTransactionModal('deleteCashOutModal', <?= $transaction['report_id'] ?>, 'delete', 'Cash Out')">Delete</button> 
                                </td> 
                            </tr> 
                        <?php endforeach; ?> 
                    <?php else: ?> 
                        <tr> 
                            <td colspan="5" class="text-center">No cash-out transactions found.</td> 
                        </tr> 
                    <?php endif; ?> 
                </tbody>
                <tfoot>
                    <tr>
                        <th colspan="3" class="text-end">Total Cash-Out:</th>
                        <th id="totalCashOutValue">₱<?= number_format($totalCashOut, 2) ?></th>
                        <th></th>
                    </tr>
                </tfoot>
            </table>
        </div>
        
        <div class="mb-4">
            <h3>Summary</h3>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Details</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Total Cash-In</td>
                        <td>₱<?= number_format($totalCashIn, 2) ?></td>
                    </tr>
                    <tr>
                        <td>Total Cash-Out</td>
                        <td>₱<?= number_format($totalCashOut, 2) ?></td>
                    </tr>
                    <tr class="table-primary">
                        <td><strong>TOTAL FUNDS:</strong></td>
                        <td><strong>₱<?= number_format($totalFunds, 2) ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div> 
 
    <?php  
    include '../adminModals/addEditCashIn.html'; 
    include '../adminModals/addEditCashOut.html'; 
    include '../adminModals/deleteCashIn.html'; 
    include '../adminModals/deleteCashOut.html'; 
    ?> 
</body> 
</html>