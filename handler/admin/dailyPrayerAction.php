<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';
$adminObj = new Admin();

if (!isset($_SESSION['user_id'])) {
    echo "error: unauthorized";
    exit;
}

$userId = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';
$prayerId = $_POST['prayer_id'] ?? null;

if ($action === 'edit') {
    $prayerType = clean_input($_POST['prayer_type']);
    $date = clean_input($_POST['date']);
    $speaker = clean_input($_POST['speaker']);
    $topic = clean_input($_POST['topic']);
    $location = clean_input($_POST['location']);
    
    // Set speaker to TBA if empty
    if (empty($speaker)) {
        $speaker = 'TBA';
    }
    
    $existingPrayer = $adminObj->getDailyPrayerById($prayerId);
    if (!$existingPrayer) {
        echo "error: prayer_not_found";
        exit;
    }
    
    $result = $adminObj->updateDailyPrayer($prayerId, $prayerType, $date, $speaker, $topic, $location);
    echo $result ? "success" : "error";
    
} elseif ($action === 'delete') {
    $reason = clean_input($_POST['reason']);
    
    if (empty($reason)) {
        echo "error: reason_required";
        exit;
    }
    
    $result = $adminObj->softDeleteDailyPrayer($prayerId, $reason);
    echo $result ? "success" : "error";
    
} elseif ($action === 'restore') {
    $result = $adminObj->restoreDailyPrayer($prayerId);
    echo $result ? "success" : "error";
    
} elseif ($action === 'add') {
    $prayerType = clean_input($_POST['prayer_type']);
    $date = clean_input($_POST['date']);
    $speaker = clean_input($_POST['speaker']);
    $topic = clean_input($_POST['topic']);
    $location = clean_input($_POST['location']);
    
    if (empty($speaker)) {
        $speaker = 'TBA';
    }
    
    $result = $adminObj->addDailyPrayer($prayerType, $date, $speaker, $topic, $location, $userId);
    echo $result ? "success" : "error";
    
} else {
    echo "invalid_action";
}
?>