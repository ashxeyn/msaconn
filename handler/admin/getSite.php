<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$pageId = $_GET['page_id'] ?? null;

if ($pageId) {
    $page = $adminObj->getSitePageById($pageId);
    echo json_encode($page);
} else {
    echo json_encode([]);
}
?>