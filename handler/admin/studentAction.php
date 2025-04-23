<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$action = $_POST['action'] ?? '';
$enrollmentId = $_POST['enrollmentId'] ?? null;

if ($action === 'edit') {
    $firstName = clean_input($_POST['firstName']);
    $middleName = clean_input($_POST['middleName']);
    $lastName = clean_input($_POST['lastName']);
    $classification = clean_input($_POST['classification']);
    $existingImage = $_POST['existing_image'] ?? null;
    
    $collegeId = null;
    $programId = null;
    $yearLevel = null;
    $address = null;
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
        $address = clean_input($_POST['address']);
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
        $address,
        $collegeId,
        $programId,
        $yearLevel,
        $school,
        $image,
        $collegeText,
        $programText
    );

    echo $result ? "success" : "error";
} elseif ($action === 'delete') {
    $result = $adminObj->deleteStudent($enrollmentId);
    echo $result ? "success" : "error";
} elseif ($action === 'add') {
    $firstName = clean_input($_POST['firstName']);
    $middleName = clean_input($_POST['middleName']);
    $lastName = clean_input($_POST['lastName']);
    $classification = clean_input($_POST['classification']);
    
    $collegeId = null;
    $programId = null;
    $yearLevel = null;
    $address = null;
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
        $address = clean_input($_POST['address']);
        $school = clean_input($_POST['school'] ?? '');
        $collegeText = clean_input($_POST['collegeText'] ?? '');
        $programText = clean_input($_POST['programText'] ?? '');
    }

    $result = $adminObj->addStudent(
        $firstName,
        $middleName,
        $lastName,
        $classification,
        $address,
        $collegeId,
        $programId,
        $yearLevel,
        $school,
        $image,
        $collegeText,
        $programText
    );

    echo $result ? "success" : "error";
} else {
    echo "invalid_action";
}
?>