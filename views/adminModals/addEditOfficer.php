<?php
require_once '../../classes/adminClass.php';
require_once '../../classes/accountClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$accountObj = new Account();
$programs = $adminObj->fetchProgram();
$positions = $accountObj->fetchOfficerPositions();
$schoolYears = $adminObj->fetchSy();

$officerId = $_GET['officerId'] ?? null;
$officer = null;
if ($officerId) {
    $officer = $adminObj->getOfficerById($officerId);
}
?>

<div class="modal fade" id="editOfficerModal" tabindex="-1" aria-labelledby="editOfficerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editOfficerForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Officer</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="officer_id" id="editOfficerId">
                    <div class="mb-3">
                        <label for="editFirstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="editFirstName" name="firstName">
                        <div id="editFirstNameError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editMiddleName" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="editMiddleName" name="middleName">
                        <div id="editMiddleNameError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editSurname" class="form-label">Surname</label>
                        <input type="text" class="form-control" id="editSurname" name="surname">
                        <div id="editSurnameError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editProgram" class="form-label">Program</label>
                        <select class="form-select" id="editProgram" name="program">
                            <option value="">Select Program</option>
                            <?php foreach ($programs as $program): ?>
                                <option value="<?= $program['program_id'] ?>">
                                    <?= clean_input($program['program_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="editProgramError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editPosition" class="form-label">Position</label>
                        <select class="form-select" id="editPosition" name="position">
                            <option value="">Select Position</option>
                            <?php foreach ($positions as $position): ?>
                                <option value="<?= $position['position_id'] ?>">
                                    <?= clean_input($position['position_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="editPositionError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editSchoolYear" class="form-label">School Year</label>
                        <select class="form-select" id="editSchoolYear" name="schoolYear">
                            <option value="">Select School Year</option>
                            <?php foreach ($schoolYears as $schoolYear): ?>
                                <option value="<?= $schoolYear['school_year_id'] ?>">
                                    <?= clean_input($schoolYear['school_year']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="editSchoolYearError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editImage" class="form-label">Officer Image</label>
                        <input class="form-control" type="file" id="editImage" name="image">
                        <small class="text-muted">Leave blank to keep current image.</small>
                        <div id="image-preview" class="mt-2" style="display:none;">
                            <img id="preview-img" src="" alt="Officer Image" class="img-thumbnail" width="150">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="editOfficerFormSubmit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>