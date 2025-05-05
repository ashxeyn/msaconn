<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$prayerId = $_GET['prayer_id'] ?? null;

if ($prayerId) {
    $prayer = $adminObj->getDailyPrayerById($prayerId);
    echo json_encode($prayer);
} else {
    echo json_encode([]);
}
?>