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
$eventId = $_POST['event_id'] ?? null;

if ($action === 'edit') {
    $description = clean_input($_POST['description']);
    $image = null;

    $existingEvent = $adminObj->getEventById($eventId);
    if (!$existingEvent) {
        echo "error: event_not_found";
        exit;
    }

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../../assets/events/";
        $image = basename($_FILES['image']['name']);
        $targetFile = $targetDir . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    } else {
        $image = $existingEvent['image']; 
    }

    $result = $adminObj->updateEvent($eventId, $description, $image);
    echo $result ? "success" : "error";

} elseif ($action === 'delete') {
    $reason = clean_input($_POST['reason']);
    if (empty($reason)) {
        echo "error: reason_required";
        exit;
    }

    $result = $adminObj->softDeleteEvent($eventId, $reason);
    echo $result ? "success" : "error";

} elseif ($action === 'restore') {
    $result = $adminObj->restoreEvent($eventId);
    echo $result ? "success" : "error";

} elseif ($action === 'add') {
    $description = clean_input($_POST['description']);
    $image = null;

    if (!empty($_FILES['image']['name'])) {
        $targetDir = "../../assets/events/";
        $image = basename($_FILES['image']['name']);
        $targetFile = $targetDir . $image;
        move_uploaded_file($_FILES['image']['tmp_name'], $targetFile);
    }

    $result = $adminObj->addEvent($description, $image, $userId);
    echo $result ? "success" : "error";

} else {
    echo "invalid_action";
}
?>
