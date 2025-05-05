<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$prayers = $adminObj->fetchPrayerSchedule();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prayer Schedule Management</title>
    <!-- <link rel="stylesheet" href="../../css/admincalendar.css?v=<?php echo time(); ?>"> -->
    <!-- <?php include '../../includes/head.php'; ?> -->
    <script src="../../js/admin.js"></script>
    <script src="../../js/modals.js"></script>

</head>
<body>
    <div class="container">
        <h2 class="mb-4">Khutba Prayer Schedule</h2>
        
        <div class="tabs-container mb-4">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" id="calendar-tab" data-toggle="tab" href="#" role="tab" onclick="loadCalendarSection()">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="prayers-tab" data-toggle="tab" href="#" role="tab">Khutba Prayer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="daily-prayers-tab" data-toggle="tab" href="#" role="tab" onclick="loadDailyPrayerSection()">Daily Prayer</a>
                </li>
            </ul>
        </div>
        
        <div class="tab-content">
            <div class="tab-pane fade show active" id="prayers-content" role="tabpanel">
                <button class="btn btn-success mb-3" onclick="openPrayerModal('addEditPrayerModal', null, 'add')">
                    Add Khutba Prayer
                </button>

                <table id="table" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Topic</th>
                            <th>Speaker</th>
                            <th>Location</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if ($prayers): ?>
                        <?php 
                        $today = date('Y-m-d');
                        foreach ($prayers as $prayer): 
                            $isPast = ($prayer['date'] < $today);
                            $isToday = ($prayer['date'] == $today);
                        ?>
                            <tr>
                                <td data-order="<?= $prayer['date'] ?>">
                                    <?= formatDate2($prayer['date']) ?>
                                    <?php if ($isPast): ?>
                                        <br><span class="badge bg-secondary">Done</span>
                                    <?php elseif ($isToday): ?>
                                        <br><span class="badge bg-danger">Today</span>
                                    <?php else: ?>
                                        <br><span class="badge bg-primary">Upcoming</span>
                                    <?php endif; ?>
                                </td>
                                <td><?= clean_input($prayer['topic']) ?></td>
                                <td><?= clean_input($prayer['speaker']) ?></td>
                                <td><?= clean_input($prayer['location']) ?></td>
                                <td><?= clean_input($prayer['username'] ?? 'N/A') ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="openPrayerModal('addEditPrayerModal', <?= $prayer['prayer_id'] ?>, 'edit')">Edit</button>
                                    <button class="btn btn-danger btn-sm" onclick="openPrayerModal('deletePrayerModal', <?= $prayer['prayer_id'] ?>, 'delete')">Delete</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center">No prayer schedules found.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php 
    include '../adminModals/addEditPrayer.php';
    include '../adminModals/deletePrayer.html';
    include '../adminModals/restorePrayer.html';
    ?>