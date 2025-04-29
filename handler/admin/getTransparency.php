<?php
require_once '../../classes/adminClass.php';

if (isset($_GET['report_id'])) {
    $admin = new Admin();
    $transaction = $admin->getTransactionById($_GET['report_id']);
    echo json_encode($transaction);
}

if (isset($_GET['action']) && $_GET['action'] === 'get_transactions') {
    $admin = new Admin();
    $schoolYearId = isset($_GET['school_year_id']) ? $_GET['school_year_id'] : null;
    $semester = isset($_GET['semester']) ? $_GET['semester'] : null;
    
    $cashIn = $admin->getCashInTransactions($schoolYearId, $semester);
    $cashOut = $admin->getCashOutTransactions($schoolYearId, $semester);
    // $students = $admin->getTotalStudentsPaid($schoolYearId, $semester);
    
    $totalCashIn = 0;
    foreach ($cashIn as $transaction) {
        $totalCashIn += $transaction['amount'];
    }
    
    $totalCashOut = 0;
    foreach ($cashOut as $transaction) {
        $totalCashOut += $transaction['amount'];
    }
    
    $totalFunds = $totalCashIn - $totalCashOut;
    
    $response = [
        'cashIn' => $cashIn,
        'cashOut' => $cashOut,
        'totalCashIn' => $totalCashIn,
        'totalCashOut' => $totalCashOut,
        'totalFunds' => $totalFunds,
        'totalStudents' => $students
    ];
    
    echo json_encode($response);
}

if (isset($_GET['action']) && $_GET['action'] === 'get_student_paid') {
    $admin = new Admin();
    $schoolYearId = isset($_GET['school_year_id']) ? $_GET['school_year_id'] : null;
    $semester = isset($_GET['semester']) ? $_GET['semester'] : null;
    
    // $studentPaid = $admin->getStudentPaidRecord($schoolYearId, $semester);
    echo json_encode($studentPaid);
}