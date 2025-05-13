<?php
session_start();
require_once '../../classes/userClass.php';
header('Content-Type: application/json');

$userObj = new User();
$activity_id = isset($_GET['activity_id']) ? intval($_GET['activity_id']) : 0;

if (!$activity_id) {
    echo json_encode(['status' => 'error', 'message' => 'Activity ID is required']);
    exit;
}

$activityDetails = $userObj->getActivityById($activity_id);

if ($activityDetails) {
    echo json_encode(['status' => 'success', 'data' => $activityDetails]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Activity not found']);
} 