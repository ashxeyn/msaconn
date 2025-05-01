<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$schoolYears = $adminObj->fetchSchoolYears();
$archivedSchoolYears = $adminObj->fetchArchivedSchoolYears();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage School Years</title>
    <link rel="stylesheet" href="../../css/adminRegistration.css?v=<?php echo time(); ?>">
    <script src="../../js/admin.js"></script>
    <!-- <script src="../../js/modals.js"></script> -->
    <script src="../../js/sideBar.js"></script>
    <!-- <?php include '../../includes/head.php'; ?>  -->
</head>
<body>

<div>
    <h2 class="mb-4">School Year Management</h2>

    <button class="btn btn-success mb-3" onclick="openSchoolYearModal('editSchoolYearModal', null, 'add')">Add School Year</button>

    <div class="tab-content" id="myTabContent">
        <div class="tab-pane fade show active" id="active" role="tabpanel" aria-labelledby="active-tab">
            <table id="table" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>School Year</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody id="schoolYearTableBody">
                    <?php if ($schoolYears): ?>
                        <?php $counter = 1; ?>
                        <?php foreach ($schoolYears as $schoolYear): ?>
                            <tr>
                                <td><?= $counter++ ?></td>
                                <td><?= clean_input($schoolYear['school_year']) ?></td>
                                <td>
                                    <button class="btn btn-success btn-sm" onclick="openSchoolYearModal('editSchoolYearModal', <?= $schoolYear['school_year_id'] ?>, 'edit')">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="openSchoolYearModal('archiveSchoolYearModal', <?= $schoolYear['school_year_id'] ?>, 'delete')">Archive</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="3" class="text-center">No school years found</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

    </div>
</div>

<?php include '../adminModals/addEditSchoolYear.php'; ?>
<?php include '../adminModals/deleteSchoolYear.html'; ?>

</body>
</html>