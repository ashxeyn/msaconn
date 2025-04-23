<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php'; 

$adminObj = new Admin();
$result = $adminObj->fetchOnsiteEnrolledStudents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Madrasa Students</title>
    <link rel="stylesheet" href="../../css/adminstudents.css?v=<?php echo time(); ?>">
    <script src="../../js/admin.js"></script>
    <?php include '../../includes/head.php'; ?> 

    <style>
        .cor-photo {
            width: 120px;
            height: 80px;
            border-radius: 6px;
            object-fit: cover;
            background-color: #f0f0f0;
        }
    </style>
</head>
<body>

<div>
    <h2 class="mb-4">Madrasa On-Site Students</h2>
    
    <button class="btn btn-primary mb-3" onclick="openStudentModal('addEditStudentModal', null, 'add')">
        <i class="fas fa-plus"></i> Add New Student
    </button>

    <table id="table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Full Name</th>
                <th>Details</th>
                <th>COR</th>
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
                        <td>
                            <?php if ($row['classification'] == 'On-site'): ?>
                                <strong>Program:</strong> <?= clean_input($row['program_name'] ?? 'N/A') ?><br>
                                <strong>College:</strong> <?= clean_input($row['college_name'] ?? 'N/A') ?><br>
                                <strong>Year Level:</strong> <?= clean_input($row['year_level'] ?? 'N/A') ?>
                            <?php else: ?>
                                <strong>Address:</strong> <?= clean_input($row['address'] ?? 'N/A') ?><br>
                                <?php if (!empty($row['school'])): ?>
                                    <strong>School:</strong> <?= clean_input($row['school']) ?><br>
                                <?php endif; ?>
                                <?php if (!empty($row['program_name'])): ?>
                                    <strong>Program:</strong> <?= clean_input($row['program_name']) ?><br>
                                <?php endif; ?>
                                <?php if (!empty($row['college_name'])): ?>
                                    <strong>College:</strong> <?= clean_input($row['college_name']) ?>
                                <?php endif; ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if (!empty($row['cor_path'])): ?>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#photoModal" onclick="viewPhoto('<?= clean_input($row['cor_path']) ?>', 'enrollment')">
                                    <img src="../../assets/enrollment/<?= clean_input($row['cor_path']) ?>" alt="COR Photo" class="cor-photo">
                                </a>
                            <?php else: ?>
                                <span class="text-muted">No photo</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <button class="btn btn-primary btn-sm" onclick="openStudentModal('addEditStudentModal', <?= $row['enrollment_id'] ?>, 'edit')">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="openStudentModal('deleteStudentModal', <?= $row['enrollment_id'] ?>, 'delete')">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="text-center">No enrolled students</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <div class="bottom-right">
        <button class="btn btn-success" onclick="loadOnlineSection()">
            Go to <i class="bi bi-arrow-right"></i>
        </button>    
    </div>
</div>

<?php include '../adminModals/corView.html'; 
include '../adminModals/addEditStudent.php';
include '../adminModals/deleteStudent.html';
?>

</body>
</html>