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
?>