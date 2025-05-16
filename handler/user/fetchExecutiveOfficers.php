<?php
require_once '../../classes/userClass.php';

// Enable output compression
if (extension_loaded('zlib') && !ini_get('zlib.output_compression')) {
    ini_set('zlib.output_compression', 'On');
    ini_set('zlib.output_compression_level', '5');
}

// Set appropriate headers
header('Content-Type: application/json');
header('Cache-Control: public, max-age=60'); // Cache for 1 minute
header('Expires: ' . gmdate('D, d M Y H:i:s', time() + 60) . ' GMT');

// Use output buffering for better performance
ob_start();

try {
    $userObj = new User();
    $officersByBranch = $userObj->fetchExecutiveOfficers();

    // Debugging: Check if data is fetched
    if (empty($officersByBranch['male']) && empty($officersByBranch['wac']) && empty($officersByBranch['ils']) && empty($officersByBranch['adviser'])) {
        throw new Exception('No executive officers found in the database.');
    }

    // Process each branch to add proper image paths
    foreach ($officersByBranch as $branch => $officers) {
        foreach ($officers as &$officer) {
            $officer['picture'] = $officer['picture'] 
                ? '../../assets/officers/' . $officer['picture'] 
                : '../../assets/images/default-profile.png'; // Default image
        }
        $officersByBranch[$branch] = $officers;
    }

    echo json_encode([
        'status' => 'success',
        'data' => $officersByBranch
    ], JSON_UNESCAPED_SLASHES);
} catch (Exception $e) {
    // Debugging: Log the error message
    error_log('Error fetching executive officers: ' . $e->getMessage());

    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

// Flush the output buffer
ob_end_flush();