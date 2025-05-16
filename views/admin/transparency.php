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
    <script src="../../js/admin.js"></script>
    <script src="../../js/modals.js"></script>
    <script src="../../js/filterTransparency.js"></script>
    <style>
        :root {
            --palestine-green: #0F8A53;
            --palestine-black: rgb(0, 0, 0);
            --palestine-light: #f8f9fa;
            --palestine-hover: #0a6b3f;
            --table-border: #e0e0e0;
        }

        .admin-container {
            max-width: 1200px;
            padding-top: 3rem;
        }

        .admin-page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--palestine-green);
            padding: 0.5rem 0;
        }

        .filter-container {
            background: #fff;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border: 1px solid rgba(15, 138, 83, 0.2);
        }

        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
            margin-bottom: 1rem;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }
        

        .filter-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--palestine-black);
        }

        .filter-control {
            width: 100%;
            height: 38px;
            padding: 0.5rem 0.75rem;
            font-size: 0.875rem;
            border: 1.5px solid var(--palestine-black);
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .filter-control:focus {
            outline: none;
            border-color: var(--palestine-green);
            box-shadow: 0 0 0 2px rgba(15, 138, 83, 0.25);
        }

        .input-group.date {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group.date input {
            height: 38px;
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem !important;
            border: 1.5px solid var(--palestine-black) !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            width: 100%;
        }

        .input-group.date input:focus {
            outline: none !important;
            border-color: var(--palestine-green) !important;
            box-shadow: 0 0 0 2px rgba(15, 138, 83, 0.25) !important;
        }

        .input-group-append {
            position: absolute;
            right: 10px;
            pointer-events: none;
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: var(--palestine-black);
        }

        #clearDates {
            height: 38px;
            padding: 0 1.5rem;
            background-color: var(--palestine-black);
            color: #fff;
            border: none;
            border-radius: 8px;
            transition: all 0.2s ease;
            white-space: nowrap;
        }

        #clearDates:hover {
            transform: translateY(-1px);
        }

        .report-card {
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            background: #fff;
            padding: 1.25rem;
            border: 1px solid rgba(15, 138, 83, 0.2);
            overflow-x: auto;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 1px solid var(--table-border);
        }

        .card-header h3 {
            margin: 0;
            color: var(--palestine-green);
            font-size: 1.25rem;
            font-weight: 600;
        }

        .admin-btn {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            transition: all 0.2s ease;
            border-width: 1.5px;
            border-style: solid;
            box-shadow: none;
        }

        .admin-btn-add {
            background-color: var(--palestine-green);
            border-color: var(--palestine-green);
            color: #fff;
        }

        .admin-btn-add:hover {
            background-color: var(--palestine-hover);
            transform: translateY(-1px);
        }

        .admin-btn-edit {
            background-color: #000000;
            border-color: #000000;
            color: #fff;
        }

        .admin-btn-edit:hover {
            background-color: #fff;
            color: #333;
            border-color: #333;
        }

        .admin-btn-delete {
            background-color: #fff;
            border-color: #dc3545;
            color: #dc3545;
        }

        .admin-btn-delete:hover {
            background-color: #dc3545;
            color: #fff;
        }

        .dataTables_filter input {
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem !important;
            border: 1.5px solid var(--palestine-black) !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            margin-left: 0.5rem !important;
        }

        .dataTables_filter input:focus {
            outline: none !important;
            border-color: var(--palestine-green) !important;
            box-shadow: 0 0 0 2px rgba(15, 138, 83, 0.25) !important;
        }

        .dataTables_filter label {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .dataTables_length select {
            padding: 0.4rem 0.75rem !important;
            font-size: 0.875rem !important;
            border: 1.5px solid var(--palestine-black) !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            margin: 0 0.5rem !important;
            height: auto !important;
        }

        .dataTables_length select:focus {
            outline: none !important;
            border-color: var(--palestine-green) !important;
            box-shadow: 0 0 0 2px rgba(15, 138, 83, 0.25) !important;
        }

        .dataTables_length label {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 1rem !important;
        }

        .dataTables_paginate {
            margin-top: 1rem !important;
            font-size: 0.875rem !important;
        }

        .dataTables_paginate .paginate_button {
            padding: 0.25rem 0.5rem !important;
            margin: 0 0.15rem !important;
            border: 1px solid transparent !important;
            border-radius: 4px !important;
            transition: all 0.2s ease !important;
        }

        .dataTables_paginate .paginate_button.current,
        .dataTables_paginate .paginate_button.current:hover {
            background: var(--palestine-green) !important;
            color: white !important;
            border-color: var(--palestine-green) !important;
        }

        .dataTables_paginate .paginate_button:hover {
            background: var(--palestine-hover) !important;
            color: white !important;
            border-color: var(--palestine-hover) !important;
        }

        .dataTables_paginate .paginate_button.disabled,
        .dataTables_paginate .paginate_button.disabled:hover {
            background: transparent !important;
            color: #6c757d !important;
            border-color: transparent !important;
            cursor: not-allowed;
        }

        .dataTables_info {
            font-size: 0.875rem;
            color: #6c757d;
            margin-top: 1rem;
        }

        /* Table Styling */
        table.dataTable {
            width: 100% !important;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.95rem;
        }

        table.dataTable thead th {
            color: var(--palestine-green);
            font-weight: 600;
            padding: 12px 15px;
            border: none;
            background-color: #fff;
        }

        table.dataTable tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--table-border);
            vertical-align: middle;
        }

        table.dataTable tbody tr:last-child td {
            border-bottom: none;
        }

        table.dataTable tbody tr:hover td {
            background-color: rgba(15, 138, 83, 0.05);
        }

        /* Summary Table */
        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.95rem;
            margin-top: 1rem;
        }

        .summary-table th,
        .summary-table td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--table-border);
        }

        .summary-table tr:last-child td {
            border-bottom: none;
            background-color: rgba(15, 138, 83, 0.1);
            font-weight: 600;
        }

        @media (max-width: 768px) {
            .filter-row {
                flex-direction: column;
                gap: 1rem;
            }
            
            .filter-group {
                width: 100%;
            }
            
            #clearDates {
                width: 100%;
            }

            .dataTables_length,
            .dataTables_filter {
                width: 100%;
                margin-bottom: 1rem;
            }

            .dataTables_filter label,
            .dataTables_length label {
                justify-content: flex-start;
                width: 100%;
            }

            .dataTables_filter input {
                width: 100%;
                margin-left: 0 !important;
                margin-top: 0.5rem;
            }

            .dataTables_length select {
                width: auto;
                margin: 0.5rem 0.5rem !important;
            }
        }
        
        /* Loading indicator styles */
        #transparencyTableContainer.loading {
            position: relative;
            min-height: 100px;
        }
        
        #transparencyTableContainer.loading::after {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(255, 255, 255, 0.7);
            z-index: 10;
        }
        
        #transparencyTableContainer.loading::before {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 50px;
            height: 50px;
            margin: -25px 0 0 -25px;
            border: 5px solid #f3f3f3;
            border-top: 5px solid var(--palestine-green);
            border-radius: 50%;
            animation: spin 1s linear infinite;
            z-index: 11;
        }
        
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        
        /* Hide required icons for start date fields in cash in/out forms */
        #cashInDate.is-invalid,
        #cashOutDate.is-invalid {
            background-image: none !important;
            padding-right: 0.75rem !important;
        }
        
        /* Hide specific validation icons for date fields */
        .invalid-icon[id*="Date"] {
            display: none !important;
        }
    </style>
