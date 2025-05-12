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
$pageId = $_POST['page_id'] ?? null;

if ($action === 'edit' || $action === 'add') {
    $pageType = clean_input($_POST['page_type']);
    $title = clean_input($_POST['title']);
    $description = clean_input($_POST['description'] ?? null);
    $contactNo = clean_input($_POST['contact_no'] ?? null);
    $email = clean_input($_POST['email'] ?? null);
    
    $imagePath = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../../assets/site/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileExt = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $fileName = uniqid() . '.' . $fileExt;
        $imagePath = 'assets/site/' . $fileName;
        
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $uploadDir . $fileName)) {
            echo "error: file_upload_failed";
            exit;
        }
    }

    if ($action === 'edit') {
        $existingPage = $adminObj->getSitePageById($pageId);
        if (!$existingPage) {
            echo "error: page_not_found";
            exit;
        }

        if (!$imagePath && $existingPage['image_path']) {
            $imagePath = $existingPage['image_path'];
        }

        $result = $adminObj->updateSitePage(
            $pageId, 
            $pageType, 
            $title, 
            $description, 
            $imagePath, 
            $contactNo, 
            $email
        );
    } else { 
        $result = $adminObj->addSitePage(
            $pageType, 
            $title, 
            $description, 
            $imagePath, 
            $contactNo, 
            $email
        );
    }
    
    echo $result ? "success" : "error";

} elseif ($action === 'toggle') {
    $result = $adminObj->toggleSitePageStatus($pageId);
    echo $result ? "success" : "error";

} elseif ($action === 'toggle_carousel_group') {
    $status = isset($_POST['status']) ? (int)$_POST['status'] : null;
    if ($status === null) {
        echo json_encode(['success' => false, 'message' => 'Missing status parameter.']);
        exit;
    }
    $result = $adminObj->toggleAllCarousel($status);
    if ($result) {
        echo json_encode(['success' => true, 'message' => 'Carousel group status updated.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update carousel group.']);
    }
    exit;

} elseif ($action === 'edit_carousel_group') {
    $ids = $_POST['carousel_ids'] ?? [];
    $titles = $_POST['carousel_titles'] ?? [];
    $files = $_FILES['carousel_images'] ?? null;
    $activeArr = $_POST['carousel_active'] ?? [];
    $allSuccess = true;
    for ($i = 0; $i < count($ids); $i++) {
        $pageId = $ids[$i];
        if (!$pageId) continue; // Skip empty slots
        $title = isset($titles[$i]) ? trim(clean_input($titles[$i])) : '';
        $imagePath = null;
        $existingPage = $adminObj->getSitePageById($pageId);
        if (!$existingPage) {
            $allSuccess = false;
            continue;
        }
        // Handle file upload for this image
        if ($files && isset($files['error'][$i]) && $files['error'][$i] === UPLOAD_ERR_OK) {
            $uploadDir = '../../assets/site/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileExt = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $fileName = uniqid() . '.' . $fileExt;
            $imagePath = 'assets/site/' . $fileName;
            if (!move_uploaded_file($files['tmp_name'][$i], $uploadDir . $fileName)) {
                $allSuccess = false;
                $imagePath = $existingPage['image_path'];
            }
        } else {
            $imagePath = $existingPage['image_path'];
        }
        // If title is blank, keep the old title
        if ($title === '') {
            $title = $existingPage['title'];
        }
        // Determine is_active for this image
        $isActive = 0;
        if (isset($activeArr[$i]) && $activeArr[$i] == '1') {
            $isActive = 1;
        }
        $result = $adminObj->updateSitePage(
            $pageId,
            'carousel',
            $title,
            $existingPage['description'],
            $imagePath,
            $existingPage['contact_no'],
            $existingPage['email'],
            $isActive
        );
        if (!$result) {
            $allSuccess = false;
        }
    }
    if ($allSuccess) {
        echo json_encode(['success' => true, 'message' => 'Carousel images updated.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update some carousel images.']);
    }
    exit;

} else {
    echo "invalid_action";
}