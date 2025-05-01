<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$programs = $adminObj->fetchAllPrograms();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programs</title>
    <link rel="stylesheet" href="../../css/adminregistration.css?v=<?php echo time(); ?>">
    <script src="../../js/admin.js"></script>
    <script src="../../js/modals.js"></script>
    <!-- <?php include '../../includes/head.php'; ?>  -->
</head>
<body>
<div>
    <h2 class="mb-4">Programs</h2>

    <button class="btn btn-success mb-3" onclick="openProgramModal('addEditProgramModal', null, 'add')">Add Programs</button>

    <table id="table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>College</th>
                <th>Program</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($programs):
                $counter = 1; ?>
                <?php foreach ($programs as $program): ?>
                    <tr>
                        <td><?= $counter++ ?></td>
                        <td><?= clean_input($program['college_name']) ?></td>
                        <td><?= clean_input($program['program_name']) ?></td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="openProgramModal('addEditProgramModal', <?= $program['program_id'] ?>, 'edit')">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="openProgramModal('deleteProgramModal', <?= $program['program_id'] ?>, 'delete')">Delete</button>
                        </td>

                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="4" class="text-center">No programs found</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <div class="bottom-nav">
        <button class="btn btn-secondary" onclick="loadSchoolConfigSection()">
            <i class="bi bi-arrow-left"></i> Back
        </button>
    </div>
</div>

<?php include '../adminModals/addEditProgram.php'; 
include '../adminModals/deleteProgram.html'; ?>
</body>
</html>