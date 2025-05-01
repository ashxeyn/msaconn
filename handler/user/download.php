<?php
require_once '../../classes/databaseClass.php';

if (!isset($_GET['file_id'])) {
    die('Invalid request');
}

$file_id = intval($_GET['file_id']);

try {
    $db = new Database();
    $conn = $db->connect();

    // Use file_type instead of mime_type
    $sql = "SELECT file_name, file_path, file_type FROM downloadable_files WHERE file_id = :file_id AND is_deleted = 0";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':file_id', $file_id, PDO::PARAM_INT);
    $stmt->execute();
    $file = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$file) {
        die('File not found');
    }

    $filePath = __DIR__ . '/../../' . $file['file_path'];
    if (!file_exists($filePath)) {
        die('File not found on server');
    }
    
    error_log('Looking for file at: ' . $filePath);

    header('Content-Type: ' . $file['file_type']);
    header('Content-Disposition: attachment; filename="' . basename($file['file_name']) . '"');
    header('Content-Length: ' . filesize($filePath));
    readfile($filePath);
    exit;
} catch (Exception $e) {
    die('Error: ' . $e->getMessage());
}