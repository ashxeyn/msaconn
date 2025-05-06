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
    <script src="../../js/admin.js"></script>
    <script src="../../js/modals.js"></script>
    <!-- <?php include '../../includes/head.php'; ?>  -->
    <style>
        :root {
            --palestine-green: #0F8A53;
            --palestine-black:rgb(0, 0, 0);
            --palestine-light: #f8f9fa;
            --palestine-hover: #0a6b3f;
            --table-border: #e0e0e0;
        }

        .admin-container {
            max-width: 1200px;
            padding-top: 3rem;
        }

        .admin-page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--palestine-green);
            padding: 0.5rem 0;
        }

        .admin-btn {
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            transition: all 0.2s ease;
            border-width: 1.5px;
            border-style: solid;
            box-shadow: none;
        }

        .admin-btn-edit {
            background-color: #000000;
            border-color: #000000;
            color: #fff;
        }

        .admin-btn-edit:hover {
            background-color: #fff;
            color: #333;
            border-color: #333;
        }

        .admin-btn-edit:hover i {
            color: #333;
        }

        .admin-btn-delete {
            background-color: #fff;
            border-color: #dc3545;
            color: #dc3545;
        }

        .admin-btn-delete:hover {
            background-color: #dc3545;
            color: #fff;
        }

        .admin-btn-add {
            background-color: var(--palestine-green);
            border-color: var(--palestine-green);
            color: #fff;
        }

        .admin-btn-add:hover {
            background-color: var(--palestine-hover);
            transform: translateY(-1px);
        }

        .admin-btn-success {
            background-color: var(--palestine-green);
            border-color: var(--palestine-green);
            color: #fff;
        }

        .admin-btn-success:hover {
            background-color: var(--palestine-hover);
            color: #fff;
        }

        .admin-btn-danger {
            background-color: #fff;
            border-color: #dc3545;
            color: #dc3545;
        }

        .admin-btn-danger:hover {
            background-color: #dc3545;
            color: #fff;
        }

        .enrollment-card {
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            background: #fff;
            padding: 1.25rem;
            border: 1px solid rgba(15, 138, 83, 0.2);
            overflow-x: auto;
        }

        #table th:nth-child(1),
        #table td:nth-child(1) {
            width: 5%;
        }

        #table th:nth-child(2),
        #table td:nth-child(2) {
            width: 15%;
        }

        #table th:nth-child(3),
        #table td:nth-child(3) {
            width: 10%;
        }

        #table th:nth-child(4),
        #table td:nth-child(4) {
            width: 25%;
        }

        #table th:nth-child(5),
        #table td:nth-child(5) {
            width: 15%;
            white-space: nowrap;
        }

        #table th:nth-child(6),
        #table td:nth-child(6) {
            width: 10%;
        }

        #table th:nth-child(7),
        #table td:nth-child(7) {
            width: 8%;
        }

        #table th:nth-child(8),
        #table td:nth-child(8) {
            width: 12%;
            min-width: 100px;
        }

        #table {
            width: 100% !important;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.95rem;
        }

        #table thead th {
            color: var(--palestine-green);
            font-weight: 600;
            padding: 12px 15px;
            border: none;
        }

        #table tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--table-border);
            vertical-align: middle;
        }

        #table tbody tr:last-child td {
            border-bottom: none;
        }

        #table tbody tr:hover td {
            background-color: rgba(15, 138, 83, 0.05);
        }

        .img-thumbnail {
            border: 1px solid var(--palestine-green);
            border-radius: 6px;
            transition: all 0.2s ease;
        }

        .img-thumbnail:hover {
            transform: scale(1.05);
            box-shadow: 0 2px 8px rgba(15, 138, 83, 0.25);
        }

        .dataTables_filter input {
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem !important;
            border: 1.5px solid var(--palestine-black) !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            margin-left: 0.5rem !important;
        }

        .dataTables_filter input:focus {
            outline: none !important;
            border-color: var(--palestine-green) !important;
            box-shadow: 0 0 0 2px rgba(15, 138, 83, 0.25) !important;
        }

        .dataTables_filter label {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .dataTables_length select {
            padding: 0.4rem 0.75rem !important;
            font-size: 0.875rem !important;
            border: 1.5px solid var(--palestine-black) !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            margin: 0 0.5rem !important;
            height: auto !important;
        }

        .dataTables_length select:focus {
            outline: none !important;
            border-color: var(--palestine-green) !important;
            box-shadow: 0 0 0 2px rgba(15, 138, 83, 0.25) !important;
        }

        .dataTables_length label {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            margin-bottom: 1rem !important;
        }

        .dataTables_paginate {
            margin-top: 1rem !important;
            font-size: 0.875rem !important;
        }

        .dataTables_paginate .paginate_button {
            padding: 0.25rem 0.5rem !important;
            margin: 0 0.15rem !important;
            border: 1px solid transparent !important;
            border-radius: 4px !important;
            transition: all 0.2s ease !important;
        }

        .dataTables_paginate .paginate_button.current,
        .dataTables_paginate .paginate_button.current:hover {
            background: var(--palestine-green) !important;
            color: white !important;
            border-color: var(--palestine-green) !important;
        }

        .dataTables_paginate .paginate_button:hover {
            background: var(--palestine-hover) !important;
            color: white !important;
            border-color: var(--palestine-hover) !important;
        }

        .dataTables_paginate .paginate_button.disabled,
        .dataTables_paginate .paginate_button.disabled:hover {
            background: transparent !important;
            color: #6c757d !important;
        }

        .dataTables_info {
            font-size: 0.875rem !important;
            color: #6c757d !important;
            padding-top: 1rem !important;
        }

        @media (max-width: 768px) {
            .admin-container {
                padding-top: 1.5rem;
            }
            
            #table {
                font-size: 0.85rem;
            }
            
            #table thead th,
            #table tbody td {
                padding: 8px 10px;
            }
            
            .dataTables_length label,
            .dataTables_filter label {
                font-size: 0.8rem;
            }
            
            .dataTables_length select,
            .dataTables_filter input {
                padding: 0.35rem 0.5rem !important;
                font-size: 0.8rem !important;
            }
            
            .admin-btn {
                padding: 0.3rem 0.6rem;
                font-size: 0.8rem;
            }
        }

        @media (max-width: 576px) {
            .admin-page-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 0.5rem;
            }
            
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter {
                float: none !important;
                width: 100% !important;
                margin-bottom: 0.5rem !important;
            }
            
            .dataTables_length label,
            .dataTables_filter label {
                justify-content: space-between;
                width: 100%;
            }
            
            .dataTables_length select,
            .dataTables_filter input {
                width: 60% !important;
                margin: 0 !important;
            }
        }
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-page-header">
            <h3><strong>Pending Madrasa Enrollments</strong></h3>
        </div>

        <div class="enrollment-card">
            <table id="table" class="display" style="width:100%">
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
                                </td>
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
                                    <button class="admin-btn admin-btn-success btn-sm" onclick="openEnrollmentModal('enrollModal', <?= $row['enrollment_id'] ?>, 'enroll')">
                                        <i class="bi bi-person-check-fill"></i>
                                    </button>
                                    <button class="admin-btn admin-btn-danger btn-sm" onclick="openEnrollmentModal('rejectEnrollmentModal', <?= $row['enrollment_id'] ?>, 'reject')">
                                        <i class="bi bi-person-dash-fill"></i>
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td class="text-center" colspan="8">No pending Madrasa enrollments</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <?php include '../adminModals/corView.html';
    include '../adminModals/enroll.html';
    include '../adminModals/rejectEnrollment.html';
    ?>
</body>
</html>