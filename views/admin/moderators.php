<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php'; 

$adminObj = new Admin();
$result = $adminObj->fetchModerators();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderators</title>
    <!-- <script src="../../testing/testing.js"></script> -->
    <script src="../../js/admin.js"></script>
    <script src="../../js/modals.js"></script>
    <!-- <?php include '../../includes/head.php'; ?>  -->
</head>
<body>

<div>
    <h2 class="mb-4">Moderators</h2>

    <button class="btn btn-success  mb-3" onclick="openModeratorModal('addModeratorModal', null, 'add')"><i class="bi bi-plus-lg"></i></button>

    <table id="table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Position</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result): 
                $counter = 1; ?>
                <?php foreach ($result as $row): ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><?= clean_input(strtoupper($row['full_name'])) ?></td>
                        <td><?= clean_input($row['username']) ?></td>
                        <td><?= clean_input($row['email']) ?></td>
                        <td><?= clean_input($row['position_name'] ?? 'N/A') ?></td>
                        <td><?= clean_input($row['created_at']) ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="openModeratorModal('editModeratorModal', <?= $row['user_id'] ?>, 'edit')"><i class="bi bi-pencil"></i></button>
                            <button class="btn btn-danger btn-sm" onclick="openModeratorModal('deleteModeratorModal', <?= $row['user_id'] ?>, 'delete')"><i class="bi bi-trash"></i></button>
                        </td> 
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="7" class="text-center">No moderators found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php 
include '../adminModals/addEditModerator.php'; 
include '../adminModals/deleteModerator.html';
?>

</body>
</html>
