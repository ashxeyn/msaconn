<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$archivedColleges = $adminObj->fetchArchivedColleges();
$archivedPrograms = $adminObj->fetchArchivedPrograms();
$archivedCalendar = $adminObj->fetchArchivedCalendar();
$archivedPrayers = $adminObj->fetchArchivedPrayers();
$archivedDailyPrayers = $adminObj->fetchArchivedDailyPrayers();
$archivedCashIn = $adminObj->fetchArchivedTransactions('Cash In');
$archivedCashOut = $adminObj->fetchArchivedTransactions('Cash Out');
$archivedFAQs = $adminObj->fetchArchivedFAQs();
$archivedAboutMsa = $adminObj->fetchArchivedAbouts();
$archivedFiles = $adminObj->fetchArchivedFiles();
$archivedOnsite = $adminObj->fetchArchivedStudents('On-site');
$archivedOnline = $adminObj->fetchArchivedStudents('Online');
$archivedOfficers = $adminObj->fetchArchivedOfficers();
$archivedVolunteers = $adminObj->fetchArchivedVolunteers();
$archivedModerators = $adminObj->fetchArchivedModerators();
$archivedUpdates = $adminObj->fetchArchivedOrgUpdates();
$archivedPositions = $adminObj->fetchArchivedPositions();
$archivedSchoolYears = $adminObj->fetchArchivedSchoolYears();


?>

