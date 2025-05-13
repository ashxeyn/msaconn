<?php
require_once '../../classes/userClass.php';
require_once '../../tools/function.php';

header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

try {
    $userObj = new User();
    $footer = $userObj->fetchFooterInfo();
    $logo = $userObj->fetchLogo();
    
    $response = [
        'status' => 'success',
        'data' => [
            'footer' => $footer,
            'logo' => $logo
        ]
    ];
} catch (Exception $e) {
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
}

echo json_encode($response);