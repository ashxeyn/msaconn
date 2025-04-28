<?php
require_once '../../classes/adminClass.php';

$adminObj = new Admin();
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

$totalVolunteers = $adminObj->getApprovedVolunteers($startDate, $endDate);
$pendingRegistrations = $adminObj->getPedingVolunteers($startDate, $endDate);
$moderators = $adminObj->getModerators($startDate, $endDate);

$data = [
    'volunteers' => $totalVolunteers,
    'pending' => $pendingRegistrations,
    'moderators' => $moderators
];

echo json_encode($data);
?>