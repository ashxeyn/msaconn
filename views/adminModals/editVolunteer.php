<?php
require_once '../../classes/adminClass.php';
require_once '../../classes/accountClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$accountObj = new Account();
$programs = $adminObj->fetchProgram();

$volunteerId = $_GET['volunteerId'] ?? null;
$volunteer = null;
if ($volunteerId) {
    $volunteer = $adminObj->getVolunteerById($volunteerId);
}
?>

<div class="modal fade" id="editVolunteerModal" tabindex="-1" aria-labelledby="editVolunteerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="volunteerForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Volunteer</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="volunteer_id" id="volunteerId">
                    <div class="mb-3">
                        <label for="firstName" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstName" name="firstName">
                        <div id="firstNameError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="middleName" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middleName" name="middleName">
                        <div id="middleNameError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="surname" class="form-label">Surname</label>
                        <input type="text" class="form-control" id="surname" name="surname">
                        <div id="surnameError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="year" class="form-label">Year Level</label>
                        <input type="number" class="form-control" id="year" name="year" min="1" max="6">
                        <div id="yearError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="section" class="form-label">Section</label>
                        <input type="text" class="form-control" id="section" name="section">
                        <div id="sectionError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="program" class="form-label">Program</label>
                        <select class="form-select" id="program" name="program">
                            <option value="">Select Program</option>
                            <?php foreach ($programs as $program): ?>
                                <option value="<?= $program['program_id'] ?>">
                                    <?= clean_input($program['program_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="programError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="contact" name="contact" pattern="\d{11}" maxlength="11">
                        <div id="contactError" class="text-danger"></div>
                        <div class="form-text">Format: 11-digit number (e.g., 09XXXXXXXXX)</div>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email Address</label>
                        <input type="email" class="form-control" id="email" name="email">
                        <div id="emailError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Certificate of Registration (COR)</label>
                        <input type="file" class="form-control" id="image" name="image" accept="image/*">
                        <div id="imageError" class="text-danger"></div>
                        <input type="hidden" id="existing_image" name="existing_image">
                        <small class="text-muted">Leave blank to keep current image.</small>
                        <div id="image-preview" class="mt-2" style="display:none;">
                            <img id="preview-img" src="" alt="COR Preview" class="img-thumbnail" width="150">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="volunteerFormSubmit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>