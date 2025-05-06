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
    <!-- <?php include '../../includes/head.php'; ?> -->
    <script src="../../js/admin.js"></script>
    <script src="../../js/modals.js"></script>

</head>
<body>
    <div class="container">
        <h2 class="mb-4">Calendar of Events</h2>
        
        <div class="tabs-container mb-4">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a class="nav-link active" id="calendar-tab" data-toggle="tab" href="#calendar-content" role="tab">Events</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="prayers-tab" data-toggle="tab" href="#prayers-content" role="tab" onclick="loadPrayerSchedSection()">Khutba Prayer</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="prayers-tab" data-toggle="tab" href="#prayers-content" role="tab" onclick="loadDailyPrayerSection()">Daily Prayer</a>
                </li>
            </ul>
        </div>
        
        <div class="tab-content">
            <div class="tab-pane fade show active" id="calendar-content" role="tabpanel">
                <button class="btn btn-success mb-3" onclick="openCalendarModal('addEditCalendarModal', null, 'add')">
                    <i class="bi bi-plus-lg"></i>
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
                        <?php 
                        $today = date('Y-m-d');
                        foreach ($calEvents as $calEv): 
                            $endDateToCheck = !empty($calEv['end_date']) ? $calEv['end_date'] : $calEv['activity_date'];
                            $isPast = ($endDateToCheck < $today);
                            $isToday = ($calEv['activity_date'] <= $today && $endDateToCheck >= $today);
                            
                            $dateDisplay = formatDate2($calEv['activity_date']);
                            if (!empty($calEv['end_date'])) {
                                $dateDisplay .= ' to ' . formatDate2($calEv['end_date']);
                            }
                        ?>
                            <tr>
                                <td data-order="<?= $calEv['activity_date'] ?>">
                                    <?= $dateDisplay ?>
                                    <?php if ($isPast): ?>
                                        <br><span class="badge bg-secondary">Done</span>
                                    <?php elseif ($isToday): ?>
                                        <br><span class="badge bg-danger">Current</span>
                                    <?php else: ?>
                                        <br><span class="badge bg-primary">Upcoming</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <?php 
                                    $startDay = date('l', strtotime($calEv['activity_date']));
                                    if (!empty($calEv['end_date'])) {
                                        $endDay = date('l', strtotime($calEv['end_date']));
                                        if ($startDay != $endDay) {
                                            echo $startDay . ' - ' . $endDay;
                                        } else {
                                            echo $startDay;
                                        }
                                    } else {
                                        echo $startDay;
                                    }
                                    ?>
                                </td>
                                <td><?= clean_input($calEv['title']) ?></td>
                                <td><?= clean_input($calEv['description']) ?></td>
                                <td><?= clean_input($calEv['username'] ?? 'N/A') ?></td>
                                <td>
                                    <button class="btn btn-primary btn-sm" onclick="openCalendarModal('addEditCalendarModal', <?= $calEv['activity_id'] ?>, 'edit')"><i class="bi bi-pencil"></i></button>
                                    <button class="btn btn-danger btn-sm" onclick="openCalendarModal('deleteCalendarModal', <?= $calEv['activity_id'] ?>, 'delete')"><i class="bi bi-trash"></i></button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="text-center">No events found.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php 
    include '../adminModals/addEditCalendar.php';
    include '../adminModals/deleteCalendar.html';
    ?>