<head>
    <script src="../../js/modals.js"></script>
    <script src="../../js/admin.js"></script>
    <link rel="stylesheet" href="../../css/archives.css">
    <style>
        /* Force transparent background and green text for all table headers */
        th {
            background-color: transparent !important;
            background: none !important;
            color: #0F8A53 !important;
            border: none !important;
            text-transform: none !important; /* Ensure text is not uppercase */
            font-weight: bold !important;
        }
        
        /* Fix for specific tables */
        #calendarTab th, #prayerTab th, #cashinTab th, #cashoutTab th, 
        #collegesTab th, #programsTab th, #faqsTab th, #aboutTab th, 
        #filesTab th, #onsiteTab th, #olTab th, #officersTab th, 
        #volunteersTab th, #moderatorsTab th, #updatesTab th, 
        #positionsTab th, #schoolYearsTab th {
            background-color: transparent !important;
            background: none !important;
            color: #0F8A53 !important;
            text-transform: none !important; /* Ensure text is not uppercase */
            border: none !important;
            font-weight: bold !important;
        }
        
        /* Override Bootstrap or other framework styles */
        .table thead th {
            background-color: transparent !important;
            background: none !important;
            color: #0F8A53 !important;
            text-transform: none !important; /* Ensure text is not uppercase */
            border: none !important;
            font-weight: bold !important;
        }
        
        /* Additional override to ensure no uppercase in any table header */
        table th, 
        thead th, 
        .table th,
        .table thead th,
        .dataTables_wrapper th {
            text-transform: none !important;
            border: none !important;
            font-weight: bold !important;
        }
        
        /* Make containers bigger and more rounded */
        .card {
            border: none !important;
            border-radius: 0 !important;
            box-shadow: none !important;
            background-color: transparent !important;
        }
        
        .card-body {
            padding: 0 !important;
            overflow: hidden;
        }
        
        .table-responsive {
            border-radius: 14px;
            padding: 15px;
            background-color: #fff;
            margin-bottom: 20px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            overflow-x: auto;
            width: 100%;
        }
        
        .tab-content {
            padding: 0 !important;
            background-color: transparent !important;
            border: none !important;
            box-shadow: none !important;
        }
        
        .dataTables_wrapper {
            padding: 10px;
            width: 100%;
            overflow-x: auto;
        }
        
        /* Make tab navigation horizontally scrollable without showing scrollbar */
        .nav-tabs {
            border-bottom: 1px solid #dee2e6 !important;
            margin-bottom: 20px !important;
            padding-bottom: 0 !important;
            overflow-x: auto !important;
            flex-wrap: nowrap !important;
            white-space: nowrap !important;
            scrollbar-width: none !important; /* Firefox */
            -ms-overflow-style: none !important; /* IE and Edge */
        }
        
        /* Hide scrollbar for Chrome, Safari and Opera */
        .nav-tabs::-webkit-scrollbar {
            display: none !important;
        }
        
        .nav-tabs .nav-link {
            border: none !important;
            color: #6c757d !important;
            padding: 10px 16px !important;
            margin-right: 4px !important;
            border-radius: 0 !important;
            display: inline-block !important;
        }
        
        .nav-tabs .nav-link.active {
            color: #0F8A53 !important;
            font-weight: 600 !important;
            background-color: transparent !important;
            border-bottom: 2px solid #0F8A53 !important;
        }
        
        .nav-tabs .nav-link:hover:not(.active) {
            color: #495057 !important;
            border-bottom: 2px solid #dee2e6 !important;
        }
        
        /* Apply the same scrollable behavior to subtabs */
        #transparencySubTabs, #studentSubTabs, #schoolConfigSubTabs {
            overflow-x: auto !important;
            flex-wrap: nowrap !important;
            white-space: nowrap !important;
            scrollbar-width: none !important; /* Firefox */
            -ms-overflow-style: none !important; /* IE and Edge */
        }
        
        #transparencySubTabs::-webkit-scrollbar, 
        #studentSubTabs::-webkit-scrollbar, 
        #schoolConfigSubTabs::-webkit-scrollbar {
            display: none !important;
        }
        
        /* Fix for volunteers table specifically */
        #volunteers .table-responsive,
        #volunteersTab_wrapper {
            overflow-x: auto !important;
            max-width: 100% !important;
            width: 100% !important;
        }
        
        /* Make all tables full-width within their containers */
        .tab-pane {
            padding: 0 !important;
        }
        
        /* Ensure tables don't overflow their containers */
        table {
            width: 100% !important;
            table-layout: auto;
        }
        
        /* Add horizontal scrolling if needed */
        @media (max-width: 1200px) {
            .table-responsive {
                overflow-x: auto !important;
            }
        }
        
        /* Style action buttons to be square with black background */
        .btn-sm.btn-success {
            border-radius: 6px !important;
            background-color: #000 !important;
            border-color: #000 !important;
            width: 36px !important;
            height: 36px !important;
            padding: 0 !important;
            display: flex !important;
            justify-content: center !important;
            align-items: center !important;
        }
        
        .btn-sm.btn-success:hover {
            background-color: #333 !important;
            border-color: #333 !important;
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }
        
        .btn-sm.btn-success i {
            font-size: 18px !important;
            color: white !important;
        }
        
        /* Style pagination (previous/next) buttons */
        .dataTables_paginate {
            margin-top: 15px !important;
            display: flex !important;
            justify-content: flex-end !important;
        }
        
        .dataTables_paginate .paginate_button,
        .paginate_button,
        .previous,
        .next {
            padding: 6px 12px !important;
            margin: 0 3px !important;
            border-radius: 5px !important;
            cursor: pointer !important;
            border: 1px solid #dee2e6 !important;
            color: #000 !important;
            background-color: #fff !important;
            transition: all 0.2s !important;
        }
        
        .dataTables_paginate .paginate_button:hover,
        .paginate_button:hover,
        .previous:hover,
        .next:hover {
            background-color: #f8f9fa !important;
            color: #0F8A53 !important;
            border-color: #0F8A53 !important;
        }
        
        .dataTables_paginate .paginate_button.current,
        .paginate_button.current {
            background-color: #0F8A53 !important;
            color: white !important;
            border-color: #0F8A53 !important;
        }
        
        .dataTables_paginate .paginate_button.disabled,
        .paginate_button.disabled,
        .previous.disabled,
        .next.disabled {
            color: #6c757d !important;
            pointer-events: none !important;
            background-color: #fff !important;
            border-color: #dee2e6 !important;
        }
        
        /* New styles for transparent buttons with green icons */
        .btn-sm.btn-success {
            background-color: transparent !important;
            border: 1px solid #0F8A53 !important;
            box-shadow: none !important;
            border-radius: 4px !important;
        }
        
        .btn-sm.btn-success:hover {
            background-color: #0F8A53 !important;
            transform: translateY(-2px);
            box-shadow: none !important;
        }
        
        .btn-sm.btn-success i {
            color: #0F8A53 !important;
            font-size: 20px !important;
        }
        
        .btn-sm.btn-success:hover i {
            color: white !important;
        }
        
        /* Add new table styling to match the FAQs page layout */
        .table {
            border-collapse: separate !important;
            border-spacing: 0 !important;
            width: 100% !important;
            border: none !important;
        }
        
        .table th {
            background-color: transparent !important;
            color: #0F8A53 !important;
            border: none !important;
            padding: 12px 8px !important;
            font-weight: bold !important;
            text-transform: none !important;
        }
        
        .table td {
            border: none !important;
            border-bottom: 1px solid #dee2e6 !important;
            padding: 12px 8px !important;
            vertical-align: middle !important;
        }
        
        /* Update hover effect to green tint from FAQs page */
        .table tbody tr:hover td {
            background-color: rgba(255, 255, 255, 0.37) !important;
        }
        
        /* Style pagination to match FAQs page */
        .dataTables_paginate {
            margin-top: 15px !important;
            display: flex !important;
            justify-content: flex-end !important;
        }
        
        .paginate_button, .previous, .next {
            padding: 6px 12px !important;
            margin: 0 3px !important;
            cursor: pointer !important;
            border: none !important;
            color: #000 !important;
            background-color: transparent !important;
            transition: all 0.2s !important;
        }
        
        .paginate_button.current {
            background-color: #0F8A53 !important;
            color: white !important;
            border-radius: 4px !important;
        }
        
        /* Fix search and show entries styling */
        .dataTables_wrapper .dataTables_length,
        .dataTables_wrapper .dataTables_filter {
            margin-bottom: 20px !important;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            border: 1px solid #ced4da !important;
            border-radius: 4px !important;
            padding: 6px 12px !important;
        }
        
        .dataTables_wrapper .dataTables_length select,
        .table-responsive .dataTables_length select,
        #calendarTab_length select,
        #prayerTab_length select,
        #cashinTab_length select,
        #cashoutTab_length select,
        #faqsTab_length select,
        #aboutTab_length select,
        #filesTab_length select,
        #osTab_length select,
        #olTab_length select,
        #officersTab_length select,
        #volunteersTab_length select,
        #moderatorsTab_length select,
        #archivedUpdatesTab_length select {
            padding: 0.3rem 0.5rem !important;
            font-size: 0.875rem !important;
            border: 1.5px solid #000000 !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            margin: 0 0.5rem !important;
            height: 30px !important;
            width: 60px !important;
            min-width: 60px !important;
            max-width: 60px !important;
            color: #000000 !important;
            background-color: white !important;
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
        
        /* Media queries for responsive design */
        @media (max-width: 768px) {
            .dataTables_length label,
            .dataTables_filter label {
                font-size: 0.8rem;
            }
            
            .dataTables_length select,
            .dataTables_filter input {
                padding: 0.35rem 0.5rem !important;
                font-size: 0.8rem !important;
            }
        }
        
        @media (max-width: 576px) {
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

        /* DataTables styling for "Show entries" and "Search" elements - copied from schoolConfig.php */
        .dataTables_filter input,
        .table-responsive .dataTables_filter input,
        #calendarTab_filter input,
        #prayerTab_filter input,
        #cashinTab_filter input,
        #cashoutTab_filter input,
        #faqsTab_filter input,
        #aboutTab_filter input,
        #filesTab_filter input,
        #osTab_filter input,
        #olTab_filter input,
        #officersTab_filter input,
        #volunteersTab_filter input,
        #moderatorsTab_filter input,
        #archivedUpdatesTab_filter input,
        #schoolYearsTab_filter input,
        #collegesTab_filter input,
        #programsTab_filter input,
        #officerPositionsTab_filter input,
        #dailyPrayerTab_filter input {
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem !important;
            border: 1.5px solid #000000 !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            margin-left: 0.5rem !important;
            height: 38px !important;
            min-width: 200px !important;
            color: #000000 !important;
            background-color: white !important;
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

        .dataTables_wrapper .dataTables_length select,
        .table-responsive .dataTables_length select,
        #calendarTab_length select,
        #prayerTab_length select,
        #cashinTab_length select,
        #cashoutTab_length select,
        #faqsTab_length select,
        #aboutTab_length select,
        #filesTab_length select,
        #osTab_length select,
        #olTab_length select,
        #officersTab_length select,
        #volunteersTab_length select,
        #moderatorsTab_length select,
        #archivedUpdatesTab_length select,
        #schoolYearsTab_length select,
        #collegesTab_length select,
        #programsTab_length select,
        #officerPositionsTab_length select,
        #dailyPrayerTab_length select {
            padding: 0.3rem 0.5rem !important;
            font-size: 0.875rem !important;
            border: 1.5px solid #000000 !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            margin: 0 0.5rem !important;
            height: 30px !important;
            width: 60px !important;
            min-width: 60px !important;
            max-width: 60px !important;
            color: #000000 !important;
            background-color: white !important;
        }
    </style>
