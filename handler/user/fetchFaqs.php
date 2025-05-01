<?php
require_once '../../classes/userClass.php';

header('Content-Type: application/json');

$user = new User();
$faqs = $user->fetchUserFaqs();

echo json_encode([
    'status' => 'success',
    'data' => $faqs
]);