<?php
require_once '../../classes/userClass.php';
require_once '../../tools/function.php';

header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

try {
    $userObj = new User();
    
    $backgroundImage = $userObj->fetchBackgroundImage();
    $faqsInfo = $userObj->fetchFaqsInfo();
    
    $response = [
        'status' => 'success',
        'data' => [
            'backgroundImage' => $backgroundImage,
            'faqsInfo' => $faqsInfo
        ]
    ];
    
    error_log('FAQs data fetched successfully');
    
} catch (Exception $e) {
    error_log('Error in fetchFaqs: ' . $e->getMessage());
    
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
}

echo json_encode($response);
exit;