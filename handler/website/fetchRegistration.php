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
    
    $backgroundImage = $userObj->fetchBackgroundImage();
    $registrationInfo = $userObj->fetchRegistrationInfo();
    
    $response = [
        'status' => 'success',
        'data' => [
            'backgroundImage' => $backgroundImage,
            'registrationInfo' => $registrationInfo
        ]
    ];
    
    error_log('Registration madrasa data fetched successfully');
    
} catch (Exception $e) {
    error_log('Error in fetchRegistration: ' . $e->getMessage());
    
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
}

echo json_encode($response);
exit;