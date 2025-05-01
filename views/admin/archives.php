<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$archivedColleges = $adminObj->fetchArchivedColleges();
$archivedPrograms = $adminObj->fetchArchivedPrograms();
$archivedEvents = $adminObj->fetchArchivedEvents();
$archivedCalendar = $adminObj->fetchArchivedCalendar();
$archivedPrayers = $adminObj->fetchArchivedPrayers();
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


?>

<head>
    <script src="../../js/admin.js"></script>
</head>

<div class="container-fluid py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body px-0 pb-2">

                    <!-- NAV TABS -->
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
                            <button class="nav-link" id="archived-events-tab" data-bs-toggle="tab" data-bs-target="#archived-events" 
                                    type="button" role="tab" aria-controls="archived-events" aria-selected="false">
                                Events
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="calendar-tab" data-bs-toggle="tab" data-bs-target="#calendar" 
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
                                Archived Updates
                            </button>
                        </li>
                    </ul>
                    
                    <div class="tab-content pt-3" id="archivesTabsContent">
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
                                                        <button class="btn btn-sm btn-success" onclick="setCalendarId(<?= $activity['activity_id'] ?>, 'restore')">
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

                        <div class="tab-pane fade" id="prayer" role="tabpanel" aria-labelledby="prayer-tab">                            
                            <div class="table-responsive">
                                <table id="prayerTab" class="table align-items-center mb-0">
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
                                                    <td><?= date('M d, Y', strtotime($prayer['khutbah_date'])) ?></td>
                                                    <td><?= clean_input($prayer['speaker']) ?></td>
                                                    <td><?= clean_input($prayer['topic']) ?></td>
                                                    <td><?= clean_input($prayer['location']) ?></td>
                                                    <td><?= clean_input($prayer['reason']) ?></td>
                                                    <td><?= date('M d, Y h:i A', strtotime($prayer['deleted_at'])) ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-success" onclick="setPrayerId(<?= $prayer['prayer_id'] ?>, 'restore')">
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
                                        <table id="cashinTab" class="table align-items-center mb-0">
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
                                
                                <div class="tab-pane fade" id="cashout" role="tabpanel" aria-labelledby="cashout-tab">
                                    <div class="table-responsive mt-3">
                                        <table id="cashoutTab" class="table align-items-center mb-0">
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
                        <div class="tab-pane fade" id="faqs" role="tabpanel" aria-labelledby="faqs-tab">
                            <div class="table-responsive">
                            <table id="faqsTab" class="table align-items-center mb-0">
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
                                                            <i class="fas fa-rotate-left"></i> Restore
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
                                <table id="aboutTab" class="table align-items-center mb-0">
                                    <thead>
                                        <tr>
                                            <th>Mission</th>
                                            <th>Vision</th>
                                            <th>Description</th>
                                            <th>Reason</th>
                                            <th>Archived At</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php if (empty($archivedAboutMsa)): ?>
                                            <tr>
                                                <td colspan="6" class="text-center">No archived About MSA content found</td>
                                            </tr>
                                        <?php else: ?>
                                            <?php foreach ($archivedAboutMsa as $about): ?>
                                                <tr>
                                                    <td><?= clean_input($about['mission']) ?></td>
                                                    <td><?= clean_input($about['vision']) ?></td>
                                                    <td><?= clean_input($about['description']) ?></td>
                                                    <td><?= clean_input($about['reason']) ?></td>
                                                    <td><?= date('M j, Y', strtotime($about['deleted_at'])) ?></td>
                                                    <td>
                                                        <button class="btn btn-sm btn-success" onclick="openAboutModal('restoreAboutModal', <?= $about['id'] ?>, 'restore')">
                                                            <i class="fas fa-rotate-left"></i> Restore
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
                                <table id="filesTab" class="table align-items-center mb-0">
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
                                                            <i class="fas fa-rotate-left"></i> Restore
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
                                        <table id="osTab" class="table align-items-center mb-0">
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
                                
                                <div class="tab-pane fade" id="online-archived" role="tabpanel" aria-labelledby="online-tab">
                                    <div class="table-responsive mt-3">
                                        <table id="olTab" class="table align-items-center mb-0">
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

                        <div class="tab-pane fade" id="officers" role="tabpanel" aria-labelledby="officers-tab">
                            <div class="table-responsive">
                                    <table id="officersTab" class="table align-items-center mb-0">
                                        <thead>
                                            <tr>
                                                <th>Officer Name</th>
                                                <th>Program</th>
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
                                                    <td colspan="7" class="text-center">No archived officers</td>
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

                            <div class="tab-pane fade" id="volunteers" role="tabpanel" aria-labelledby="volunteers-tab">
                                <div class="table-responsive">
                                    <table id="volunteersTab" class="table align-items-center mb-0">
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
                                                        <td><?= clean_input($volunteer['program_name']) ?? 'N/A' ?></td>
                                                        <td><?= clean_input($volunteer['yr_section']) ?></td>
                                                        <td><?= clean_input($volunteer['contact']) ?></td>
                                                        <td><?= clean_input($volunteer['email']) ?></td>
                                                        <td><?= clean_input($volunteer['reason']) ?></td>
                                                        <td><?= $volunteer['deleted_at'] ? date('M d, Y h:i A', strtotime($volunteer['deleted_at'])) : 'N/A' ?></td>
                                                        <td>
                                                            <button class="btn btn-sm btn-success" 
                                                                    onclick="openVolunteerModal('restoreVolunteerModal', <?= $volunteer['volunteer_id'] ?>, 'restore')">
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

                            <div class="tab-pane fade" id="moderators" role="tabpanel" aria-labelledby="moderators-tab">
                            <div class="table-responsive">
                                <table id="moderatorsTab" class="table align-items-center mb-0">
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
                                                            <i class="fas fa-rotate-left"></i> Restore
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
                                <table id="archivedUpdatesTab" class="table align-items-center mb-0">
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
<?php include_once '../adminModals/restorePrayer.html'; ?>
<?php include_once '../adminModals/restoreTransaction.html'; ?>
<?php include_once '../adminModals/restoreFaq.html'; ?>
<?php include_once '../adminModals/restoreAbouts.html'; ?>
<?php include_once '../adminModals/restoreFile.html'; ?>
<?php include_once '../adminModals/restoreStudent.html'; ?>
<?php include_once '../adminModals/restoreOfficer.html'; ?>
<?php include_once '../adminModals/restoreVolunteer.html'; ?>
<?php include_once '../adminModals/restoreModerator.html'; ?>
<?php include_once '../adminModals/restoreUpdates.html'; ?>

<!-- <script>
    $(document).ready(function() {
        new bootstrap.Tab(document.querySelector('#colleges-tab')).show();
    });
</script> -->