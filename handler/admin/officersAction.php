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
$officerId = $_POST['officer_id'] ?? null;

if ($action === 'edit') {
    $firstName = clean_input($_POST['firstName']);
    $middleName = clean_input($_POST['middleName']);
    $surname = clean_input($_POST['surname']);
    $position = clean_input($_POST['position']);
    $program = clean_input($_POST['program']);
    $schoolYear = clean_input($_POST['schoolYear']);
    $office = isset($_POST['office']) ? clean_input($_POST['office']) : null;
    $image = null;

    $existingOfficer = $adminObj->getOfficerById($officerId);
    if (!$existingOfficer) {
        echo "error: officer_not_found";
        exit;
    }

    $positionName = $adminObj->getPositionById($position)['position_name'];
    if (strtolower($positionName) === 'adviser' || strtolower($positionName) === 'consultant') {
        $program = null;
        $office = 'N/A';
    }

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../../assets/officers/";
        $image = basename($_FILES['image']['name']);
        $targetFile = $targetDir . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    } else {
        $image = $existingOfficer['image']; 
    }

    $result = $adminObj->updateOfficer($officerId, $firstName, $middleName, $surname, $position, $program, $schoolYear, $image, $office);
    echo $result ? "success" : "error";

} elseif ($action === 'delete') {
    $reason = clean_input($_POST['reason']);
    if (empty($reason)) {
        echo "error: reason_required";
        exit;
    }

    $result = $adminObj->softDeleteOfficer($officerId, $reason);
    echo $result ? "success" : "error";

} elseif ($action === 'restore') {
    $result = $adminObj->restoreOfficer($officerId);
    echo $result ? "success" : "error";

} elseif ($action === 'add') {
    $firstName = clean_input($_POST['firstName']);
    $middleName = clean_input($_POST['middleName']);
    $surname = clean_input($_POST['surname']);
    $position = clean_input($_POST['position']);
    $program = clean_input($_POST['program']);
    $schoolYear = clean_input($_POST['schoolYear']);
    $office = isset($_POST['office']) ? clean_input($_POST['office']) : null;
    $image = null;

    $positionName = $adminObj->getPositionById($position)['position_name'];
    if (strtolower($positionName) === 'adviser' || strtolower($positionName) === 'consultant') {
        $program = null;
        $office = null;
    }

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../../assets/officers/";
        $image = basename($_FILES['image']['name']);
        $targetFile = $targetDir . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    }

    $result = $adminObj->addOfficer($firstName, $middleName, $surname, $position, $program, $schoolYear, $image, $office);
    echo $result ? "success" : "error";

} else {
    echo "invalid_action";
}
?>