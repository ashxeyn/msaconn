<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$updateId = $_GET['update_id'] ?? null;

if ($updateId) {
    $update = $adminObj->getUpdateById($updateId);
    $images = $adminObj->getUpdateImages($updateId);
    
    $response = [
        'update' => $update,
        'images' => $images
    ];
    
    echo json_encode($response);
} else {
    echo json_encode([]);
}
?>