<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$calEvents = $adminObj->fetchCalendarEvents();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar Management</title>
    <link rel="stylesheet" href="../../css/admincalendar.css?v=<?php echo time(); ?>">
    <!-- <?php include '../../includes/head.php'; ?> -->
    <script src="../../js/admin.js"></script>
</head>
<body>
    <div class="container">
        <h2 class="mb-4">Calendar Management</h2>
        <button class="btn btn-success mb-3" onclick="openCalendarModal('addEditCalendarModal', null, 'add')">
            Add Event
        </button>

        <table id="table" class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Day</th>
                    <th>Activity</th>
                    <th>Description</th>
                    <th>Created By</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($calEvents): ?>
                    <?php foreach ($calEvents as $calEv): ?>
                        <tr>
                            <td><?= formatDate2($calEv['activity_date']) ?></td>
                            <td><?= date('l', strtotime($calEv['activity_date'])) ?></td>
                            <td><?= clean_input($calEv['title']) ?></td>
                            <td><?= clean_input($calEv['description']) ?></td>
                            <td><?= clean_input($calEv['username'] ?? 'N/A') ?></td>
                            <td>
                                <button class="btn btn-primary btn-sm" onclick="openCalendarModal('addEditCalendarModal', <?= $calEv['activity_id'] ?>, 'edit')">Edit</button>
                                <button class="btn btn-danger btn-sm" onclick="openCalendarModal('deleteCalendarModal', <?= $calEv['activity_id'] ?>, 'delete')">Delete</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="text-center">No events found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <div class="bottom-right">
            <button class="btn btn-success" onclick="loadPrayerSchedSection()">
                Go to <i class="bi bi-arrow-right"></i>
            </button>    
        </div>
    </div>

    <?php 
    include '../adminModals/addEditCalendar.php';
    include '../adminModals/deleteCalendar.html';
    ?>
</body>
</html>
