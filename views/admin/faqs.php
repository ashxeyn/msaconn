<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php'; 

$adminObj = new Admin();
$faqs = $adminObj->fetchFaqs(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FAQs Management</title>
    <script src="../../js/admin.js"></script> 
    <!-- <?php include '../../includes/head.php'; ?> -->
</head>
<body>

<div class="container mt-4">    
    <h2 class="mb-4">FAQs Management</h2>

    <button class="btn btn-success mb-3" onclick="openFaqModal('addEditFaqModal', null, 'add')">Add FAQ</button>
    
    <div class="table-responsive">
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Question</th>
                    <th>Answer</th>
                    <th>Category</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($faqs): 
                    $counter = 1; ?>
                    <?php foreach ($faqs as $faq): ?>
                        <tr data-id="<?= $faq['faq_id'] ?>">
                            <td><?= $counter++ ?></td>
                            <td><?= clean_input($faq['question']) ?></td>
                            <td><?= clean_input($faq['answer']) ?></td>
                            <td><?= clean_input($faq['category']) ?></td>
                            <td>
                                <button class="btn btn-success btn-sm editBtn" onclick="openFaqModal('addEditFaqModal', <?= $faq['faq_id'] ?>, 'edit')">Edit</button>
                                <button class="btn btn-danger btn-sm deleteBtn" onclick="openFaqModal('deleteFaqModal', <?= $faq['faq_id'] ?>, 'delete')">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No FAQs found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php include '../adminModals/addEditFaqs.php'; 
include '../adminModals/deleteFaq.html'; ?>

</body>
</html>
