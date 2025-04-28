<?php
require_once '../../classes/adminClass.php';

$adminObj = new Admin();
$startDate = isset($_GET['start_date']) ? $_GET['start_date'] : null;
$endDate = isset($_GET['end_date']) ? $_GET['end_date'] : null;

$volunteerStats = $adminObj->getVolunteersPerMonth($startDate, $endDate);

// header('Content-Type: application/json');
echo json_encode($volunteerStats);
?>