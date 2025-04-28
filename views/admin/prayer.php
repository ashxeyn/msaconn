<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$prayers = $adminObj->fetchFridayPrayers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Prayer Schedule Management</title>
    <link rel="stylesheet" href="../../css/admincalendar.css?v=<?php echo time(); ?>">
    <!-- <?php include '../../includes/head.php'; ?> -->
    <script src="../../js/admin.js"></script>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Prayer Schedule Management</h2>
        <button class="btn btn-success mb-3" onclick="openPrayerModal('addEditPrayerModal', null, 'add')">Add Schedule</button>
        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Speaker</th>
                    <th>Topic</th>
                    <th>Location</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($prayers): ?>
                    <?php foreach ($prayers as $p): ?>
                        <tr>
                            <td><?= formatDate2($p['khutbah_date']) ?></td>
                            <td><?= clean_input($p['speaker']) ?></td>
                            <td><?= clean_input($p['topic']) ?></td>
                            <td><?= clean_input($p['location']) ?></td>
                            <td><?= clean_input($p['username'] ?? 'N/A') ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="openPrayerModal('addEditPrayerModal', <?= $p['prayer_id'] ?>, 'edit')">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="openPrayerModal('deletePrayerModal', <?= $p['prayer_id'] ?>, 'delete')">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="6" class="text-center">No schedules found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
        <div class="bottom-nav">
        <button class="btn btn-secondary" onclick="loadCalendarSection()">
            <i class="bi bi-arrow-left"></i> Back
        </button>
    </div>
    </div>

    <?php 
        include '../adminModals/addEditPrayer.php';
        include '../adminModals/deletePrayer.html';
    ?>
</body>
</html>
