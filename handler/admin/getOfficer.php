<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$officerId = $_GET['officer_id'] ?? null;

if ($officerId) {
    $officer = $adminObj->getOfficerById($officerId);
    echo json_encode($officer);
} else {
    echo json_encode([]);
}
?>