<?php
require_once '../../classes/userClass.php';
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

try {
    $userObj = new User();
    $adminObj = new Admin();
    
    $backgroundImage = $userObj->fetchBackgroundImage();
    $transparencyInfo = $userObj->fetchTransparencyInfo();
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
    
    $response = [
        'status' => 'success',
        'data' => [
            'backgroundImage' => $backgroundImage,
            'transparencyInfo' => $transparencyInfo,
            'cashIn' => $cashIn,
            'cashOut' => $cashOut,
            'totalCashIn' => $totalCashIn,
            'totalCashOut' => $totalCashOut,
            'totalFunds' => $totalFunds
        ]
    ];
    
    error_log('Transparency report data fetched successfully');
    
} catch (Exception $e) {
    error_log('Error in fetchTransparency: ' . $e->getMessage());
    
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
}

echo json_encode($response);
exit;