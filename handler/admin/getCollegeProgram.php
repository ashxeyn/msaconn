<?php
require_once '../../classes/adminClass.php';

$adminObj = new Admin();

$collegeId = $_GET['college_id'] ?? null;

if ($collegeId) {
    $programs = $adminObj->fetchProgramsByCollege($collegeId);
    echo json_encode($programs);
} else {
    echo json_encode([]);
}
?>