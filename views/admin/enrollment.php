<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php'; 

$adminObj = new Admin();
$result = $adminObj->fetchPendingEnrollments();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approve Madrasa Enrollments</title>
    <link rel="stylesheet" href="../../css/adminenrollment.css?v=<?php echo time(); ?>">
    <script src="../../js/admin.js"></script>
    <script src="../../js/modals.js"></script>
    <!-- <?php include '../../includes/head.php'; ?>  -->
</head>
<body>
    <div>
        <h2 class="mb-4">Pending Madrasa Enrollments</h2>

        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Full Name</th>
                    <th>Classification</th>
                    <th>Details</th>
                    <th>Contacts</th>
                    <th>COR</th>
                    <th>Status</th>
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
                            <td><?= clean_input($row['classification']) ?></td>
                            <td>
                                <?php if ($row['classification'] == 'On-site'): ?>
                                    <strong>Address:</strong> <?= clean_input($row['address'] ?? 'N/A') ?><br>
                                    <strong>Program:</strong> <?= clean_input($row['program_name'] ?? 'N/A') ?><br>
                                    <strong>College:</strong> <?= clean_input($row['college_name'] ?? 'N/A') ?><br>
                                    <strong>Year Level:</strong> <?= clean_input($row['year_level'] ?? 'N/A') ?>
                                <?php else: ?>
                                    <strong>Address:</strong> <?= clean_input($row['address'] ?? 'N/A') ?><br>
                                    <strong>Program:</strong> <?= clean_input($row['ol_program'] ?? 'N/A') ?><br>
                                    <strong>College:</strong> <?= clean_input($row['ol_college'] ?? 'N/A') ?><br>
                                    <?php if (!empty($row['school'])): ?>
                                        <strong>School:</strong> <?= clean_input($row['school']) ?>
                                    <?php endif; ?>
                                <?php endif; ?>
                            </td>
                            <td>
                                <strong>Contact No.:</strong> <?= clean_input($row['contact_number'] ?? 'N/A') ?><br>
                                <strong>Email:</strong> <?= clean_input($row['email'] ?? 'N/A') ?><br>
                            <td>
                                <?php if (!empty($row['cor_path'])): ?>
                                    <a href="#" data-bs-toggle="modal" data-bs-target="#photoModal" onclick="viewPhoto('<?= clean_input($row['cor_path']) ?>', 'cors')">
                                        <img src="../../assets/cors/<?= clean_input($row['cor_path']) ?>" alt="COR Photo" width="80" height="80" class="img-thumbnail">
                                    </a>
                                <?php else: ?>
                                    No photo
                                <?php endif; ?>
                            </td>
                            <td><?= ucfirst(clean_input($row['status'])) ?></td>
                            <td>
                                <button class="btn btn-success btn-sm" onclick="openEnrollmentModal('enrollModal', <?= $row['enrollment_id'] ?>, 'enroll')">Enroll</button>
                                <button class="btn btn-danger btn-sm" onclick="openEnrollmentModal('rejectEnrollmentModal', <?= $row['enrollment_id'] ?>, 'reject')">Reject</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td class="text-center" colspan="7">No pending Madrasa enrollments</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <?php include '../adminModals/corView.html';
    include '../adminModals/enroll.html';
    include '../adminModals/rejectEnrollment.html';
    ?>
</body>
</html>