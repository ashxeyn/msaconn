<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();

if (!isset($_SESSION['user_id'])) {
    echo "error: unauthorized";
    exit;
}

$userId = $_SESSION['user_id'];
$action = $_POST['action'] ?? '';
$faqId = $_POST['faq_id'] ?? null;

if ($action === 'edit') {
    $question = clean_input($_POST['question']);
    $answer = clean_input($_POST['answer']);
    $category = clean_input($_POST['category']);

    $existingFaq = $adminObj->getFaqById($faqId);
    if (!$existingFaq) {
        echo "error: faq_not_found";
        exit;
    }

    $result = $adminObj->updateFaq($faqId, $question, $answer, $category);
    echo $result ? "success" : "error";

} elseif ($action === 'delete') {
    $reason = clean_input($_POST['reason']);
    if (empty($reason)) {
        echo "error: reason_required";
        exit;
    }

    $result = $adminObj->softDeleteFaq($faqId, $reason);
    echo $result ? "success" : "error";

} elseif ($action === 'restore') {
    $result = $adminObj->restoreFaq($faqId);
    echo $result ? "success" : "error";

} elseif ($action === 'add') {
    $question = clean_input($_POST['question']);
    $answer = clean_input($_POST['answer']);
    $category = clean_input($_POST['category']);

    $result = $adminObj->addFaq($question, $answer, $category, $userId);
    echo $result ? "success" : "error";

} else {
    echo "invalid_action";
}
?>