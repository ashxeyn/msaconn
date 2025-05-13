<?php
require_once '../../classes/userClass.php';

$user = new User();
$data = $user->fetchTransparencyReports();

header('Content-Type: application/json');
echo json_encode($data);