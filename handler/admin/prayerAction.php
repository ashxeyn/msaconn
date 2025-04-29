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

if ($action === 'add' || $action === 'edit') {
    $date = clean_input($_POST['khutbah_date']);
    $speaker = clean_input($_POST['speaker']);
    $topic = clean_input($_POST['topic']);
    $location = clean_input($_POST['location']);

    if ($action === 'add') {
        $result = $adminObj->addPrayerSchedule($date, $speaker, $topic, $location, $userId);
    } else {
        $result = $adminObj->updatePrayerSchedule($prayerId, $date, $speaker, $topic, $location);
    }

    echo $result ? "success" : "error";

} elseif ($action === 'delete') {
    $reason = clean_input($_POST['reason']);
    if (empty($reason)) {
        echo "error: reason_required";
        exit;
    }

    $result = $adminObj->softDeletePrayerSchedule($prayerId, $reason);
    echo $result ? "success" : "error";

} elseif ($action === 'restore') {
    $result = $adminObj->restorePrayerSchedule($prayerId);
    echo $result ? "success" : "error";

} else {
    echo "invalid_action";
}
?>