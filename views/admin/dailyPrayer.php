<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$dailyPrayers = $adminObj->fetchDailyPrayers();
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
    <script src="../../js/modals.js"></script>

</head>

<div class="container">
    <h2 class="mb-4">Daily Prayer Schedule</h2>
    
    <div class="tabs-container mb-4">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link" id="calendar-tab" data-toggle="tab" href="#calendar-content" role="tab" onclick="loadCalendarSection()">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="prayers-tab" data-toggle="tab" href="#prayers-content" role="tab" onclick="loadPrayerSchedSection()">Khutba Prayer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" id="prayers-tab" data-toggle="tab" href="#" role="tab">Daily Prayer</a>
                </li>
            </ul>
        </div>

    <button class="btn btn-success mb-3" onclick="openDailyPrayerModal('editDailyPrayerModal', null, 'add')">
        Add Prayer Schedule
    </button>

    <div class="tab-content">
    <div class="tab-pane fade show active" id="prayer-content" role="tabpanel">
    <table id="table" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Date</th>
                <th>Day</th>
                <th>Prayer Type</th>
                <th>Speaker</th>
                <th>Topic</th>
                <th>Location</th>
                <th>Created By</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        <?php if ($dailyPrayers): ?>
            <?php 
            $today = date('Y-m-d');
            foreach ($dailyPrayers as $prayer): 
                $isPast = ($prayer['date'] < $today);
                $isToday = ($prayer['date'] == $today);
                
                $prayerTypeDisplay = ucfirst($prayer['prayer_type']);
                
                $isFriday = (date('l', strtotime($prayer['date'])) === 'Friday');
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
                    <td><?= date('l', strtotime($prayer['date'])) ?></td>
                    <td>
                        <?= $prayerTypeDisplay ?>
                        <?php if ($isFriday && $prayer['prayer_type'] === 'jumu\'ah'): ?>
                            <br><small class="text-muted">(Friday Prayer)</small>
                        <?php endif; ?>
                    </td>
                    <td><?= clean_input($prayer['speaker']) ?></td>
                    <td><?= clean_input($prayer['topic']) ?></td>
                    <td><?= clean_input($prayer['location']) ?></td>
                    <td><?= clean_input($prayer['username'] ?? 'N/A') ?></td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="openDailyPrayerModal('editDailyPrayerModal', <?= $prayer['prayer_id'] ?>, 'edit')">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="openDailyPrayerModal('archiveDailyPrayerModal', <?= $prayer['prayer_id'] ?>, 'delete')">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="8" class="text-center">No prayer schedules found.</td>
            </tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>
</div>
</div>  

<?php 
include '../adminModals/addEditDailyPrayer.php';
include '../adminModals/deleteDailyPrayer.html';
include '../adminModals/restoreDailyPrayer.html';
?>