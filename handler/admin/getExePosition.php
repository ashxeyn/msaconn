<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$positionId = $_GET['position_id'] ?? null;

if ($positionId) {
    $position = $adminObj->getPositionById($positionId);
    echo json_encode($position);
} else {
    echo json_encode([]);
}
?>