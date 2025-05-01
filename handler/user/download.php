<?php
session_start();
require_once __DIR__.'/../../classes/userClass.php';
require_once __DIR__.'/../../tools/function.php'; // Include the functions file

$user = new User();

if (!isset($_GET['file_id']) || !ctype_digit($_GET['file_id'])) {
    http_response_code(400);
    exit('Invalid file ID');
}

$fileId = (int)$_GET['file_id'];

try {
    $file = $user->getFileById($fileId);
    
    if (!$file) {
        throw new Exception("File not found in database");
    }
    
    $filePath = __DIR__ . '/../../assets/downloadables/' . basename($file['file_path']);
    
    if (!file_exists($filePath)) {
        throw new Exception("File not found on server");
    }

    // Set proper headers based on file type
    header('Content-Description: File Transfer');
    header('Content-Type: ' . $file['file_type']); // Use MIME type from the database
    header('Content-Disposition: attachment; filename="' . basename($file['file_name']) . '"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filePath));

    readfile($filePath);
    exit;
    
} catch (Exception $e) {
    error_log("Download error: " . $e->getMessage());
    http_response_code(404);
    exit($e->getMessage());
}