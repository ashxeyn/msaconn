<?php
function clean_input($input)
{
    $input = trim($input);

    $input = stripslashes($input);

    $input = htmlspecialchars($input);

    $input = strip_tags($input);
    
    return $input;
}

function formatFileSize($size) {
    if ($size >= pow(1024, 3)) {
        return sprintf("%.2f GB", $size / pow(1024, 3));
    } elseif ($size >= pow(1024, 2)) {
        return sprintf("%.2f MB", $size / pow(1024, 2));
    } elseif ($size >= pow(1024, 1)) {
        return sprintf("%.2f KB", $size / pow(1024, 1));
    } else {
        return sprintf("%d bytes", $size);
    }
}

function formatDate($date) {
    return date("F j, Y, g:i a", strtotime($date));
}

function formatDate2($date) {
    return date("F j, Y", strtotime($date));
}

function clean_article_content($input) {
    $input = trim($input);
    
    // First decode any existing HTML entities
    $input = html_entity_decode($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    
    // Apply line breaks
    $input = nl2br($input);
    
    // Define allowed tags
    $allowed_tags = '<p><br><strong><em><u><h1><h2><h3><h4><h5><h6><ul><ol><li><blockquote>';
    $input = strip_tags($input, $allowed_tags);
    
    // Don't run htmlspecialchars since we want to preserve HTML tags
    // $input = htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    
    return $input;
}

// function is_valid_email($email) {
//     return filter_var($email, FILTER_VALIDATE_EMAIL);
// }

// function is_strong_password($password) {
//     return (strlen($password) >= 8 && 
//             preg_match('/[A-Za-z]/', $password) && 
//             preg_match('/[0-9]/', $password));
// }

// function show_alert($message, $type = 'success') {
//     return '<div class="alert alert-'.$type.' alert-dismissible fade show" role="alert">
//                 '.$message.'
//                 <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
//             </div>';
// }
