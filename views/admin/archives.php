<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$archivedColleges = $adminObj->fetchArchivedColleges();
$archivedPrograms = $adminObj->fetchArchivedPrograms();
$archivedEvents = $adminObj->fetchArchivedEvents();
$archivedCalendar = $adminObj->fetchArchivedCalendar();
?>

<head>
    <script src="../../js/admin.js"></script>
</head>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body px-0 pb-2">
                    <ul class="nav nav-tabs" id="archivesTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="colleges-tab" data-bs-toggle="tab" data-bs-target="#colleges" 
                                    type="button" role="tab" aria-controls="colleges" aria-selected="true">
                                Colleges
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="programs-tab" data-bs-toggle="tab" data-bs-target="#programs" 
                                    type="button" role="tab" aria-controls="programs" aria-selected="false">
                                Programs
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="archived-events-tab" data-bs-toggle="tab" data-bs-target="#archived-events" type="button" role="tab" aria-controls="archived-events" aria-selected="false">
                                Events
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar" 
                                    type="button" role="tab" aria-controls="calendar" aria-selected="false">
                                Calendar Activities
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content" id="archivesTabsContent">
                        <div class="tab-pane fade show active" id="colleges" role="tabpanel" aria-labelledby="colleges-tab">
                            <div class="table-responsive">
                                <table id="table" class="table align-items-center mb-0">
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
                                                            <i class="fas fa-undo"></i> Restore
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
                                <table id="progTab" class="table align-items-center mb-0">
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
                                                            <i class="fas fa-undo"></i> Restore
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="tab-pane fade" id="archived-events" role="tabpanel" aria-labelledby="archived-events-tab">
                            <div class="table-responsive">
                                <table id="eventTab" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Description</th>
                                            <th>Archived By</th>
                                            <th>Reason</th>
                                            <th>Archived At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($archivedEvents)): ?>
                                            <tr>
                                                <td colspan="5" class="text-center">No archived events</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($archivedEvents as $event): ?>
                                                <tr>
                                                    <td><?= clean_input($event['description']) ?></td>
                                                    <td><?= clean_input($event['uploaded_by']) ?></td>
                                                    <td><?= clean_input($event['reason']) ?></td>
                                                    <td><?= $event['deleted_at'] ? date('M d, Y h:i A', strtotime($event['deleted_at'])) : 'N/A' ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-success" onclick="setEventId(<?= $event['event_id'] ?>, 'restore')">
                                                            <i class="fas fa-undo"></i> Restore
                                                        </button>
                                                    </td>
                                                </tr>
                                            <?php endforeach; ?>
                                        <?php endif; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="calendar" role="tabpanel" aria-labelledby="calendar-tab">
                            <div class="table-responsive">
                                <table id="calendarTab" class="table align-items-center mb-0">
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
                                                        <button class="btn btn-sm btn-success" onclick="setActivityId(<?= $activity['activity_id'] ?>, 'restore')">
                                                            <i class="fas fa-undo"></i> Restore
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

<?php include_once '../adminModals/restoreCollege.html'; ?>
<?php include_once '../adminModals/restoreProgram.html'; ?>
<?php include_once '../adminModals/restoreEvent.html'; ?>
<?php include_once '../adminModals/restoreCalendar.html'; ?>

<script>
    $(document).ready(function() {
        new bootstrap.Tab(document.querySelector('#colleges-tab')).show();
    });
</script>