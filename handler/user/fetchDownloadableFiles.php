<?php
require_once '../../classes/databaseClass.php';

try {
    $db = new Database();
    $conn = $db->connect();

    // Use created_at instead of uploaded_at and limit to 6 latest files
    $sql = "SELECT file_id, file_name, file_type, created_at FROM downloadable_files WHERE is_deleted = 0 ORDER BY created_at DESC LIMIT 6";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $files = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode(['status' => 'success', 'data' => $files]);
} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}