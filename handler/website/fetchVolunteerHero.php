<?php
require_once '../../classes/userClass.php';
require_once '../../tools/function.php';

// Set cache prevention headers
header('Content-Type: application/json');
header('Cache-Control: no-cache, no-store, must-revalidate');
header('Pragma: no-cache');
header('Expires: 0');

try {
    $user = new User();
    
    $volunteerInfo = $user->fetchVolunteerInfo();
    $backgroundImage = $user->fetchBackgroundImage();
    
    $response = [
        'status' => 'success',
        'data' => [
            'volunteerInfo' => $volunteerInfo,
            'backgroundImage' => $backgroundImage
        ],
        'timestamp' => time(), 
        'random' => mt_rand() 
    ];
    
    error_log('Volunteer hero data fetched successfully');
    
} catch (Exception $e) {
    error_log('Error in fetchVolunteerHero: ' . $e->getMessage());
    
    $response = [
        'status' => 'error',
        'message' => $e->getMessage(),
        'timestamp' => time()
    ];
}

echo json_encode($response);
exit;