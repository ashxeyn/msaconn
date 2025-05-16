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
    $time = clean_input($_POST['time']);
    $iqamah = clean_input($_POST['iqamah']);
    $location = clean_input($_POST['location']);
    
    if (empty($prayerType) || empty($date) || empty($time) || empty($iqamah) || empty($location)) {
        echo "error: missing_required_fields";
        exit;
    }
    
    $existingPrayer = $adminObj->getDailyPrayerById($prayerId);
    if (!$existingPrayer) {
        echo "error: prayer_not_found";
        exit;
    }
    
    $result = $adminObj->updateDailyPrayer($prayerId, $prayerType, $date, $time, $iqamah, $location);
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
    $time = clean_input($_POST['time']);
    $iqamah = clean_input($_POST['iqamah']);
    $location = clean_input($_POST['location']);
    
    if (empty($prayerType) || empty($date) || empty($time) || empty($iqamah) || empty($location)) {
        echo "error: missing_required_fields";
        exit;
    }
    
    $result = $adminObj->addDailyPrayer($prayerType, $date, $time, $iqamah, $location, $userId);
    echo $result ? "success" : "error";
    
} else {
    echo "invalid_action";
}
?>