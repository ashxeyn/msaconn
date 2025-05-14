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
    $aboutInfo = $userObj->fetchAboutInfo();
    $missionVision = $adminObj->fetchAbouts();
    $files = $adminObj->fetchDownloadableFiles();
    
    $response = [
        'status' => 'success',
        'data' => [
            'backgroundImage' => $backgroundImage,
            'aboutInfo' => $aboutInfo,
            'missionVision' => $missionVision,
            'files' => $files
        ]
    ];
    
    error_log('About page data fetched successfully');
    
} catch (Exception $e) {
    error_log('Error in fetchAbouts: ' . $e->getMessage());
    
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
}

echo json_encode($response);
exit;