<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php'; 

$adminObj = new Admin();
$result = $adminObj->fetchOfficers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Executive Officers</title>
    <!-- <link rel="stylesheet" href="../../css/adminofficers.css?v=<?php echo time(); ?>"> -->
    <script src="../../js/admin.js"></script>
    <script src="../../js/modals.js"></script>
    <!-- <?php include '../../includes/head.php'; ?>  -->

    <style>
        .officer-photo {
            width: 80px;
            height: 80px;
            border-radius: 8px;
            object-fit: cover;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>
    <div>
        <h2 class="mb-4">Executive Officers</h2>
        <button class="btn btn-success mb-3" onclick="openOfficerModal('addEditOfficerModal', null, 'add')">Add Officer</button>

        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Program</th>
                    <th>Position</th>
                    <th>School Year</th>
                    <th>Image</th>
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
                            <td><?= clean_input($row['program_name'] ?? 'N/A') ?></td>
                            <td><?= clean_input($row['position_name']) ?></td>
                            <td><?= clean_input($row['school_year']) ?></td>
                            <td>
                                <?php if (!empty($row['image'])): ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#photoModal" onclick="viewPhoto('<?= clean_input($row['image']) ?>', 'officers')">
                                        <img src="../../assets/officers/<?= clean_input($row['image']) ?>" alt="Officer Photo" class="officer-photo">
                                    </a>
                                <?php else: ?>
                                    No photo
                                <?php endif; ?>
                            </td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="openOfficerModal('addEditOfficerModal', <?= $row['officer_id'] ?>, 'edit')">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="openOfficerModal('deleteOfficerModal', <?= $row['officer_id'] ?>, 'delete')">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td class="text-center" colspan="7">No executive officers found</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include '../adminModals/deleteOfficer.html'; 
          include '../adminModals/addEditOfficer.php'; ?>

</body>
</html>
