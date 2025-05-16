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
    <div class="modal-dialog modal-lg officer-modal">
        <div class="modal-content">
            <form id="editOfficerForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="editOfficerModalLabel">Edit Officer</h5>
                </div>
                <div class="modal-body d-flex flex-wrap">
                    <input type="hidden" name="officer_id" id="editOfficerId">
                    
                    <!-- Left Column -->
                    <div class="modal-section flex-fill" style="min-width: 48%;">
                        <h6 class="section-title">Personal Information</h6>
                        <div class="mb-3 position-relative">
                            <label for="editFirstName" class="form-label">First Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editFirstName" name="firstName" value="<?= $officer['first_name'] ?? '' ?>">
                            <span class="invalid-icon" id="editFirstNameIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                            <div id="editFirstNameError" class="text-danger"></div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="editMiddleName" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="editMiddleName" name="middleName" value="<?= $officer['middle_name'] ?? '' ?>">
                            <span class="invalid-icon" id="editMiddleNameIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                            <div id="editMiddleNameError" class="text-danger"></div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="editSurname" class="form-label">Surname <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editSurname" name="surname" value="<?= $officer['surname'] ?? '' ?>">
                            <span class="invalid-icon" id="editSurnameIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                            <div id="editSurnameError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="editProgram" class="form-label">Program <span class="text-danger">*</span></label>
                            <select class="form-select" id="editProgram" name="program">
                                <option value="">Select Program</option>
                                <?php foreach ($programs as $program): ?>
                                    <option value="<?= $program['program_id'] ?>" <?= ($officer && $officer['program_id'] == $program['program_id']) ? 'selected' : '' ?>>
                                    <?= clean_input($program['program_name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div id="editProgramError" class="text-danger"></div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="modal-section flex-fill" style="min-width: 48%;">
                        <h6 class="section-title">Officer Details</h6>
                        <div class="mb-3">
                            <label class="form-label">Office <span class="text-danger">*</span></label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="office" id="officeWac" value="wac" <?= ($officer && $officer['office'] === 'wac') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="officeWac">WAC</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="office" id="officeMale" value="male" <?= ($officer && $officer['office'] === 'male') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="officeMale">Executive</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="office" id="officeIls" value="ils" <?= ($officer && $officer['office'] === 'ils') ? 'checked' : '' ?>>
                                    <label class="form-check-label" for="officeIls">ILS</label>
                                </div>
                            </div>
                            <div id="editOfficeError" class="text-danger"></div>
                        </div>
                        <div class="mb-3">
                            <label for="editPosition" class="form-label">Position <span class="text-danger">*</span></label>
                            <select class="form-select" id="editPosition" name="position">
                                <option value="">Select Position</option>
                                <?php foreach ($positions as $position): ?>
                                    <option value="<?= $position['position_id'] ?>" <?= ($officer && $officer['position_id'] == $position['position_id']) ? 'selected' : '' ?>>
                                    <?= clean_input($position['position_name']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div id="editPositionError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="editSchoolYear" class="form-label">School Year <span class="text-danger">*</span></label>
                            <select class="form-select" id="editSchoolYear" name="schoolYear">
                                <option value="">Select School Year</option>
                                <?php foreach ($schoolYears as $schoolYear): ?>
                                    <option value="<?= $schoolYear['school_year_id'] ?>" <?= ($officer && $officer['school_year_id'] == $schoolYear['school_year_id']) ? 'selected' : '' ?>>
                                    <?= clean_input($schoolYear['school_year']) ?>
                                </option>
                                <?php endforeach; ?>
                            </select>
                            <div id="editSchoolYearError" class="text-danger"></div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="editImage" class="form-label">Officer Image <span class="text-danger">*</span></label>
                            <input class="form-control" type="file" id="editImage" name="image">
                            <span class="invalid-icon" id="editImageIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                            <small class="text-muted">Leave blank to keep current image.</small>
                            <div id="image-preview" class="mt-2" style="display:none;">
                                <img id="preview-img" src="<?= $officer && !empty($officer['image']) ? '../../assets/officers/' . $officer['image'] : '' ?>" alt="Officer Image" class="img-thumbnail" width="150">
                            </div>
                            <div id="editImageError" class="text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="editOfficerFormSubmit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>