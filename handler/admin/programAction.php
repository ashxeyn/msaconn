<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();

$action = $_POST['action'] ?? '';
$programId = $_POST['program_id'] ?? null;

if ($action === 'edit') {
    $programName = clean_input($_POST['programName']);
    $collegeId = clean_input($_POST['collegeSelect']);

    if (empty($programName)) {
        echo "error_empty_name";
        exit;
    }

    if (empty($collegeId)) {
        echo "error_empty_college";
        exit;
    }

    $result = $adminObj->updateProgram($programId, $programName, $collegeId);
    echo $result ? "success" : "error";
} elseif ($action === 'delete') {
    $deleteReason = clean_input($_POST['deleteReason']);
    
    if (empty($deleteReason)) {
        echo "error_empty_reason";
        exit;
    }
    
    $result = $adminObj->softDeleteProgram($programId, $deleteReason);
    echo $result ? "success" : "error";
} elseif ($action === 'add') {
    $programName = clean_input($_POST['programName']);
    $collegeId = clean_input($_POST['collegeSelect']);

    if (empty($programName)) {
        echo "error_empty_name";
        exit;
    }

    if (empty($collegeId)) {
        echo "error_empty_college";
        exit;
    }

    $result = $adminObj->addProgram($programName, $collegeId);
    echo $result ? "success" : "error";
} elseif ($action === 'restore') {
    $result = $adminObj->restoreProgram($programId);
    echo $result ? "success" : "error";
} else {
    echo "invalid_action";
}
?>