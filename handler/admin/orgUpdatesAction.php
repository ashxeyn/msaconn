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
$updateId = $_POST['update_id'] ?? null;

if ($action === 'edit') {
    $title = clean_input($_POST['title']);
    $content = clean_article_content($_POST['content']);

    $existingUpdate = $adminObj->getUpdateById($updateId);
    if (!$existingUpdate) {
        echo "error: update_not_found";
        exit;
    }

    // Start with updating the main update record
    $result = $adminObj->updateOrgUpdate($updateId, $title, $content);
    
    // Handle image deletions if any were specified
    if (isset($_POST['deleted_images']) && !empty($_POST['deleted_images'])) {
        $deletedImages = json_decode($_POST['deleted_images'], true);
        if (!empty($deletedImages)) {
            $adminObj->deleteSpecificUpdateImages($deletedImages);
        }
    }
    
    // Handle new image uploads if any
    $imagePaths = [];
    
    if (!empty($_FILES['images']['name'][0])) {
        $targetDir = "../../assets/updates/";
        
        // Process new image uploads
        foreach ($_FILES['images']['name'] as $key => $filename) {
            if (!empty($filename)) {
                $image = uniqid() . '_' . basename($filename);
                $targetFile = $targetDir . $image;
                
                if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $targetFile)) {
                    $imagePaths[] = $image;
                }
            }
        }
        
        // Add new images
        if (!empty($imagePaths)) {
            $adminObj->addUpdateImages($updateId, $imagePaths);
        }
    }

    echo $result ? "success" : "error";

} elseif ($action === 'delete') {
    $reason = clean_input($_POST['reason']);
    if (empty($reason)) {
        echo "error: reason_required";
        exit;
    }

    $result = $adminObj->softDeleteOrgUpdate($updateId, $reason);
    echo $result ? "success" : "error";

} elseif ($action === 'restore') {
    $result = $adminObj->restoreOrgUpdate($updateId);
    echo $result ? "success" : "error";

} elseif ($action === 'add') {
    $title = clean_input($_POST['title']);
    $content = clean_article_content($_POST['content']);

    // First, add the main update record
    $updateId = $adminObj->addOrgUpdate($title, $content, $userId);
    
    if ($updateId) {
        // Then handle any image uploads
        $imagePaths = [];
        
        if (!empty($_FILES['images']['name'][0])) {
            $targetDir = "../../assets/updates/";
            
            foreach ($_FILES['images']['name'] as $key => $filename) {
                if (!empty($filename)) {
                    $image = uniqid() . '_' . basename($filename);
                    $targetFile = $targetDir . $image;
                    
                    if (move_uploaded_file($_FILES['images']['tmp_name'][$key], $targetFile)) {
                        $imagePaths[] = $image;
                    }
                }
            }
            
            // Add image records
            if (!empty($imagePaths)) {
                $adminObj->addUpdateImages($updateId, $imagePaths);
            }
        }
        
        echo "success";
    } else {
        echo "error";
    }

} else {
    echo "invalid_action";
}
?>