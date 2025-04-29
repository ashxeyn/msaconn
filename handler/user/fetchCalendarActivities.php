<?php
header('Content-Type: application/json');
try {
    // Include necessary files and make sure the class methods work
    require_once '../../classes/userClass.php'; // Make sure the path is correct
    $user = new User();
    $activities = $user->fetchCalendarActivities(); // This should return the data

    echo json_encode(['status' => 'success', 'data' => $activities]);
} catch (Exception $e) {
    // Log error and send error message in JSON format
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