</head>

<div class="container-fluid py-4">
    <h1 class="archive-title">Archives</h1>
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body px-0 pb-2">

                    <ul class="nav nav-tabs" id="archivesTabs" role="tablist">

                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar" 
                                    type="button" role="tab" aria-controls="calendar" aria-selected="false">
                                Calendar Activities
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="prayer-tab" data-bs-toggle="tab" data-bs-target="#prayer" 
                                    type="button" role="tab" aria-controls="prayer" aria-selected="false">
                                Prayer
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="daily-prayer-tab" data-bs-toggle="tab" data-bs-target="#daily-prayer" 
                                    type="button" role="tab" aria-controls="daily-prayer" aria-selected="false">
                                Daily Prayer
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="transparency-tab" data-bs-toggle="tab" data-bs-target="#transparency" 
                                    type="button" role="tab" aria-controls="transparency" aria-selected="false">
                                Transparency
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="faqs-tab" data-bs-toggle="tab" data-bs-target="#faqs" 
                                    type="button" role="tab" aria-controls="faqs" aria-selected="false">
                                FAQs
                            </button>    
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="about-msa-archives-tab" data-bs-toggle="tab" data-bs-target="#about-msa-archives" 
                                    type="button" role="tab" aria-controls="about-msa-archives" aria-selected="false">
                                About MSA
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="files-tab" data-bs-toggle="tab" data-bs-target="#files" 
                                    type="button" role="tab" aria-controls="files" aria-selected="false">
                                Files
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="archived-students-tab" data-bs-toggle="tab" data-bs-target="#archived-students" 
                                    type="button" role="tab" aria-controls="archived-students" aria-selected="false">
                                Students
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="officers-tab" data-bs-toggle="tab" data-bs-target="#officers"
                                    type="button" role="tab" aria-controls="officers" aria-selected="false">
                                Officers
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="volunteers-tab" data-bs-toggle="tab" data-bs-target="#volunteers"
                                    type="button" role="tab" aria-controls="volunteers" aria-selected="false">
                                Volunteers
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="moderators-tab" data-bs-toggle="tab" data-bs-target="#moderators"
                                    type="button" role="tab" aria-controls="moderators" aria-selected="false">
                                Moderators
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="archived-updates-tab" data-bs-toggle="tab" data-bs-target="#archived-updates"
                                    type="button" role="tab" aria-controls="archived-updates" aria-selected="false">
                                Updates
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="schoolConfig-tab" data-bs-toggle="tab" data-bs-target="#schoolConfig"
                                    type="button" role="tab" aria-controls="schoolConfig" aria-selected="false">
                                School Configurations
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content pt-3" id="archivesTabsContent">

                        <div class="tab-pane fade show active" id="calendar" role="tabpanel" aria-labelledby="calendar-tab">
                            <div class="table-responsive">
                                <table id="calendarTab" class="table table-striped align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Description</th>
                                            <th>Date</th>
                                            <th>Reason</th>
                                            <th>Archived At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($archivedCalendar)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No archived calendar activities</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($archivedCalendar as $activity): ?>
                                                <tr>
                                                    <td><?= clean_input($activity['title']) ?></td>
                                                    <td><?= clean_input($activity['description']) ?></td>
                                                    <td><?= $activity['activity_date'] ? date('M d, Y', strtotime($activity['activity_date'])) : 'N/A' ?></td>
                                                    <td><?= clean_input($activity['reason']) ?></td>
                                                    <td><?= $activity['deleted_at'] ? date('M d, Y h:i A', strtotime($activity['deleted_at'])) : 'N/A' ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-success" onclick="setCalendarId(<?= $activity['activity_id'] ?>, 'restore')">
                                                            <i class="bi bi-arrow-counterclockwise"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="prayer" role="tabpanel" aria-labelledby="prayer-tab">                            
                            <div class="table-responsive">
                                <table id="prayerTab" class="table table-striped align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Speaker</th>
                                            <th>Topic</th>
                                            <th>Location</th>
                                            <th>Reason</th>
                                            <th>Archived At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($archivedPrayers)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center">No archived prayer schedules found</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($archivedPrayers as $prayer): ?>
                                                <tr>
                                                    <td>
                                                        <?php if (isset($prayer['khutbah_date']) && $prayer['khutbah_date']): ?>
                                                            <?= date('M d, Y', strtotime($prayer['khutbah_date'])) ?>
                                                        <?php else: ?>
                                                            N/A
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= clean_input($prayer['speaker'] ?? 'N/A') ?></td>
                                                    <td><?= clean_input($prayer['topic'] ?? 'N/A') ?></td>
                                                    <td><?= clean_input($prayer['location'] ?? 'N/A') ?></td>
                                                    <td><?= clean_input($prayer['reason'] ?? 'N/A') ?></td>
                                                    <td>
                                                        <?php if (isset($prayer['deleted_at']) && $prayer['deleted_at']): ?>
                                                            <?= date('M d, Y h:i A', strtotime($prayer['deleted_at'])) ?>
                                                        <?php else: ?>
                                                            N/A
                                                        <?php endif; ?>
                                                    </td>
                                                    <td>
                                                        <button class="btn btn-sm btn-success" onclick="setPrayerId(<?= $prayer['prayer_id'] ?>, 'restore')">
                                                            <i class="bi bi-arrow-counterclockwise"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="daily-prayer" role="tabpanel" aria-labelledby="daily-prayer-tab">
                            <div class="table-responsive">
                                <table id="dailyPrayerTab" class="table table-striped align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Date</th>
                                            <th>Prayer Type</th>
                                            <th>Time</th>
                                            <th>Iqamah</th>
                                            <th>Location</th>
                                            <th>Reason</th>
                                            <th>Archived At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($archivedDailyPrayers)): ?>
                                            <tr>
                                                <td colspan="8" class="text-center">No archived daily prayers</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($archivedDailyPrayers as $dailyPrayer): ?>
                                                <tr>
                                                    <td><?= date('M d, Y', strtotime($dailyPrayer['date'])) ?></td>
                                                    <td><?= clean_input($dailyPrayer['prayer_type']) ?></td>
                                                    <td><?= $dailyPrayer['time'] ? date('h:i A', strtotime($dailyPrayer['time'])) : 'N/A' ?></td>
                                                    <td><?= $dailyPrayer['iqamah'] ? date('h:i A', strtotime($dailyPrayer['iqamah'])) : 'N/A' ?></td>
                                                    <td><?= clean_input($dailyPrayer['location'] ?? 'N/A') ?></td>
                                                    <td><?= clean_input($dailyPrayer['reason']) ?></td>
                                                    <td><?= $dailyPrayer['deleted_at'] ? date('M d, Y h:i A', strtotime($dailyPrayer['deleted_at'])) : 'N/A' ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-success" 
                                                                onclick="setDailyPrayerId(<?= $dailyPrayer['prayer_id'] ?>, 'restore')">
                                                            <i class="bi bi-arrow-counterclockwise"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="transparency" role="tabpanel" aria-labelledby="transparency-tab">
                            <ul class="nav nav-tabs" id="transparencySubTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="cashin-tab" data-bs-toggle="tab" data-bs-target="#cashin" 
                                            type="button" role="tab" aria-controls="cashin" aria-selected="true">
                                        Cash In
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="cashout-tab" data-bs-toggle="tab" data-bs-target="#cashout" 
                                            type="button" role="tab" aria-controls="cashout" aria-selected="false">
                                        Cash Out
                                    </button>
                                </li>
                            </ul>
                            
                            <div class="tab-content" id="transparencySubTabsContent">
                                <div class="tab-pane fade show active" id="cashin" role="tabpanel" aria-labelledby="cashin-tab">
                                    <div class="table-responsive mt-3">
                                        <table id="cashinTab" class="table table-striped align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Description</th>
                                                    <th>Category</th>
                                                    <th>Amount</th>
                                                    <th>Semester</th>
                                                    <th>Reason</th>
                                                    <th>Archived At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($archivedCashIn)): ?>
                                                    <tr>
                                                        <td colspan="8" class="text-center">No archived Cash In transactions</td>
                                                    </tr>
                                                <?php else: ?>
                                                    <?php foreach ($archivedCashIn as $transaction): ?>
                                                        <tr>
                                                            <td><?= date('M d, Y', strtotime($transaction['report_date'])) ?></td>
                                                            <td><?= clean_input($transaction['expense_detail']) ?></td>
                                                            <td><?= clean_input($transaction['expense_category']) ?></td>
                                                            <td class="text-success">+<?= number_format($transaction['amount'], 2) ?></td>
                                                            <td><?= clean_input($transaction['semester']) ?></td>
                                                            <td><?= clean_input($transaction['reason']) ?></td>
                                                            <td><?= $transaction['deleted_at'] ? date('M d, Y h:i A', strtotime($transaction['deleted_at'])) : 'N/A' ?></td>
                                                            <td>
                                                                <button class="btn btn-sm btn-success" 
                                                                        onclick="openTransactionModal('restoreTransactionModal', <?= $transaction['report_id'] ?>, 'restore', 'Cash In')">
                                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade" id="cashout" role="tabpanel" aria-labelledby="cashout-tab">
                                    <div class="table-responsive mt-3">
                                        <table id="cashoutTab" class="table table-striped align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Date</th>
                                                    <th>Description</th>
                                                    <th>Category</th>
                                                    <th>Amount</th>
                                                    <th>Semester</th>
                                                    <th>Reason</th>
                                                    <th>Archived At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($archivedCashOut)): ?>
                                                    <tr>
                                                        <td colspan="8" class="text-center">No archived Cash Out transactions</td>
                                                    </tr>
                                                <?php else: ?>
                                                    <?php foreach ($archivedCashOut as $transaction): ?>
                                                        <tr>
                                                            <td><?= date('M d, Y', strtotime($transaction['report_date'])) ?></td>
                                                            <td><?= clean_input($transaction['expense_detail']) ?></td>
                                                            <td><?= clean_input($transaction['expense_category']) ?></td>
                                                            <td class="text-danger">-<?= number_format($transaction['amount'], 2) ?></td>
                                                            <td><?= clean_input($transaction['semester']) ?></td>
                                                            <td><?= clean_input($transaction['reason']) ?></td>
                                                            <td><?= $transaction['deleted_at'] ? date('M d, Y h:i A', strtotime($transaction['deleted_at'])) : 'N/A' ?></td>
                                                            <td>
                                                                <button class="btn btn-sm btn-success" 
                                                                        onclick="openTransactionModal('restoreTransactionModal', <?= $transaction['report_id'] ?>, 'restore', 'Cash Out')">
                                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="faqs" role="tabpanel" aria-labelledby="faqs-tab">
                            <div class="table-responsive">
                            <table id="faqsTab" class="table table-striped align-items-center mb-0">
                                <thead>
                                        <tr>
                                            <th>Question</th>
                                            <th>Answer</th>
                                            <th>Category</th>
                                            <th>Reason</th>
                                            <th>Archived At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($archivedFAQs)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center py-4">No archived FAQs found</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($archivedFAQs as $faq): ?>
                                                <tr>
                                                    <td><?= clean_input($faq['question']) ?></td>
                                                    <td><?= clean_input($faq['answer']) ?></td>
                                                    <td><?= clean_input($faq['category']) ?></td>
                                                    <td><?= clean_input($faq['reason']) ?></td>
                                                    <td><?= date('M j, Y', strtotime($faq['deleted_at'])) ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-success" 
                                                                onclick="openFaqModal('restoreFaqModal', <?= $faq['faq_id'] ?>, 'restore')">
                                                            <i class="bi bi-arrow-counterclockwise"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                        <div class="tab-pane fade" id="about-msa-archives" role="tabpanel" aria-labelledby="about-msa-archives-tab">
                            <div class="table-responsive">
                                <table id="aboutTab" class="table table-striped align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Mission</th>
                                            <th>Vision</th>
                                            <th>Reason</th>
                                            <th>Archived At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($archivedAboutMsa)): ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No archived About MSA content found</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($archivedAboutMsa as $about): ?>
                                                <tr>
                                                    <td><?= clean_input($about['mission']) ?></td>
                                                    <td><?= clean_input($about['vision']) ?></td>
                                                    <td><?= clean_input($about['reason']) ?></td>
                                                    <td><?= date('M j, Y', strtotime($about['deleted_at'])) ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-success" onclick="openAboutModal('restoreAboutModal', <?= $about['id'] ?>, 'restore')">
                                                            <i class="bi bi-arrow-counterclockwise"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="files" role="tabpanel" aria-labelledby="file-tab">
                            <div class="table-responsive">
                                <table id="filesTab" class="table table-striped align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>File Name</th>
                                            <th>File Type</th>
                                            <th>File Size</th>
                                            <th>Reason</th>
                                            <th>Archived At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($archivedFiles)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No archived files found</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($archivedFiles as $file): ?>
                                                <tr>
                                                    <td><?= clean_input($file['file_name']) ?></td>
                                                    <td><?= clean_input($file['file_type']) ?></td>
                                                    <td><?= formatFileSize($file['file_size']) ?></td>
                                                    <td><?= clean_input($file['reason']) ?></td>
                                                    <td><?= date('M j, Y', strtotime($file['deleted_at'])) ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-success" onclick="openFileModal('restoreFileModal', <?= $file['file_id'] ?>, 'restore')">
                                                            <i class="bi bi-arrow-counterclockwise"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="archived-students" role="tabpanel" aria-labelledby="archived-students-tab">
                            <ul class="nav nav-tabs" id="studentSubTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="onsite-tab" data-bs-toggle="tab" data-bs-target="#onsite-archived" 
                                            type="button" role="tab" aria-controls="onsite-archived" aria-selected="true">
                                        On-site Students
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="online-tab" data-bs-toggle="tab" data-bs-target="#online-archived" 
                                            type="button" role="tab" aria-controls="online-archived" aria-selected="false">
                                        Online Students
                                    </button>
                                </li>
                            </ul>
    
                            <div class="tab-content" id="studentSubTabsContent">
                                <div class="tab-pane fade show active" id="onsite-archived" role="tabpanel" aria-labelledby="onsite-tab">
                                    <div class="table-responsive mt-3">
                                        <table id="osTab" class="table table-striped align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Contact Information</th>
                                                    <th>Program</th>
                                                    <th>Learning Mode</th>
                                                    <th>Reason</th>
                                                    <th>Archived At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if (empty($archivedOnsite)): ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">No archived on-site students</td>
                                                    </tr>
                                                <?php else: ?>
                                                    <?php foreach ($archivedOnsite as $student): ?>
                                                        <tr>
                                                            <td><?= clean_input(strtoupper($student['full_name'])) ?></td>
                                                            <td>
                                                            <strong>Contact:</strong> <?= clean_input($student['contact_number'] ?? 'N/A') ?><br>
                                                            <strong>Email:</strong> <?= clean_input($student['email'] ?? 'N/A') ?>
                                                            </td>
                                                            <td><?= clean_input($student['program_info']) ?></td>
                                                            <td><?= clean_input($student['classification']) ?></td>
                                                            <td><?= clean_input($student['reason']) ?></td>
                                                            <td><?= $student['deleted_at'] ? date('M d, Y h:i A', strtotime($student['deleted_at'])) : 'N/A' ?></td>
                                                            <td>
                                                                <button class="btn btn-sm btn-success" 
                                                                        onclick="openStudentModal('restoreStudentModal', <?= $student['enrollment_id'] ?>, 'restore')">
                                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade" id="online-archived" role="tabpanel" aria-labelledby="online-tab">
                                    <div class="table-responsive mt-3">
                                        <table id="olTab" class="table table-striped align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Student Name</th>
                                                    <th>Contact Information</th>
                                                    <th>Program</th>
                                                    <th>Learning Mode</th>
                                                    <th>Reason</th>
                                                    <th>Archived At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php 
                                                if (empty($archivedOnline)): ?>
                                                    <tr>
                                                        <td colspan="6" class="text-center">No archived online students</td>
                                                    </tr>
                                                <?php else: ?>
                                                    <?php foreach ($archivedOnline as $student): ?>
                                                        <tr>
                                                            <td><?= clean_input(strtoupper($student['full_name'])) ?></td>
                                                            <td>
                                                            <strong>Contact:</strong> <?= clean_input($student['contact_number'] ?? 'N/A') ?><br>
                                                            <strong>Email:</strong> <?= clean_input($student['email'] ?? 'N/A') ?>
                                                            </td>
                                                            <td><?= clean_input($student['program_info']) ?></td>
                                                            <td><?= clean_input($student['classification']) ?></td>
                                                            <td><?= clean_input($student['reason']) ?></td>
                                                            <td><?= $student['deleted_at'] ? date('M d, Y h:i A', strtotime($student['deleted_at'])) : 'N/A' ?></td>
                                                            <td>
                                                                <button class="btn btn-sm btn-success" 
                                                                        onclick="openStudentModal('restoreStudentModal', <?= $student['enrollment_id'] ?>, 'restore')">
                                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="officers" role="tabpanel" aria-labelledby="officers-tab">
                            <div class="table-responsive">
                                    <table id="officersTab" class="table table-striped align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>Officer Name</th>
                                                <th>Position</th>
                                                <th>School Year</th>
                                                <th>Reason</th>
                                                <th>Deleted At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($archivedOfficers)): ?>
                                                <tr>
                                                    <td colspan="6" class="text-center">No archived officers</td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($archivedOfficers as $officer): ?>
                                                    <tr>
                                                        <td><?= clean_input(strtoupper($officer['full_name'])) ?></td>
                                                        <td><?= clean_input($officer['program_name']) ?? 'N/A' ?></td>
                                                        <td><?= clean_input($officer['position_name']) ?></td>
                                                        <td><?= clean_input($officer['school_year']) ?></td>
                                                        <td><?= clean_input($officer['reason']) ?></td>
                                                        <td><?= $officer['deleted_at'] ? date('M d, Y h:i A', strtotime($officer['deleted_at'])) : 'N/A' ?></td>
                                                        <td>
                                                            <button class="btn btn-sm btn-success" 
                                                                    onclick="openOfficerModal('restoreOfficerModal', <?= $officer['officer_id'] ?>, 'restore')">
                                                                <i class="bi bi-arrow-counterclockwise"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="volunteers" role="tabpanel" aria-labelledby="volunteers-tab">
                                <div class="table-responsive">
                                    <table id="volunteersTab" class="table table-striped align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>Volunteer Name</th>
                                                <th>Program</th>
                                                <th>Year & Section</th>
                                                <th>Contact</th>
                                                <th>Email</th>
                                                <th>Reason</th>
                                                <th>Deleted At</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php if (empty($archivedVolunteers)): ?>
                                                <tr>
                                                    <td colspan="9" class="text-center">No archived volunteers</td>
                                                </tr>
                                            <?php else: ?>
                                                <?php foreach ($archivedVolunteers as $volunteer): ?>
                                                    <tr>
                                                        <td><?= clean_input(strtoupper($volunteer['full_name'])) ?></td>
                                                        <td><?= clean_input($volunteer['program_name'] ?? 'N/A') ?></td>
                                                        <td><?= clean_input($volunteer['yr_section'] ?? 'N/A') ?></td>
                                                        <td><?= clean_input($volunteer['contact'] ?? 'N/A') ?></td>
                                                        <td><?= clean_input($volunteer['email'] ?? 'N/A') ?></td>
                                                        <td><?= clean_input($volunteer['reason'] ?? 'N/A') ?></td>
                                                        <td><?= isset($volunteer['deleted_at']) && $volunteer['deleted_at'] ? date('M d, Y h:i A', strtotime($volunteer['deleted_at'])) : 'N/A' ?></td>
                                                        <td>
                                                            <button class="btn btn-sm btn-success" 
                                                                    onclick="openVolunteerModal('restoreVolunteerModal', <?= $volunteer['volunteer_id'] ?>, 'restore')">
                                                                <i class="bi bi-arrow-counterclockwise"></i>
                                                            </button>
                                                        </td>
                                                    </tr>
                                                <?php endforeach; ?>
                                            <?php endif; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="moderators" role="tabpanel" aria-labelledby="moderators-tab">
                            <div class="table-responsive">
                                <table id="moderatorsTab" class="table table-striped align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Position</th>
                                            <th>Reason</th>
                                            <th>Archived At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($archivedModerators)): ?>
                                            <tr>
                                                <td colspan="7" class="text-center py-4">No archived moderators found</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($archivedModerators as $moderator): ?>
                                                <tr>
                                                    <td><?= clean_input(strtoupper($moderator['full_name'])) ?></td>
                                                    <td><?= clean_input($moderator['username']) ?></td>
                                                    <td><?= clean_input($moderator['email']) ?></td>
                                                    <td><?= clean_input($moderator['position_name']) ?></td>
                                                    <td><?= clean_input($moderator['reason']) ?></td>
                                                    <td><?= date('M j, Y', strtotime($moderator['deleted_at'])) ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-success" 
                                                                onclick="openModeratorModal('restoreModeratorModal', <?= $moderator['user_id'] ?>, 'restore')">
                                                            <i class="bi bi-arrow-counterclockwise"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table> 
                            </div>
                        </div>
                        <div class="tab-pane fade" id="archived-updates" role="tabpanel" aria-labelledby="archived-updates-tab">
                            <div class="table-responsive">
                                <table id="archivedUpdatesTab" class="table table-striped align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Content Preview</th>
                                            <th>Created By</th>
                                            <th>Created At</th>
                                            <th>Images</th>
                                            <th>Reason</th>
                                            <th>Deleted At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($archivedUpdates)): ?>
                                            <tr>
                                                <td colspan="8" class="text-center">No archived updates</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($archivedUpdates as $update): ?>
                                                <tr>
                                                    <td><?= clean_input($update['title']) ?></td>
                                                    <td><?= clean_input(substr($update['content'], 0, 50)) . (strlen($update['content']) > 50 ? '...' : '') ?></td>
                                                    <td><?= clean_input($update['created_by']) ?></td>
                                                    <td><?= date('M d, Y', strtotime($update['created_at'])) ?></td>
                                                    <td>
                                                        <?php if (!empty($update['image_paths'])): ?>
                                                            <div class="d-flex flex-wrap gap-1" style="max-width: 200px;">
                                                                <?php 
                                                                $images = explode('||', $update['image_paths']);
                                                                foreach ($images as $path): 
                                                                    if (!empty($path)): ?>
                                                                        <img src="../../assets/updates/<?= clean_input($path) ?>" 
                                                                            class="img-thumbnail" 
                                                                            style="width: 50px; height: 50px; object-fit: cover;"
                                                                            data-bs-toggle="tooltip" 
                                                                            data-bs-title="<?= clean_input(basename($path)) ?>">
                                                                    <?php endif;
                                                                endforeach; ?>
                                                            </div>
                                                        <?php else: ?>
                                                            No images
                                                        <?php endif; ?>
                                                    </td>
                                                    <td><?= clean_input($update['reason']) ?></td>
                                                    <td><?= date('M d, Y h:i A', strtotime($update['deleted_at'])) ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-success" 
                                                                onclick="openUpdateModal('restoreUpdateModal', <?= $update['update_id'] ?>, 'restore')">
                                                            <i class="bi bi-arrow-counterclockwise"></i>
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="schoolConfig" role="tabpanel" aria-labelledby="schoolConfig-tab">
                            <ul class="nav nav-tabs" id="schoolConfigSubTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active" id="schoolYears-tab" data-bs-toggle="tab" data-bs-target="#schoolYears" 
                                            type="button" role="tab" aria-controls="schoolYears" aria-selected="true">
                                        School Years
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="officerPositions-tab" data-bs-toggle="tab" data-bs-target="#officerPositions" 
                                            type="button" role="tab" aria-controls="officerPositions" aria-selected="false">
                                        Officer Positions
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="colleges-tab" data-bs-toggle="tab" data-bs-target="#colleges" 
                                            type="button" role="tab" aria-controls="colleges" aria-selected="false">
                                        Colleges
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link" id="programs-tab" data-bs-toggle="tab" data-bs-target="#programs" 
                                            type="button" role="tab" aria-controls="programs" aria-selected="false">
                                        Programs
                                    </button>
                                </li>
                            </ul>
                            
                            <div class="tab-content" id="schoolConfigSubTabsContent">
                                <div class="tab-pane fade show active" id="schoolYears" role="tabpanel" aria-labelledby="schoolYears-tab">
                                    <div class="table-responsive mt-3">
                                        <table id="schoolYearsTab" class="table table-striped align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>School Year</th>
                                                    <th>Reason</th>
                                                    <th>Archived At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($archivedSchoolYears)): ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center">No archived school years</td>
                                                    </tr>
                                                <?php else: ?>
                                                    <?php foreach ($archivedSchoolYears as $schoolYear): ?>
                                                        <tr>
                                                            <td><?= clean_input($schoolYear['school_year']) ?></td>
                                                            <td><?= clean_input($schoolYear['reason']) ?></td>
                                                            <td><?= $schoolYear['deleted_at'] ? date('M d, Y h:i A', strtotime($schoolYear['deleted_at'])) : 'N/A' ?></td>
                                                            <td>
                                                                <button class="btn btn-sm btn-success" 
                                                                        onclick="openSchoolYearModal('restoreSchoolYearModal', <?= $schoolYear['school_year_id'] ?>, 'restore')">
                                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade" id="officerPositions" role="tabpanel" aria-labelledby="officerPositions-tab">
                                    <div class="table-responsive mt-3">
                                        <table id="officerPositionsTab" class="table table-striped align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Position Name</th>
                                                    <th>Reason</th>
                                                    <th>Archived At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($archivedPositions)): ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center">No archived officer positions</td>
                                                    </tr>
                                                <?php else: ?>
                                                    <?php foreach ($archivedPositions as $position): ?>
                                                        <tr>
                                                            <td><?= clean_input($position['position_name']) ?></td>
                                                            <td><?= clean_input($position['reason']) ?></td>
                                                            <td><?= $position['deleted_at'] ? date('M d, Y h:i A', strtotime($position['deleted_at'])) : 'N/A' ?></td>
                                                            <td>
                                                                <button class="btn btn-sm btn-success" 
                                                                        onclick="openPositionModal('restorePositionModal', <?= $position['position_id'] ?>, 'restore')">
                                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade" id="colleges" role="tabpanel" aria-labelledby="colleges-tab">
                                    <div class="table-responsive">
                                        <table id="collegesTab" class="table table-striped align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>College Name</th>
                                                    <th>Reason</th>
                                                    <th>Deleted At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($archivedColleges)): ?>
                                                    <tr>
                                                        <td colspan="4" class="text-center">No archived colleges</td>
                                                    </tr>
                                                <?php else: ?>
                                                    <?php foreach ($archivedColleges as $college): ?>
                                                        <tr>
                                                            <td><?= clean_input($college['college_name']) ?></td>
                                                            <td><?= clean_input($college['reason']) ?></td>
                                                            <td><?= $college['deleted_at'] ? date('M d, Y h:i A', strtotime($college['deleted_at'])) : 'N/A' ?></td>
                                                            <td>
                                                                <button class="btn btn-sm btn-success" onclick="setCollegeId(<?= $college['college_id'] ?>, 'restore')">
                                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                
                                <div class="tab-pane fade" id="programs" role="tabpanel" aria-labelledby="programs-tab">
                                    <div class="table-responsive">
                                        <table id="programsTab" class="table table-striped align-items-center mb-0">
                                            <thead>
                                                <tr>
                                                    <th>Program Name</th>
                                                    <th>College</th>
                                                    <th>Reason</th>
                                                    <th>Deleted At</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php if (empty($archivedPrograms)): ?>
                                                    <tr>
                                                        <td colspan="5" class="text-center">No archived programs</td>
                                                    </tr>
                                                <?php else: ?>
                                                    <?php foreach ($archivedPrograms as $program): ?>
                                                        <tr>
                                                            <td><?= clean_input($program['program_name']) ?></td>
                                                            <td><?= clean_input($program['college_name']) ?></td>
                                                            <td><?= clean_input($program['reason']) ?></td>
                                                            <td><?= $program['deleted_at'] ? date('M d, Y h:i A', strtotime($program['deleted_at'])) : 'N/A' ?></td>
                                                            <td>
                                                                <button class="btn btn-sm btn-success" onclick="setProgramId(<?= $program['program_id'] ?>, 'restore')">
                                                                    <i class="bi bi-arrow-counterclockwise"></i>
                                                                </button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                <?php endif; ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include_once '../adminModals/restoreCollege.html'; ?>
