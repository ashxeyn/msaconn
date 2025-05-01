<?php
function formatFileSize($bytes) {
    if ($bytes >= 1073741824) {
        return number_format($bytes / 1073741824, 2) . ' GB';
    } elseif ($bytes >= 1048576) {
        return number_format($bytes / 1048576, 2) . ' MB';
    } elseif ($bytes >= 1024) {
        return number_format($bytes / 1024, 2) . ' KB';
    } elseif ($bytes > 1) {
        return $bytes . ' bytes';
    } else {
        return '1 byte';
    }
}

function formatDate($dateString) {
    if (empty($dateString)) {
        return '';
    }
    try {
        $date = new DateTime($dateString);
        return $date->format('F j, Y'); // Format example: "January 12, 2023"
    } catch (Exception $e) {
        error_log("Date formatting error: " . $e->getMessage());
        return $dateString; // Return original string if formatting fails
    }
}

function getFileIcon($fileType) {
    $icons = [
        'application/pdf' => '📄',
        'application/msword' => '📝',
        'application/vnd.openxmlformats-officedocument.wordprocessingml.document' => '📝',
        'application/zip' => '🗂️',
        'application/vnd.ms-excel' => '📊',
        'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' => '📊',
        'application/vnd.ms-powerpoint' => '📑',
        'application/vnd.openxmlformats-officedocument.presentationml.presentation' => '📑'
    ];
    
    return $icons[$fileType] ?? '📁';
}

// Add this function if you're using it for file uploads
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}