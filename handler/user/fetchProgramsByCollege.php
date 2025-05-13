<?php
require_once '../../tools/function.php';
require_once '../../classes/userClass.php';

// Set headers for JSON and CORS
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Headers: Content-Type');

// Check if college_id parameter exists
if (!isset($_GET['college_id']) || empty($_GET['college_id'])) {
    echo json_encode([
        'success' => false,
        'message' => 'College ID is required',
        'data' => []
    ]);
    exit;
}

// Clean and validate the input
$college_id = clean_input($_GET['college_id']);

try {
    // Initialize user class
    $userObj = new User();
    
    // Fetch programs by college ID
    $programs = $userObj->fetchProgramsByCollege($college_id);
    
    // Return success response with programs data
    echo json_encode([
        'success' => true,
        'message' => 'Programs fetched successfully',
        'data' => $programs
    ]);
} catch (Exception $e) {
    // Return error response
    echo json_encode([
        'success' => false,
        'message' => 'Error fetching programs: ' . $e->getMessage(),
        'data' => []
    ]);
} 
?> 