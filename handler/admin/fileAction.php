<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();

if (!isset($_SESSION['user_id'])) {
    echo "error: unauthorized";
    exit;
}

$userId = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';
$fileId = $_POST['file_id'] ?? null;

if ($action === 'edit') {
    $fileName = clean_input($_POST['file_name']);
    
    if (empty($fileName)) {
        echo "error: file_name_required";
        exit;
    }

    $existingFile = $adminObj->getFileById($fileId);
    if (!$existingFile) {
        echo "error: file_not_found";
        exit;
    }

    if (!empty($_FILES['file']['name'])) {
        if (!isValidFileType($_FILES['file']['type'])) {
            echo "error: invalid_file_type";
            exit;
        }
        
        $targetDir = "../../assets/downloadables/";
        $filePath = time() . '_' . basename($_FILES['file']['name']);
        $targetFile = $targetDir . $filePath;
        $fileType = $_FILES['file']['type'];
        $fileSize = $_FILES['file']['size'];

        move_uploaded_file($_FILES['file']['tmp_name'], $targetFile);
        
        if (!empty($existingFile['file_path'])) {
            $oldFile = $targetDir . $existingFile['file_path'];
            if (file_exists($oldFile)) {
                unlink($oldFile);
            }
        }
    } else {
        $filePath = $existingFile['file_path'];
        $fileType = $existingFile['file_type'];
        $fileSize = $existingFile['file_size'];
    }

    $result = $adminObj->updateFile($fileId, $fileName, $filePath, $fileType, $fileSize);
    echo $result ? "success" : "error";

} elseif ($action === 'delete') {
    $reason = clean_input($_POST['reason']);
    if (empty($reason)) {
        echo "error: reason_required";
        exit;
    }

    $result = $adminObj->softDeleteFile($fileId, $reason);
    echo $result ? "success" : "error";

} elseif ($action === 'restore') {
    $result = $adminObj->restoreFile($fileId);
    echo $result ? "success" : "error";

} elseif ($action === 'add') {
    $fileName = clean_input($_POST['file_name']);
    
    if (empty($fileName)) {
        echo "error: file_name_required";
        exit;
    }
    
    if (empty($_FILES['file']['name'])) {
        echo "error: no_file";
        exit;
    }
    
    if (!isValidFileType($_FILES['file']['type'])) {
        echo "error: invalid_file_type";
        exit;
    }
    
    $targetDir = "../../assets/downloadables/";
    $filePath = time() . '_' . basename($_FILES['file']['name']);
    $targetFile = $targetDir . $filePath;
    $fileType = $_FILES['file']['type'];
    $fileSize = $_FILES['file']['size'];
    
    if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFile)) {
        $result = $adminObj->addFile($fileName, $filePath, $fileType, $fileSize, $userId);
        echo $result ? "success" : "error";
    } else {
        echo "error: upload_failed";
    }

} else {
    echo "invalid_action";
}

// Helper function for file type validation
function isValidFileType($fileType) {
    $validTypes = [
        'application/pdf',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document'
    ];
    return in_array($fileType, $validTypes);
}
?>