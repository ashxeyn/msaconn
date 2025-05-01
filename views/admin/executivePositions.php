<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$positions = $adminObj->fetchOfficerPositions();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Executive Positions</title>
    <link rel="stylesheet" href="../../css/adminRegistration.css?v=<?php echo time(); ?>">
    <script src="../../js/admin.js"></script>
    <script src="../../js/modals.js"></script>
    <script src="../../js/sideBar.js"></script>
    <!-- <?php include '../../includes/head.php'; ?>  -->
</head>
<body>

<div>
    <h2 class="mb-4">Executive Positions Management</h2>

    <button class="btn btn-success mb-3" onclick="openPositionModal('editExePositionModal', null, 'add')">Add Position</button>

    <table id="table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Position Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($positions): ?>
                <?php $counter = 1; ?>
                <?php foreach ($positions as $position): ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><?= clean_input($position['position_name']) ?></td>
                        <td>
                            <button class="btn btn-success btn-sm" onclick="openPositionModal('editExePositionModal', <?= $position['position_id'] ?>, 'edit')">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="openPositionModal('archiveExePositionModal', <?= $position['position_id'] ?>, 'delete')">Archive</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No executive positions found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php include '../adminModals/addEditExePosition.php'; ?>
<?php include '../adminModals/deleteExePosition.html'; ?>

</body>
</html>