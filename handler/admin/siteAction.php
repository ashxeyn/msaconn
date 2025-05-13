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
    $orgName = isset($_POST['org_name']) ? clean_input($_POST['org_name']) : null;
    $schoolName = isset($_POST['school_name']) ? clean_input($_POST['school_name']) : null;
    $webName = isset($_POST['web_name']) ? clean_input($_POST['web_name']) : null;
    $fbLink = isset($_POST['fb_link']) ? clean_input($_POST['fb_link']) : null;
    
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

        if ($pageType === 'footer') {
            $result = $adminObj->updateSitePage(
                $pageId, 
                $pageType, 
                $title, 
                $description, 
                $imagePath, 
                $contactNo, 
                $email,
                null,
                $orgName,
                $schoolName,
                $webName,
                $fbLink
            );
        } else {
            $result = $adminObj->updateSitePage(
                $pageId, 
                $pageType, 
                $title, 
                $description, 
                $imagePath, 
                $contactNo, 
                $email
            );
        }
    } else { 
        if ($pageType === 'footer') {
            $result = $adminObj->addSitePage(
                $pageType, 
                $title, 
                $description, 
                $imagePath, 
                $contactNo, 
                $email,
                $orgName,
                $schoolName,
                $webName,
                $fbLink
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
    $allSuccess = true;
    $newUploads = [];
    $updatedIds = [];
    for ($i = 0; $i < count($ids); $i++) {
        $pageId = $ids[$i];
        if (!$pageId) continue; 
        $title = isset($titles[$i]) ? trim(clean_input($titles[$i])) : '';
        $imagePath = null;
        $existingPage = $adminObj->getSitePageById($pageId);
        if (!$existingPage) {
            $allSuccess = false;
            continue;
        }
        $isNewUpload = false;
        if ($files && isset($files['error'][$i]) && $files['error'][$i] === UPLOAD_ERR_OK) {
            $uploadDir = '../../assets/site/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $ext = pathinfo($files['name'][$i], PATHINFO_EXTENSION);
            $newFileName = uniqid('carousel_', true) . '.' . $ext;
            $targetPath = $uploadDir . $newFileName;
            if (move_uploaded_file($files['tmp_name'][$i], $targetPath)) {
                $imagePath = 'assets/site/' . $newFileName;
                $isNewUpload = true;
            } else {
                $allSuccess = false;
                continue;
            }
        } else {
            $imagePath = $existingPage['image_path'];
        }
        if ($title === '') $title = $existingPage['title'];
        $updatedIds[] = $pageId;
        if ($isNewUpload) {
            $newUploads[] = $pageId;
        }
        $adminObj->updateSitePage($pageId, 'carousel', $title, $existingPage['description'], $imagePath, $existingPage['contact_no'], $existingPage['email'], $existingPage['is_active']);
    }
    $allCarousels = $adminObj->fetchSitePages();
    $carouselPages = array_filter($allCarousels, function($p) { return $p['page_type'] === 'carousel'; });
    $activeCarousels = array_filter($carouselPages, function($p) { return $p['is_active']; });
    foreach ($carouselPages as $carousel) {
        if (in_array($carousel['page_id'], $newUploads)) {
            $adminObj->updateSitePage($carousel['page_id'], 'carousel', $carousel['title'], $carousel['description'], $carousel['image_path'], $carousel['contact_no'], $carousel['email'], 1);
        }
    }
    $allCarousels = $adminObj->fetchSitePages();
    $carouselPages = array_filter($allCarousels, function($p) { return $p['page_type'] === 'carousel'; });
    $activeCarousels = array_filter($carouselPages, function($p) { return $p['is_active']; });
    if (count($activeCarousels) > 4) {
        usort($activeCarousels, function($a, $b) { return strtotime($a['updated_at']) - strtotime($b['updated_at']); });
        $toDeactivate = array_slice($activeCarousels, 0, count($activeCarousels) - 4);
        foreach ($toDeactivate as $carousel) {
            $adminObj->updateSitePage($carousel['page_id'], 'carousel', $carousel['title'], $carousel['description'], $carousel['image_path'], $carousel['contact_no'], $carousel['email'], 0);
        }
    }
    echo json_encode(['success' => $allSuccess, 'message' => $allSuccess ? 'Carousel images updated.' : 'Some images failed to update.']);
    exit;

} else {
    echo "invalid_action";
}