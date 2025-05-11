<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$pageId = $_GET['page_id'] ?? null;
$pageType = $_GET['page_type'] ?? null;
$limit = $_GET['limit'] ?? null;

if ($pageType === 'carousel' && $limit) {
    $sitePages = $adminObj->fetchSitePages();
    $carousel = array_filter($sitePages, function($p) {
        return $p['page_type'] === 'carousel';
    });
    $carousel = array_slice($carousel, 0, (int)$limit);
    echo json_encode(array_values($carousel));
    exit;
}

if ($pageId) {
    $page = $adminObj->getSitePageById($pageId);
    echo json_encode($page);
} else {
    echo json_encode([]);
}
?>