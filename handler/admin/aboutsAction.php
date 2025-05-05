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
$aboutId = $_POST['id'] ?? null;

if ($action === 'edit') {
    $mission = clean_input($_POST['mission']);
    $vision = clean_input($_POST['vision']);

    $existingAbout = $adminObj->getAboutById($aboutId);
    if (!$existingAbout) {
        echo "error: about_not_found";
        exit;
    }

    $result = $adminObj->updateAbout($aboutId, $mission, $vision);
    echo $result ? "success" : "error";

} elseif ($action === 'delete') {
    $reason = clean_input($_POST['reason']);
    if (empty($reason)) {
        echo "error: reason_required";
        exit;
    }

    $result = $adminObj->softDeleteAbout($aboutId, $reason);
    echo $result ? "success" : "error";

} elseif ($action === 'restore') {
    $result = $adminObj->restoreAbout($aboutId);
    echo $result ? "success" : "error";

} elseif ($action === 'add') {
    $mission = clean_input($_POST['mission']);
    $vision = clean_input($_POST['vision']);

    $result = $adminObj->addAbout($mission, $vision);
    echo $result ? "success" : "error";

} else {
    echo "invalid_action";
}
?>