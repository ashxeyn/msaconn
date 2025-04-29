<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$aboutId = $_GET['id'] ?? null;

if ($aboutId) {
    $about = $adminObj->getAboutById($aboutId);
    echo json_encode($about);
} else {
    echo json_encode([]);
}
?>