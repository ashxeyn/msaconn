<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();

if (!isset($_SESSION['user_id'])) {
    echo "error: unauthorized";
    exit;
}

// Handle GET requests for fetching data
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $action = $_GET['action'] ?? '';
    
    if ($action === 'fetch') {
        $schoolYears = $adminObj->fetchSchoolYears();
        if ($schoolYears) {
            $counter = 1;
            foreach ($schoolYears as $schoolYear) {
                echo "<tr>
                        <td>{$counter}</td>
                        <td>" . clean_input($schoolYear['school_year']) . "</td>
                        <td>
                            <button class='btn btn-success btn-sm' onclick='openSchoolYearModal(\"editSchoolYearModal\", {$schoolYear['school_year_id']}, \"edit\")'>Edit</button>
                            <button class='btn btn-danger btn-sm' onclick='openSchoolYearModal(\"archiveSchoolYearModal\", {$schoolYear['school_year_id']}, \"delete\")'>Archive</button>
                        </td>
                      </tr>";
                $counter++;
            }
        } else {
            echo "<tr><td colspan='3' class='text-center'>No school years found</td></tr>";
        }
        exit;
    } elseif ($action === 'fetchArchived') {
        $archivedSchoolYears = $adminObj->fetchArchivedSchoolYears();
        if ($archivedSchoolYears) {
            $counter = 1;
            foreach ($archivedSchoolYears as $schoolYear) {
                $formattedDate = date('M d, Y h:i A', strtotime($schoolYear['deleted_at']));
                echo "<tr>
                        <td>{$counter}</td>
                        <td>" . clean_input($schoolYear['school_year']) . "</td>
                        <td>" . clean_input($schoolYear['reason']) . "</td>
                        <td>{$formattedDate}</td>
                        <td>
                            <button class='btn btn-success btn-sm' onclick='openSchoolYearModal(\"restoreSchoolYearModal\", {$schoolYear['school_year_id']}, \"restore\")'>Restore</button>
                        </td>
                      </tr>";
                $counter++;
            }
        } else {
            echo "<tr><td colspan='5' class='text-center'>No archived school years found</td></tr>";
        }
        exit;
    }
}

// Handle POST requests for CRUD operations
$action = $_POST['action'] ?? '';
$schoolYearId = $_POST['school_year_id'] ?? null;

if ($action === 'edit') {
    $schoolYear = clean_input($_POST['school_year']);
    
    // Validate format
    if (!preg_match('/^\d{4}-\d{4}$/', $schoolYear)) {
        echo "error: invalid_format";
        exit;
    }
    
    $result = $adminObj->updateSchoolYear($schoolYearId, $schoolYear);
    echo $result;

} elseif ($action === 'delete') {
    $reason = clean_input($_POST['reason']);
    if (empty($reason)) {
        echo "error: reason_required";
        exit;
    }

    $result = $adminObj->softDeleteSchoolYear($schoolYearId, $reason);
    echo $result;

} elseif ($action === 'restore') {
    $result = $adminObj->restoreSchoolYear($schoolYearId);
    echo $result;

} elseif ($action === 'add') {
    $schoolYear = clean_input($_POST['school_year']);
    
    // Validate format
    if (!preg_match('/^\d{4}-\d{4}$/', $schoolYear)) {
        echo "error: invalid_format";
        exit;
    }
    
    // Validate that second year is one more than first year
    $years = explode('-', $schoolYear);
    $firstYear = (int)$years[0];
    $secondYear = (int)$years[1];
    
    if ($secondYear !== $firstYear + 1) {
        echo "error: invalid_year_sequence";
        exit;
    }
    
    $result = $adminObj->addSchoolYear($schoolYear);
    echo $result;

} else {
    echo "invalid_action";
}
?>