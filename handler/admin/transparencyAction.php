<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$action = $_POST['action'] ?? '';
$reportId = $_POST['report_id'] ?? null;
$userId = $_SESSION['user_id'] ?? null;

if ($action === 'add' || $action === 'edit') {
    $reportDate = clean_input($_POST['report_date']);
    $expenseDetail = clean_input($_POST['expense_detail']);
    $amount = clean_input($_POST['amount']);
    $transactionType = clean_input($_POST['transaction_type']);
    $semester = clean_input($_POST['semester']);
    $schoolYearId = clean_input($_POST['school_year_id']);
    $expenseCategory = clean_input($_POST['expense_category'] ?? '');

    if ($action === 'add') {
        $result = $adminObj->addTransparencyTransaction(
            $reportDate, 
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
    $result = $adminObj->deleteTransparencyTransaction($reportId);
    echo $result ? "success" : "error";
} elseif ($action === 'update_students') {
    $noStudents = clean_input($_POST['no_students']);
    $semester = clean_input($_POST['semester']);
    $schoolYearId = clean_input($_POST['school_year_id']);
    $paidId = clean_input($_POST['paid_id'] ?? null);
    
    // $result = $adminObj->updateStudentsPaid($noStudents, $schoolYearId, $semester, $paidId);
    // echo $result ? "success" : "error";
} else {
    echo "invalid_action";
}