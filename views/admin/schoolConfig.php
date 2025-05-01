<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$colleges = $adminObj->fetchColleges();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Colleges</title>
    <link rel="stylesheet" href="../../css/adminregistration.css?v=<?php echo time(); ?>">
    <script src="../../js/admin.js"></script>
    <script src="../../js/modals.js"></script>
    <!-- <?php include '../../includes/head.php'; ?>  -->
</head>
<body>
<div>
    <h2 class="mb-4">Colleges</h2>

    <button class="btn btn-success mb-3" onclick="openCollegeModal('addEditCollegeModal', null, 'add')">Add College</button>

    <table id="table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>College</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($colleges):
                $counter = 1; ?>
                <?php foreach ($colleges as $college): ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><?= clean_input($college['college_name']) ?></td>
                        <td>
                        <button class="btn btn-primary btn-sm" onclick="openCollegeModal('addEditCollegeModal', <?= $college['college_id'] ?>, 'edit')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="openCollegeModal('deleteCollegeModal', <?= $college['college_id'] ?>, 'delete')">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="3" class="text-center">No colleges found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="bottom-right">
        <button class="btn btn-success" onclick="loadProgramSection()">
            Go to <i class="bi bi-arrow-right"></i>
        </button>    
    </div>
</div>

<?php include '../adminModals/addEditCollege.php'; 
include '../adminModals/deleteCollege.html'; ?>

</body>
</html>
