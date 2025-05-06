<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$action = $_POST['action'] ?? '';
$reportId = $_POST['report_id'] ?? null;
$userId = $_SESSION['user_id'] ?? null;
$type = $_POST['type'] ?? '';

if ($action === 'add' || $action === 'edit') {
    $reportDate = clean_input($_POST['report_date']);
    $endDate = clean_input($_POST['end_date'] ?? '');
    $expenseDetail = clean_input($_POST['expense_detail']);
    $amount = clean_input($_POST['amount']);
    $transactionType = clean_input($_POST['transaction_type']);
    $semester = clean_input($_POST['semester']);
    $schoolYearId = clean_input($_POST['school_year_id']);
    $expenseCategory = clean_input($_POST['expense_category'] ?? '');

    if ($action === 'add') {
        $result = $adminObj->addTransparencyTransaction(
            $reportDate,
            $endDate,
            $expenseDetail, 
            $expenseCategory,
            $amount, 
            $transactionType, 
            $semester, 
            $schoolYearId
        );
    } else {
        $result = $adminObj->updateTransparencyTransaction(
            $reportId, 
            $reportDate,
            $endDate,
            $expenseDetail, 
            $expenseCategory,
            $amount, 
            $transactionType, 
            $semester, 
            $schoolYearId
        );
    }
    echo $result ? "success" : "error";

} elseif ($action === 'delete') {
    $reason = clean_input($_POST['reason'] ?? '');
    
    if (empty($reason)) {
        echo "error: reason_required";
        exit;
    }
    
    $result = $adminObj->softDeleteTransaction($reportId, $reason);
    echo $result ? "success" : "error";
    
} elseif ($action === 'restore') {
    $result = $adminObj->restoreTransaction($reportId);
    echo $result ? "success" : "error";
    
} else {
    echo "invalid_action";
}