</head> 

<body> 
<div class="admin-container">
    <div class="admin-page-header">
        <h3><strong>Transparency Report</strong></h3>
    </div>
    
    <div class="filter-container">
        <form id="transparencyFilterForm" class="mb-0">
            <div class="row g-3 align-items-end">
                <div class="col-md-3">
                    <label for="filterSchoolYear" class="filter-label">School Year</label>
                    <select id="filterSchoolYear" name="school_year_id" class="form-select filter-control">
                        <option value="">All School Years</option>
                        <?php foreach ($schoolYears as $year): ?>
                            <option value="<?= $year['school_year_id'] ?>" <?= $year['school_year_id'] == $selectedSchoolYearId ? 'selected' : '' ?>><?= clean_input($year['school_year']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <label for="filterSemester" class="filter-label">Semester</label>
                    <select id="filterSemester" name="semester" class="form-select filter-control">
                        <option value="">All Semesters</option>
                        <option value="1st" <?= $selectedSemester == '1st' ? 'selected' : '' ?>>1st Semester</option>
                        <option value="2nd" <?= $selectedSemester == '2nd' ? 'selected' : '' ?>>2nd Semester</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label for="filterStartDate" class="filter-label">From Date</label>
                    <input type="date" id="filterStartDate" name="start_date" class="form-control filter-control" value="<?= $startDate ?>">
                </div>
                <div class="col-md-2">
                    <label for="filterEndDate" class="filter-label">To Date</label>
                    <input type="date" id="filterEndDate" name="end_date" class="form-control filter-control" value="<?= $endDate ?>">
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="button" id="clearDates" class="btn btn-outline-secondary w-100">Clear Filters</button>
                </div>
            </div>
        </form>
    </div>
    <div id="transparencyTableContainer">
        <div class="report-card">
            <div class="card-header">
                <h3>Cash-In Transactions</h3>
                <button class="admin-btn admin-btn-add" onclick="openTransactionModal('addEditCashInModal', null, 'add', 'Cash In')"> 
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
            
            <table id="cashinTable" class="display" style="width:100%">
                <thead> 
                    <tr> 
                        <th>Date</th> 
                        <th>Day</th>
                        <th>Detail</th>
                        <th>Category</th> 
                        <th>Amount</th> 
                        <th>Action</th> 
                    </tr> 
                </thead> 
                <tbody> 
                <?php if ($cashIn): ?>
                    <?php 
                    $today = date('Y-m-d');
                    foreach ($cashIn as $transaction): 
                        $transactionEndDateToCheck = !empty($transaction['end_date']) ? $transaction['end_date'] : $transaction['report_date'];
                        $isPastTransaction = ($transactionEndDateToCheck < $today);
                        $isTodayTransaction = ($transaction['report_date'] <= $today && $transactionEndDateToCheck >= $today);
                        
                        $dateDisplay = formatDate2($transaction['report_date']);
                        if (!empty($transaction['end_date'])) {
                            $dateDisplay .= ' to ' . formatDate2($transaction['end_date']);
                        }
                    ?>
                        <tr> 
                            <td data-order="<?= $transaction['report_date'] ?>">
                                <?= $dateDisplay ?>
                            </td>
                            <td>
                                <?php 
                                $startDay = date('l', strtotime($transaction['report_date']));
                                if (!empty($transaction['end_date'])) {
                                    $endDay = date('l', strtotime($transaction['end_date']));
                                    if ($startDay != $endDay) {
                                        echo $startDay . ' - ' . $endDay;
                                    } else {
                                        echo $startDay;
                                    }
                                } else {
                                    echo $startDay;
                                }
                                ?>
                            </td>
                            <td><?= clean_input($transaction['expense_detail']) ?></td> 
                            <td><?= clean_input($transaction['expense_category']) ?></td>
                            <td>₱<?= number_format($transaction['amount'], 2) ?></td> 
                            <td> 
                                <button class="admin-btn admin-btn-edit" onclick="openTransactionModal('addEditCashInModal', <?= $transaction['report_id'] ?>, 'edit', 'Cash In')"><i class="bi bi-pencil"></i></button> 
                                <button class="admin-btn admin-btn-delete" onclick="openTransactionModal('deleteCashInModal', <?= $transaction['report_id'] ?>, 'delete', 'Cash In')"><i class="bi bi-trash"></i></button> 
                            </td> 
                        </tr> 
                    <?php endforeach; ?> 
                <?php else: ?> 
                    <tr> 
                        <td colspan="6" class="text-center">No cash-in transactions found.</td> 
                    </tr> 
                <?php endif; ?> 
                </tbody>
            </table>
        </div>
        
        <div class="report-card">
            <div class="card-header">
                <h3>Cash-Out Transactions</h3>
                <button class="admin-btn admin-btn-add" onclick="openTransactionModal('addEditCashOutModal', null, 'add', 'Cash Out')"> 
                    <i class="bi bi-plus-lg"></i>
                </button>
            </div>
            
            <table id="cashoutTable" class="display" style="width:100%">
                <thead> 
                    <tr> 
                        <th>Date</th> 
                        <th>Day</th>
                        <th>Detail</th> 
                        <th>Category</th>
                        <th>Amount</th> 
                        <th>Action</th> 
                    </tr> 
                </thead> 
                <tbody> 
                <?php if ($cashOut): ?>
                    <?php 
                    $today = date('Y-m-d');
                    foreach ($cashOut as $transaction): 
                        $transactionEndDateToCheck = !empty($transaction['end_date']) ? $transaction['end_date'] : $transaction['report_date'];
                        $isPastTransaction = ($transactionEndDateToCheck < $today);
                        $isTodayTransaction = ($transaction['report_date'] <= $today && $transactionEndDateToCheck >= $today);
                        
                        $dateDisplay = formatDate2($transaction['report_date']);
                        if (!empty($transaction['end_date'])) {
                            $dateDisplay .= ' to ' . formatDate2($transaction['end_date']);
                        }
                    ?>
                        <tr> 
                            <td data-order="<?= $transaction['report_date'] ?>">
                                <?= $dateDisplay ?>
                            </td>
                            <td>
                                <?php 
                                $startDay = date('l', strtotime($transaction['report_date']));
                                if (!empty($transaction['end_date'])) {
                                    $endDay = date('l', strtotime($transaction['end_date']));
                                    if ($startDay != $endDay) {
                                        echo $startDay . ' - ' . $endDay;
                                    } else {
                                        echo $startDay;
                                    }
                                } else {
                                    echo $startDay;
                                }
                                ?>
                            </td>
                            <td><?= clean_input($transaction['expense_detail']) ?></td> 
                            <td><?= clean_input($transaction['expense_category']) ?></td>
                            <td>₱<?= number_format($transaction['amount'], 2) ?></td> 
                            <td> 
                                <button class="admin-btn admin-btn-edit" onclick="openTransactionModal('addEditCashOutModal', <?= $transaction['report_id'] ?>, 'edit', 'Cash Out')"><i class="bi bi-pencil"></i></button> 
                                <button class="admin-btn admin-btn-delete" onclick="openTransactionModal('deleteCashOutModal', <?= $transaction['report_id'] ?>, 'delete', 'Cash Out')"><i class="bi bi-trash"></i></button> 
                            </td> 
                        </tr> 
                    <?php endforeach; ?> 
                <?php else: ?> 
                    <tr> 
                        <td colspan="6" class="text-center">No cash-out transactions found.</td> 
                    </tr> 
                <?php endif; ?> 
                </tbody>
            </table>
        </div>
        
        <div class="report-card">
            <div class="card-header">
                <h3>Summary</h3>
            </div>
            <table class="summary-table">
                <tbody>
                    <tr>
                        <td>Total Cash-In</td>
                        <td>₱<?= number_format($totalCashIn, 2) ?></td>
                    </tr>
                    <tr>
                        <td>Total Cash-Out</td>
                        <td>₱<?= number_format($totalCashOut, 2) ?></td>
                    </tr>
                    <tr>
                        <td><strong>TOTAL FUNDS:</strong></td>
                        <td><strong>₱<?= number_format($totalFunds, 2) ?></strong></td>
                    </tr>
                </tbody>
            </table>
        </div>
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