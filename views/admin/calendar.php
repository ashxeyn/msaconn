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
    <script src="../../js/admin.js"></script>
    <script src="../../js/modals.js"></script>
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

        .events-card {
            position: relative;
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            background: #fff;
            padding: 1.25rem;
            border: 1px solid rgba(15, 138, 83, 0.2);
            overflow-x: auto;
        }
        
        .tabs-container {
            margin-bottom: 1.5rem;
        }
        
        .nav-link:hover {
            color: var(--palestine-green);
            border-color: transparent;
        }
        
        .nav-link.active {
            color: var(--palestine-green);
            background-color: #fff;
            border-color: var(--table-border) var(--table-border) #fff;
            border-bottom: 2px solid var(--palestine-green);
        }

        #table {
            width: 100% !important;
            border-collapse: separate;
            border-spacing: 0;
            font-size: 0.95rem;
        }

        #table th:nth-child(1),
        #table td:nth-child(1) {
            width: 15%;
        }

        #table th:nth-child(2),
        #table td:nth-child(2) {
            width: 12%;
        }

        #table th:nth-child(3),
        #table td:nth-child(3) {
            width: 15%;
        }

        #table th:nth-child(4),
        #table td:nth-child(4) {
            width: 30%;
            max-width: 250px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        #table th:nth-child(5),
        #table td:nth-child(5) {
            width: 13%;
        }

        #table th:nth-child(6),
        #table td:nth-child(6) {
            width: 15%;
            min-width: 100px;
        }

        .action-buttons {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        #table tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid var(--table-border);
            vertical-align: middle;
            white-space: nowrap;
        }

        #table thead th {
            color: var(--palestine-green);
            font-weight: 600;
            padding: 12px 15px;
            border: none;
        }

        #table tbody tr:last-child td {
            border-bottom: none;
        }

        #table tbody tr:hover td {
            background-color: rgba(15, 138, 83, 0.05);
        }

        .badge {
            display: inline-block;
            padding: 0.25em 0.6em;
            font-size: 0.75em;
            font-weight: 500;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.375rem;
        }
        
        .bg-secondary {
            background-color: #6c757d;
        }
        
        .bg-danger {
            background-color: #dc3545;
        }
        
        .bg-primary {
            background-color: var(--palestine-green);
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
            
            .nav-link {
                padding: 0.5rem 0.75rem;
                font-size: 0.9rem;
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
            
            .nav-tabs {
                flex-wrap: wrap;
            }
            
            .nav-item {
                width: 100%;
            }
            
            .nav-link {
                border-radius: 0;
            }
        }

        /* Reset previous styles */
        .events-card .dataTables_filter,
        .events-card .dataTables_paginate,
        .events-card .dataTables_info {
            position: static;
            float: right;
            background: none;
            box-shadow: none;
            z-index: auto;
            display: block;
        }

        /* Move dataTables_info to left side */
        .events-card .dataTables_info {
            float: left;
        }

        /* Just ensure card is scrollable */
        .events-card {
            position: relative;
            overflow-x: auto;
        }

        /* Hide required icons only for start date and time in calendar form */
        #activityDate.is-invalid,
        #activityTime.is-invalid,
        #editActivityDate.is-invalid,
        #editActivityTime.is-invalid,
        #editTime.is-invalid {
            background-image: none !important;
            padding-right: 0.75rem !important;
        }
        
        /* Hide specific time validation icons */
        #editTimeIcon,
        .invalid-icon[id*="Time"] {
            display: none !important;
        }
    </style>
</head>

<body>
<div class="admin-container">
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link active" id="calendar-tab" data-toggle="tab" href="#" role="tab">Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="prayers-tab" data-toggle="tab" href="#" role="tab" onclick="loadPrayerSchedSection()">Khutba Prayer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="daily-prayers-tab" data-toggle="tab" href="#" role="tab" onclick="loadDailyPrayerSection()">Daily Prayer</a>
            </li>
        </ul>
    </div>

    <div class="admin-page-header">
        <h3><strong>Calendar of Events</strong></h3>
        <button class="admin-btn admin-btn-add" onclick="openCalendarModal('addEditCalendarModal', null, 'add')">
            <i class="bi bi-plus-lg"></i>
        </button>
    </div>

    <div class="events-card">
        <table id="table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Day</th>
                    <th>Activity</th>
                    <th>Description</th>
                    <th>Venue</th>
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
                            <td><?= $calEv['time'] ? date('h:i A', strtotime($calEv['time'])) : '' ?></td>
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
                            <td><?= isset($calEv['venue']) ? clean_input($calEv['venue']) : '' ?></td>
                            <td><?= clean_input($calEv['username'] ?? 'N/A') ?></td>
                            <td>
                                <button class="admin-btn admin-btn-edit btn-sm" onclick="openCalendarModal('addEditCalendarModal', <?= $calEv['activity_id'] ?>, 'edit')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="admin-btn admin-btn-delete btn-sm" onclick="openCalendarModal('deleteCalendarModal', <?= $calEv['activity_id'] ?>, 'delete')">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8" class="text-center">No events found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php 
include '../adminModals/addEditCalendar.php';
include '../adminModals/deleteCalendar.html';
?>

<script>
$(document).ready(function() {
    // Initialize DataTable with standard settings
    $('#table').DataTable();
    
    // Get the scrollable container
    const scrollContainer = $('.events-card');
    const filterElement = $('.dataTables_filter');
    const paginateElement = $('.dataTables_paginate');
    const infoElement = $('.dataTables_info');
    const lengthElement = $('.dataTables_length');
    
    // Set initial position
    scrollContainer.on('scroll', function() {
        // Get scroll position
        const scrollLeft = $(this).scrollLeft();
        const containerWidth = $(this).width();
        const tableWidth = $('#table').width();
        
        // Calculate right-aligned position
        const maxScroll = tableWidth - containerWidth;
        
        // Apply the transform to keep elements at the right side
        if (scrollLeft > 0) {
            filterElement.css('transform', `translateX(${scrollLeft}px)`);
            paginateElement.css('transform', `translateX(${scrollLeft}px)`);
            // Keep info and length elements at left when scrolling right
            infoElement.css('transform', `translateX(${scrollLeft}px)`);
            lengthElement.css('transform', `translateX(${scrollLeft}px)`);
        } else {
            filterElement.css('transform', 'translateX(0)');
            paginateElement.css('transform', 'translateX(0)');
            infoElement.css('transform', 'translateX(0)');
            lengthElement.css('transform', 'translateX(0)');
        }
    });
});
</script>
</body>
</html>