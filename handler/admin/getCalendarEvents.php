<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$activityId = $_GET['activity_id'] ?? null;

if ($activityId) {
    $activity = $adminObj->getCalendarEventById($activityId);
    echo json_encode($activity);
} else {
    echo json_encode([]);
}
?>