<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$schoolYearId = $_GET['school_year_id'] ?? null;

if ($schoolYearId) {
    $schoolYear = $adminObj->getSchoolYearById($schoolYearId);
    echo json_encode($schoolYear);
} else {
    echo json_encode([]);
}
?>