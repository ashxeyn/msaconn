<?php 
require_once '../../classes/adminClass.php';  
$adminObj = new Admin();  

$enrollmentId = $_GET['enrollment_id'] ?? null;  

if ($enrollmentId) {     
    $student = $adminObj->getEnrollmentById($enrollmentId);     
    echo json_encode($student); 
} else {     
    echo json_encode(['error' => 'Invalid request']); 
}
?>