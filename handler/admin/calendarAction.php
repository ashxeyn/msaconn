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
$activityId = $_POST['activity_id'] ?? null;

if ($action === 'edit') {
    $activityDate = clean_input($_POST['activity_date']);
    $endDate = clean_input($_POST['end_date']);
    $time = clean_input($_POST['time']);
    $venue = clean_input($_POST['venue']);
    $title = clean_input($_POST['title']);
    $description = clean_input($_POST['description']);
    
    if (!empty($endDate) && $endDate < $activityDate) {
        echo "error: end_date_before_start";
        exit;
    }
    if (empty($time) || empty($venue)) {
        echo "error: time_venue_required";
        exit;
    }
    $existingActivity = $adminObj->getCalendarEventById($activityId);
    if (!$existingActivity) {
        echo "error: activity_not_found";
        exit;
    }
    $result = $adminObj->updateCalendarEvent($activityId, $activityDate, $endDate, $time, $venue, $title, $description);
    echo $result ? "success" : "error";
} elseif ($action === 'delete') {
    $reason = clean_input($_POST['reason']);
    if (empty($reason)) {
        echo "error: reason_required";
        exit;
    }
    $result = $adminObj->softDeleteCalendarEvent($activityId, $reason);
    echo $result ? "success" : "error";
} elseif ($action === 'restore') {
    $result = $adminObj->restoreCalendarEvent($activityId);
    echo $result ? "success" : "error";
} elseif ($action === 'add') {
    $activityDate = clean_input($_POST['activity_date']);
    $endDate = clean_input($_POST['end_date']);
    $time = clean_input($_POST['time']);
    $venue = clean_input($_POST['venue']);
    $title = clean_input($_POST['title']);
    $description = clean_input($_POST['description']);
    
    if (!empty($endDate) && $endDate < $activityDate) {
        echo "error: end_date_before_start";
        exit;
    }
    if (empty($time) || empty($venue)) {
        echo "error: time_venue_required";
        exit;
    }
    $result = $adminObj->addCalendarEvent($activityDate, $endDate, $time, $venue, $title, $description, $userId);
    echo $result ? "success" : "error";
} else {
    echo "invalid_action";
}
?>