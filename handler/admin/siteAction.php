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
$pageId = $_POST['page_id'] ?? null;

if ($action === 'edit') {
    $title = clean_input($_POST['title']);
    $description = clean_input($_POST['description']);

    $existingPage = $adminObj->getSitePageById($pageId);
    if (!$existingPage) {
        echo "error: page_not_found";
        exit;
    }

    $result = $adminObj->updateSitePage($pageId, $title, $description);
    echo $result ? "success" : "error";

} elseif ($action === 'toggle') {
    $result = $adminObj->toggleSitePageStatus($pageId);
    echo $result ? "success" : "error";

} else {
    echo "invalid_action";
}
?>