<?php
require_once '../../classes/userClass.php';

header('Content-Type: application/json');

try {
    $user = new User();
    $prayerSchedules = $user->fetchPrayerSchedules();

    echo json_encode([
        'status' => 'success',
        'data' => $prayerSchedules
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}