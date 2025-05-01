<?php
header('Content-Type: application/json');

try {
    require_once '../../classes/userClass.php'; // Ensure the path is correct
    $user = new User();
    $files = $user->fetchDownloadableFiles(); // Fetch downloadable files from the database

    // Debugging: Log the fetched files
    error_log("Fetched files: " . print_r($files, true));

    echo json_encode(['status' => 'success', 'data' => $files]);
} catch (Exception $e) {
    // Debugging: Log the error message
    error_log("Error fetching downloadable files: " . $e->getMessage());

    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}