<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

if (!isset($_SESSION['user_id'])) {
    echo "unauthorized";
    exit;
}

$profileObj = new Admin();
$userId = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';

if ($action === 'get_profile') {
    $profileData = $profileObj->getUserProfile($userId);
    
    if ($profileData) {
        echo json_encode($profileData);
    } else {
        echo json_encode(['error' => 'Failed to retrieve profile data']);
    }
    
} elseif ($action === 'update_profile') {
    $firstName = clean_input($_POST['first_name'] ?? '');
    $lastName = clean_input($_POST['last_name'] ?? '');
    $middleName = clean_input($_POST['middle_name'] ?? '');
    $email = clean_input($_POST['email'] ?? '');
    
    if (empty($firstName) || empty($lastName) || empty($email)) {
        echo "error_missing_data";
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "error_invalid_email";
        exit;
    }
    
    $result = $profileObj->updateProfile($userId, $firstName, $middleName, $lastName, $email);
    echo $result;
    
} elseif ($action === 'update_username') {
    $username = clean_input($_POST['username'] ?? '');
    
    if (empty($username) || strlen($username) < 3) {
        echo "error_invalid_username";
        exit;
    }
    
    $result = $profileObj->updateUsername($userId, $username);
    echo $result;
    
} elseif ($action === 'change_password') {
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
        echo "error_missing_data";
        exit;
    }
    
    if ($newPassword !== $confirmPassword) {
        echo "error_password_mismatch";
        exit;
    }
    
    if (strlen($newPassword) < 8 || !preg_match('/[A-Za-z]/', $newPassword) || !preg_match('/[0-9]/', $newPassword)) {
        echo "error_weak_password";
        exit;
    }
    
    $result = $profileObj->changePassword($userId, $currentPassword, $newPassword);
    echo $result;
    
} elseif ($action === 'delete_account') {
    $confirmPassword = $_POST['confirm_password'] ?? '';
    
    if (empty($confirmPassword)) {
        echo "error_missing_data";
        exit;
    }
    
    $result = $profileObj->deleteAccount($userId, $confirmPassword);
    
    if ($result === "success") {
        session_destroy();
    }
    
    echo $result;
    
} else {
    echo "invalid_action";
}
?>