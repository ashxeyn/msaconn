<?php
header('Content-Type: application/json');

try {
    require_once '../../classes/userClass.php'; // Adjust path as needed
    $user = new User();

    // Get month and year from query parameters
    $month = isset($_GET['month']) ? intval($_GET['month']) : date('m');
    $year = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

    // Fetch activities for the specified month and year
    $activities = $user->fetchCalendarActivities($month, $year);

    echo json_encode([
        'status' => 'success',
        'data' => $activities
    ]);
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}