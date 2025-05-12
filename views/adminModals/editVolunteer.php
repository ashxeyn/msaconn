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
    <div class="modal-dialog modal-lg student-modal">
        <div class="modal-content">
            <form id="volunteerForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="editVolunteerModalLabel">Edit Volunteer</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="volunteer_id" id="volunteerId">
                    
                    <!-- Left Column -->
                    <div class="modal-section">
                        <h6 class="section-title">Personal Information</h6>
                        <div class="mb-3 position-relative">
                            <label for="firstName" class="form-label">First Name </label>
                            <input type="text" class="form-control" id="firstName" name="firstName">
                            <span class="invalid-icon" id="firstNameIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                            <div id="firstNameError" class="text-danger"></div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="middleName" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="middleName" name="middleName">
                            <span class="invalid-icon" id="middleNameIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                            <div id="middleNameError" class="text-danger"></div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="surname" class="form-label">Surname </label>
                            <input type="text" class="form-control" id="surname" name="surname">
                            <span class="invalid-icon" id="surnameIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                            <div id="surnameError" class="text-danger"></div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="year" class="form-label">Year Level </label>
                            <select class="form-select" id="year" name="year">
                                <option value="">Select Year Level</option>
                                <option value="1">1st Year</option>
                                <option value="2">2nd Year</option>
                                <option value="3">3rd Year</option>
                                <option value="4">4th Year</option>
                                <option value="others">Others</option>
                            </select>
                            <span class="invalid-icon" id="yearIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                            <div id="yearError" class="text-danger"></div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="modal-section">
                        <h6 class="section-title">Contact & Program Information</h6>
                        <div class="mb-3 position-relative">
                            <label for="program" class="form-label">Program </label>
                            <select class="form-select" id="program" name="program">
                                <option value="">Select Program</option>
                                <?php foreach ($programs as $program): ?>
                                    <option value="<?= $program['program_id'] ?>">
                                        <?= clean_input($program['program_name']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <span class="invalid-icon" id="programIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                            <div id="programError" class="text-danger"></div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="contact" class="form-label">Contact Number </label>
                            <input type="text" class="form-control" id="contact" name="contact" pattern="\d{11}" maxlength="11">
                            <span class="invalid-icon" id="contactIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                            <div id="contactError" class="text-danger"></div>
                            <div class="form-text">Format: 11-digit number (e.g., 09XXXXXXXXX)</div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="email" class="form-label">Email Address </label>
                            <input type="email" class="form-control" id="email" name="email">
                            <span class="invalid-icon" id="emailIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                            <div id="emailError" class="text-danger"></div>
                        </div>

                        <div class="mb-3 position-relative">
                            <label for="image" class="form-label">Certificate of Registration (COR) </label>
                            <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            <span class="invalid-icon" id="imageIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                            <div id="imageError" class="text-danger"></div>
                            <input type="hidden" id="existing_image" name="existing_image">
                            <small class="text-muted">Leave blank to keep current image.</small>
                            <div id="image-preview" class="mt-2" style="display:none;">
                                <img id="preview-img" src="" alt="COR Preview" class="img-thumbnail" width="150">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="volunteerFormSubmit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>