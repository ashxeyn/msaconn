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
    <title>Daily Prayer Schedule Management</title>
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

        .prayer-card {
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

        .text-muted {
            color: #6c757d;
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
                text-align: center;
                border-radius: 0;
            }
        }

        /* Hide required icons for date, adhan and iqamah fields in daily prayer form */
        #editDate.is-invalid,
        #editTime.is-invalid,
        #editIqamah.is-invalid,
        #editPrayerDate.is-invalid,
        #editPrayerTime.is-invalid,
        #editPrayerIqamah.is-invalid {
            background-image: none !important;
            padding-right: 0.75rem !important;
        }
        
        /* Hide specific validation icons */
        #editDateIcon,
        #editTimeIcon,
        #editIqamahIcon,
        #editPrayerDateIcon,
        #editPrayerTimeIcon,
        #editPrayerIqamahIcon,
        .invalid-icon[id*="Date"],
        .invalid-icon[id*="Time"],
        .invalid-icon[id*="Iqamah"] {
            display: none !important;
        }
    </style>
</head>

<body>
<div class="admin-container">
    <div class="tabs-container">
        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a class="nav-link" id="calendar-tab" data-toggle="tab" href="#" role="tab" onclick="loadCalendarSection()">Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="prayers-tab" data-toggle="tab" href="#" role="tab" onclick="loadPrayerSchedSection()">Khutba Prayer</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" id="daily-prayers-tab" data-toggle="tab" href="#" role="tab">Daily Prayer</a>
            </li>
        </ul>
    </div>

    <div class="admin-page-header">
        <h3><strong>Daily Prayer Schedule</strong></h3>
        <button class="admin-btn admin-btn-add" onclick="openDailyPrayerModal('editDailyPrayerModal', null, 'add')">
            <i class="bi bi-plus-lg"></i>
        </button>
    </div>

    <div class="prayer-card">
        <table id="table" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Adhan</th>
                    <th>Iqamah</th>
                    <th>Day</th>
                    <th>Salah</th>
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
                            <td>
                                <?php echo !empty($prayer['time']) ? date('h:i A', strtotime($prayer['time'])) : '<span class="text-danger">No time set</span>'; ?>
                            </td>
                            <td>
                                <?php echo !empty($prayer['iqamah']) ? date('h:i A', strtotime($prayer['iqamah'])) : '<span class="text-danger">No time set</span>'; ?>
                            </td>
                            <td><?= date('l', strtotime($prayer['date'])) ?></td>
                            <td>
                                <?= $prayerTypeDisplay ?>
                                <?php if ($isFriday && $prayer['prayer_type'] === 'jumu\'ah'): ?>
                                    <br><small class="text-muted">(Friday Prayer)</small>
                                <?php endif; ?>
                            </td>
                            <td><?= clean_input($prayer['location']) ?></td>
                            <td><?= clean_input($prayer['username'] ?? 'N/A') ?></td>
                            <td>
                                <button class="admin-btn admin-btn-edit btn-sm" onclick="openDailyPrayerModal('editDailyPrayerModal', <?= $prayer['prayer_id'] ?>, 'edit')">
                                    <i class="bi bi-pencil"></i>
                                </button>
                                <button class="admin-btn admin-btn-delete btn-sm" onclick="openDailyPrayerModal('archiveDailyPrayerModal', <?= $prayer['prayer_id'] ?>, 'delete')">
                                    <i class="bi bi-trash"></i>
                                </button>
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

<?php 
include '../adminModals/addEditDailyPrayer.php';
include '../adminModals/deleteDailyPrayer.html';
include '../adminModals/restoreDailyPrayer.html';
?>
</body>
</html>