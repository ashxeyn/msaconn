<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$faqId = $_GET['faq_id'] ?? null;

if ($faqId) {
    $faq = $adminObj->getFaqById($faqId);
    echo json_encode($faq);
} else {
    echo json_encode([]);
}
?>