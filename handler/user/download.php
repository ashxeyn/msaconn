<?php
// File: handler/user/download.php

// Start session if needed
session_start();

// Include necessary files
require_once __DIR__.'/../../classes/userClass.php';
require_once __DIR__.'/../../includes/helpers.php';

// Initialize User class
$user = new User();

// Check if file_id is provided
if (!isset($_GET['file_id']) || empty($_GET['file_id'])) {
    header('HTTP/1.0 400 Bad Request');
    echo "File ID is required";
    exit;
}

// Get file ID and sanitize it
$fileId = filter_input(INPUT_GET, 'file_id', FILTER_SANITIZE_NUMBER_INT);

// Get file details
$file = $user->getFileById($fileId);

if (!$file) {
    header('HTTP/1.0 404 Not Found');
    echo "File not found in database";
    exit;
}

// Correctly build the file path - the file_path column only contains the filename
$filePath = __DIR__ . '/../../assets/downloadables/' . $file['file_path'];

// Check if file exists
if (!file_exists($filePath)) {
    // Try alternative path without nested directories
    $altPath = $_SERVER['DOCUMENT_ROOT'] . '/msaconnect/assets/downloadables/' . $file['file_path'];
    
    if (!file_exists($altPath)) {
        header('HTTP/1.0 404 Not Found');
        echo "File not found on server. Please check file storage location.";
        exit;
    } else {
        $filePath = $altPath;
    }
}

// Set appropriate headers for download
header("Content-Type: " . $file['file_type']);
header("Content-Disposition: attachment; filename=\"" . $file['file_name'] . "\"");
header("Content-Length: " . filesize($filePath));
header("Cache-Control: no-cache");
header("Pragma: no-cache");

// Output file contents and exit
readfile($filePath);
exit;