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
$volunteerId = $_POST['volunteer_id'] ?? null;

if ($action === 'edit') {
    $firstName = clean_input($_POST['firstName']);
    $middleName = clean_input($_POST['middleName']);
    $lastName = clean_input($_POST['surname']);
    $year = clean_input($_POST['year']);
    $programId = clean_input($_POST['program']);
    $contact = clean_input($_POST['contact']);
    $email = clean_input($_POST['email']);
    $corFile = null;

    $existingVolunteer = $adminObj->getVolunteerById($volunteerId);
    if (!$existingVolunteer) {
        echo "error: volunteer_not_found";
        exit;
    }

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../../assets/cors/";
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        $corFile = $fileName;
    } else {
        $corFile = $existingVolunteer['cor_file'];
    }

    $result = $adminObj->updateVolunteer(
        $volunteerId,
        $firstName,
        $middleName,
        $lastName,
        $year,
        $programId,
        $contact,
        $email,
        $corFile
    );
    echo $result ? "success" : "error";

} elseif ($action === 'delete') {
    $reason = clean_input($_POST['reason']);
    if (empty($reason)) {
        echo "error: reason_required";
        exit;
    }

    $result = $adminObj->softDeleteVolunteer($volunteerId, $reason);
    echo $result ? "success" : "error";

} elseif ($action === 'restore') {
    $result = $adminObj->restoreVolunteer($volunteerId);
    echo $result ? "success" : "error";

} elseif ($action === 'add') {
    $firstName = clean_input($_POST['firstName']);
    $middleName = clean_input($_POST['middleName']);
    $lastName = clean_input($_POST['surname']);
    $year = clean_input($_POST['year']);
    $programId = clean_input($_POST['program']);
    $contact = clean_input($_POST['contact']);
    $email = clean_input($_POST['email']);
    $corFile = null;

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../../assets/cors/";
        $fileName = time() . '_' . basename($_FILES['image']['name']);
        $targetFile = $targetDir . $fileName;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
        $corFile = $fileName;
    }

    $result = $adminObj->addVolunteer(
        $firstName,
        $middleName,
        $lastName,
        $year,
        $programId,
        $contact,
        $email,
        $corFile
    );
    echo $result ? "success" : "error";

} else {
    echo "invalid_action";
}
?>