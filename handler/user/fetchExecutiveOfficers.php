<?php
require_once '../../classes/userClass.php';

header('Content-Type: application/json');

try {
    $userObj = new User();
    $officers = $userObj->fetchExecutiveOfficers();

    // Debugging: Check if data is fetched
    if (empty($officers)) {
        throw new Exception('No executive officers found in the database.');
    }

    // Ensure the picture URL is properly formatted
    foreach ($officers as &$officer) {
        $officer['picture'] = $officer['picture'] 
            ? '../../assets/officers/' . $officer['picture'] 
            : '../../assets/images/default-profile.png'; // Default image if no picture is available
    }

    echo json_encode([
        'status' => 'success',
        'data' => $officers
    ]);
} catch (Exception $e) {
    // Debugging: Log the error message
    error_log('Error fetching executive officers: ' . $e->getMessage());

    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}