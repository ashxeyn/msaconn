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
    
    $carousel = $userObj->fetchCarousel();
    $home = $userObj->fetchHome();
    $orgUpdates = $userObj->fetchOrgUpdatesWithImages();
    $prayerSchedule = $adminObj->fetchPrayerSchedule();
    
    $response = [
        'status' => 'success',
        'data' => [
            'carousel' => $carousel,
            'home' => $home,
            'prayerSchedule' => $prayerSchedule,
            'orgUpdates' => $orgUpdates
        ]
    ];
    
    error_log('Landing page data fetched successfully');
    
} catch (Exception $e) {
    error_log('Error in fetchLandingPage: ' . $e->getMessage());
    
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
}

echo json_encode($response);
exit;