<?php
// Include required files
require_once '../../classes/userClass.php';
require_once '../../tools/function.php';

/**
 * Get article data by ID
 * 
 * @param int $articleId The ID of the article to fetch
 * @return array Response containing success status, message, and article data
 */
function getArticleById($articleId) {
    // Define response array
    $response = [
        'success' => false,
        'message' => '',
        'article' => null
    ];
    
    // Validate article ID
    if (empty($articleId) || !is_numeric($articleId)) {
        $response['message'] = 'Invalid article ID';
        return $response;
    }
    
    // Initialize User object
    $userObj = new User();
    
    // Fetch article data
    $article = $userObj->fetchOrgUpdateById($articleId);
    
    // If article found
    if ($article) {
        $response['success'] = true;
        $response['article'] = $article;
        
        // Clean the article content for display
        if (isset($article['content'])) {
            $response['article']['content'] = clean_article_content($article['content']);
        }
        
        // Format the title
        if (isset($article['title'])) {
            $response['article']['title'] = clean_input($article['title']);
        }
    } else {
        $response['message'] = 'Article not found';
    }
    
    return $response;
}

// If this file is accessed directly via API request
if (basename(__FILE__) == basename($_SERVER['SCRIPT_FILENAME'])) {
    // Set headers for JSON response
    header('Content-Type: application/json');
    
    // Check if article ID is provided
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        echo json_encode([
            'success' => false,
            'message' => 'Article ID is required',
            'article' => null
        ]);
        exit;
    }
    
    // Get article ID
    $articleId = intval($_GET['id']);
    
    // Get article data
    $result = getArticleById($articleId);
    
    // Return JSON response
    echo json_encode($result);
    exit;
}
?> 