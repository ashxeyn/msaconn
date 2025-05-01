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
$enrollmentId = $_POST['enrollmentId'] ?? null;

if ($action === 'edit') {
    $firstName = clean_input($_POST['firstName']);
    $middleName = clean_input($_POST['middleName']);
    $lastName = clean_input($_POST['lastName']);
    $classification = clean_input($_POST['classification']);
    $contactNumber = clean_input($_POST['contactNumber']);
    $email = clean_input($_POST['email']);
    $existingImage = $_POST['existing_image'] ?? null;
    
    $region = clean_input($_POST['region']);
    $province = clean_input($_POST['province']);
    $city = clean_input($_POST['city']);
    $barangay = clean_input($_POST['barangay']);
    $street = clean_input($_POST['street']);
    $zipCode = clean_input($_POST['zipCode']);
    
    if (!$adminObj->validateEmail($email, $classification)) {
        if ($classification === 'On-site') {
            echo "error: invalid_email_format";
        } else {
            echo "error: invalid_email";
        }
        exit;
    }
    
    $collegeId = null;
    $programId = null;
    $yearLevel = null;
    $school = null;
    $collegeText = null;
    $programText = null;
    $image = $existingImage;

    if ($classification === 'On-site') {
        $collegeId = clean_input($_POST['college']);
        $programId = clean_input($_POST['program']);
        $yearLevel = clean_input($_POST['yearLevel']);
        
        if (!empty($_FILES['image']['name'])) {
            $targetDir = "../../assets/enrollment/";
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $image = $fileName;
            }
        }
    } else {
        $school = clean_input($_POST['school'] ?? '');
        $collegeText = clean_input($_POST['collegeText'] ?? '');
        $programText = clean_input($_POST['programText'] ?? '');
    }

    $result = $adminObj->updateStudent(
        $enrollmentId,
        $firstName,
        $middleName,
        $lastName,
        $classification,
        $region,
        $province,
        $city,
        $barangay,
        $street,
        $zipCode,
        $collegeId,
        $programId,
        $yearLevel,
        $school,
        $image,
        $email,
        $contactNumber,
        $collegeText,
        $programText
    );

    echo $result ? "success" : "error";

} elseif ($action === 'add') {
    $firstName = clean_input($_POST['firstName']);
    $middleName = clean_input($_POST['middleName']);
    $lastName = clean_input($_POST['lastName']);
    $classification = clean_input($_POST['classification']);
    $contactNumber = clean_input($_POST['contactNumber']);
    $email = clean_input($_POST['email']);
    
    $region = clean_input($_POST['region']);
    $province = clean_input($_POST['province']);
    $city = clean_input($_POST['city']);
    $barangay = clean_input($_POST['barangay']);
    $street = clean_input($_POST['street']);
    $zipCode = clean_input($_POST['zipCode']);
    
    if (!$adminObj->validateEmail($email, $classification)) {
        if ($classification === 'On-site') {
            echo "error: invalid_email_format";
        } else {
            echo "error: invalid_email";
        }
        exit;
    }
    
    $collegeId = null;
    $programId = null;
    $yearLevel = null;
    $school = null;
    $collegeText = null;
    $programText = null;
    $image = null;

    if ($classification === 'On-site') {
        $collegeId = clean_input($_POST['college']);
        $programId = clean_input($_POST['program']);
        $yearLevel = clean_input($_POST['yearLevel']);
        
        if (!empty($_FILES['image']['name'])) {
            $targetDir = "../../assets/enrollment/";
            $fileName = time() . '_' . basename($_FILES['image']['name']);
            $targetFile = $targetDir . $fileName;
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFile)) {
                $image = $fileName;
            }
        }
    } else {
        $school = clean_input($_POST['school'] ?? '');
        $collegeText = clean_input($_POST['collegeText'] ?? '');
        $programText = clean_input($_POST['programText'] ?? '');
    }

    $result = $adminObj->addStudent(
        $firstName,
        $middleName,
        $lastName,
        $classification,
        $region,
        $province,
        $city,
        $barangay,
        $street,
        $zipCode,
        $collegeId,
        $programId,
        $yearLevel,
        $school,
        $image,
        $email,
        $contactNumber,
        $collegeText,
        $programText
    );

    echo $result ? "success" : "error";

} elseif ($action === 'delete') {
    $enrollmentId = clean_input($_POST['enrollmentId']);
    $reason = clean_input($_POST['reason']);
    
    if (empty($reason)) {
        echo "error: reason_required";
        exit;
    }
    
    $result = $adminObj->softDeleteStudent($enrollmentId, $reason);
    echo $result ? "success" : "error";

} elseif ($action === 'restore') {
    $enrollmentId = clean_input($_POST['enrollmentId']);
    $result = $adminObj->restoreStudent($enrollmentId);
    echo $result ? "success" : "error";

} else {
    echo "invalid_action";
}
?>