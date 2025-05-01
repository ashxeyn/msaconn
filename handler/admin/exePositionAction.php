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
$positionId = $_POST['position_id'] ?? null;

if ($action === 'edit') {
    $positionName = clean_input($_POST['position_name']);

    $existingPosition = $adminObj->getPositionById($positionId);
    if (!$existingPosition) {
        echo "error: position_not_found";
        exit;
    }

    $result = $adminObj->updateOfficerPosition($positionId, $positionName);
    
    if ($result === "duplicate") {
        echo "error: duplicate_position";
    } else {
        echo $result;
    }

} elseif ($action === 'delete') {
    $reason = clean_input($_POST['reason']);
    if (empty($reason)) {
        echo "error: reason_required";
        exit;
    }

    $result = $adminObj->softDeletePosition($positionId, $reason);
    echo $result ? "success" : "error";

} elseif ($action === 'restore') {
    $result = $adminObj->restorePosition($positionId);
    echo $result ? "success" : "error";

} elseif ($action === 'add') {
    $positionName = clean_input($_POST['position_name']);

    $result = $adminObj->addOfficerPosition($positionName);
    
    if ($result === "duplicate") {
        echo "error: duplicate_position";
    } else {
        echo $result;
    }

} else {
    echo "invalid_action";
}
?>