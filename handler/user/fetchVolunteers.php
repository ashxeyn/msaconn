<?php
require_once '../../classes/userClass.php';

header('Content-Type: application/json');

$user = new User();
$volunteers = $user->fetchVolunteers();

echo json_encode($volunteers);