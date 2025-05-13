<?php
require_once '../../classes/userClass.php';

$userObj = new User();

try {
    $updates = $userObj->fetchOrgUpdates();
    echo json_encode([
        'status' => 'success',
        'data' => $updates
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}