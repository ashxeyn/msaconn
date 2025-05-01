<?php
header('Content-Type: application/json');

try {
    require_once '../../classes/userClass.php'; // Ensure the path is correct
    $user = new User();
    $aboutData = $user->getAboutMSAData(); // Fetch mission, vision, and description

    echo json_encode(['status' => 'success', 'data' => $aboutData]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}