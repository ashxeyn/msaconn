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
    $date = clean_input($_POST['date']);
    $time = clean_input($_POST['time']);
    $topic = clean_input($_POST['topic']);
    $speaker = clean_input($_POST['speaker']);
    $location = clean_input($_POST['location']);
    $existingPrayer = $adminObj->getPrayerById($prayerId);
    if (!$existingPrayer) {
        echo "error: prayer_not_found";
        exit;
    }
    $result = $adminObj->updatePrayer($prayerId, $date, $time, $topic, $speaker, $location);
    echo $result ? "success" : "error";
} elseif ($action === 'delete') {
    $reason = clean_input($_POST['reason']);
    if (empty($reason)) {
        echo "error: reason_required";
        exit;
    }
    $result = $adminObj->softDeletePrayer($prayerId, $reason);
    echo $result ? "success" : "error";
} elseif ($action === 'restore') {
    $result = $adminObj->restorePrayer($prayerId);
    echo $result ? "success" : "error";
} elseif ($action === 'add') {
    $date = clean_input($_POST['date']);
    $time = clean_input($_POST['time']);
    $topic = clean_input($_POST['topic']);
    $speaker = clean_input($_POST['speaker']);
    $location = clean_input($_POST['location']);
    $result = $adminObj->addPrayer($date, $time, $topic, $speaker, $location, $userId);
    echo $result ? "success" : "error";
} else {
    echo "invalid_action";
}
?>