<?php include_once '../adminModals/restoreProgram.html'; ?>
<?php include_once '../adminModals/restoreEvent.html'; ?>
<?php include_once '../adminModals/restoreCalendar.html'; ?>
<?php include_once '../adminModals/restorePrayer.html'; ?>
<?php include_once '../adminModals/restoreDailyPrayer.html'; ?>
<?php include_once '../adminModals/restoreTransaction.html'; ?>
<?php include_once '../adminModals/restoreFaq.html'; ?>
<?php include_once '../adminModals/restoreAbouts.html'; ?>
<?php include_once '../adminModals/restoreFile.html'; ?>
<?php include_once '../adminModals/restoreStudent.html'; ?>
<?php include_once '../adminModals/restoreOfficer.html'; ?>
<?php include_once '../adminModals/restoreVolunteer.html'; ?>
<?php include_once '../adminModals/restoreModerator.html'; ?>
<?php include_once '../adminModals/restoreUpdates.html'; ?>
<?php include_once '../adminModals/restoreExePosition.html'; ?>
<?php include_once '../adminModals/restoreSchoolYear.html'; ?>

<script>
$(document).ready(function() {
    // Initialize DataTables for all tables in archives
    $('#calendarTab').DataTable();
    $('#prayerTab').DataTable();
    $('#dailyPrayerTab').DataTable();
    $('#cashinTab').DataTable();
    $('#cashoutTab').DataTable();
    $('#faqsTab').DataTable();
    $('#aboutTab').DataTable();
    $('#filesTab').DataTable();
    $('#osTab').DataTable();
    $('#olTab').DataTable();
    $('#officersTab').DataTable();
    $('#volunteersTab').DataTable();
    $('#moderatorsTab').DataTable();
    $('#archivedUpdatesTab').DataTable();
    $('#schoolYearsTab').DataTable();
    $('#collegesTab').DataTable();
    $('#programsTab').DataTable();
    $('#officerPositionsTab').DataTable();
});
</script>

<!-- <script>
    $(document).ready(function() {
        new bootstrap.Tab(document.querySelector('#colleges-tab')).show();
    });
</script> -->