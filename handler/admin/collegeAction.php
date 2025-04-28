<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();

$action = $_POST['action'] ?? '';
$collegeId = $_POST['college_id'] ?? null;

if ($action === 'edit') {
    $collegeName = clean_input($_POST['collegeName']);

    if (empty($collegeName)) {
        echo "error_empty_name";
        exit;
    }

    $result = $adminObj->updateCollege($collegeId, $collegeName);
    echo $result ? "success" : "error";
} elseif ($action === 'delete') {
    $deleteReason = clean_input($_POST['deleteReason']);
    
    if (empty($deleteReason)) {
        echo "error_empty_reason";
        exit;
    }
    
    $result = $adminObj->softDeleteCollege($collegeId, $deleteReason);
    echo $result ? "success" : "error";
} elseif ($action === 'add') {
    $collegeName = clean_input($_POST['collegeName']);

    if (empty($collegeName)) {
        echo "error_empty_name";
        exit;
    }

    $result = $adminObj->addCollege($collegeName);
    echo $result ? "success" : "error";
} elseif ($action === 'restore') {
    $result = $adminObj->restoreCollege($collegeId);
    echo $result ? "success" : "error";
} else {
    echo "invalid_action";
}
?>