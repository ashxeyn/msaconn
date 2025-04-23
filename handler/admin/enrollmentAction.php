<?php
session_start();
require_once '../../classes/adminClass.php';

$adminObj = new Admin();
$response = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_SESSION['user_id'])) {
        echo 'error: unauthorized';
        exit;
    }

    $adminUserId = $_SESSION['user_id'];
    $enrollmentId = $_POST['enrollment_id'] ?? null;
    $action = $_POST['action'] ?? null;

    if (!$enrollmentId || !$action) {
        echo 'error: missing_data';
        exit;
    }

    if ($action === 'enroll') {
        $isEnrolled = $adminObj->enrollStudent($enrollmentId, $adminUserId);
        $response = $isEnrolled ? 'success' : 'error: db_enroll_fail';
    } elseif ($action === 'reject') {
        $isRejected = $adminObj->rejectEnrollment($enrollmentId, $adminUserId);
        $response = $isRejected ? 'success' : 'error: db_reject_fail';
    } else {
        $response = 'error: invalid_action';
    }

    echo $response;
    exit;
}
?>