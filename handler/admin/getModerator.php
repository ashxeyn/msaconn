<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$moderatorId = $_GET['user_id'] ?? null;

if ($moderatorId) {
    $moderator = $adminObj->getModeratorById($moderatorId);
    echo json_encode($moderator);
} else {
    echo json_encode([]);
}
?>