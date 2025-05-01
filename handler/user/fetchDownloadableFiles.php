<?php
header('Content-Type: application/json');

require_once '../../classes/userClass.php';

try {
    $user = new User();
    $files = $user->fetchDownloadableFiles();
    echo json_encode(['status' => 'success', 'data' => $files]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}