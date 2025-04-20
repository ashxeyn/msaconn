<?php
header('Content-Type: application/json');
require_once '../../tools/function.php';
require_once '../../classes/adminClass.php';

// Turn off error display in production
ini_set('display_errors', 0);
error_reporting(0);

try {
    if (!isset($_GET['college_id'])) {
        throw new Exception('Missing college_id parameter');
    }
    
    $college_id = intval($_GET['college_id']);
    if ($college_id <= 0) {
        throw new Exception('Invalid college_id');
    }
    
    $adminObj = new Admin();
    $programs = $adminObj->fetchProgramsByCollege($college_id);
    
    echo json_encode([
        'success' => true,
        'data' => $programs ?: []
    ]);
    
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);
}