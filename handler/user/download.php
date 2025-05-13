<?php
require_once '../../classes/databaseClass.php';

if (!isset($_GET['file_id'])) {
    die('Invalid request - no file ID provided');
}

$file_id = intval($_GET['file_id']);

try {
    $db = new Database();
    $conn = $db->connect();

    // Get file information from database with both deletion checks
    $sql = "SELECT file_name, file_path, file_type FROM downloadable_files 
            WHERE file_id = :file_id AND is_deleted = 0 AND deleted_at IS NULL";
    
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':file_id', $file_id, PDO::PARAM_INT);
    $stmt->execute();
    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$file) {
        error_log("File with ID $file_id not found in database or has been deleted");
        die('File not found in database or has been deleted');
    }

    // Construct the full path to the file
    $filePath = '../../assets/downloadables/' . $file['file_path'];
    
    if (!file_exists($filePath)) {
        error_log('File not found at path: ' . $filePath);
        die('File not found on server at expected location');
    }
    
    // Log successful file finding
    error_log('Found file at: ' . $filePath);

    // Set appropriate headers for downloading the file
    header('Content-Type: ' . $file['file_type']);
    header('Content-Disposition: attachment; filename="' . basename($file['file_name']) . '"');
    header('Content-Length: ' . filesize($filePath));
    
    // Send the file to the browser
    readfile($filePath);
    exit;
} catch (Exception $e) {
    error_log('Download error: ' . $e->getMessage());
    die('Error downloading file: ' . $e->getMessage());
}