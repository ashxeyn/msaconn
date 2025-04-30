<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();

$enrollmentId = $_GET['enrollment_id'] ?? null;
$student = null;
if ($enrollmentId) {
    $student = $adminObj->getEnrollmentById($enrollmentId);
}
        
$colleges = $adminObj->fetchAllColleges();
$programs = $student && $student['college_id'] ? $adminObj->fetchProgramsByCollege($student['college_id']) : [];
$yearLevels = ['1st year', '2nd year', '3rd year', '4th year', 'Others'];
?>

<div class="modal fade" id="addEditStudentModal" tabindex="-1" aria-labelledby="addEditStudentModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="studentForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalTitle">Add Student</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="enrollmentId" name="enrollmentId" value="<?= $student ? $student['enrollment_id'] : '' ?>">
                    <input type="hidden" id="existing_image" name="existing_image" value="<?= $student['cor_path'] ?? '' ?>">

                    <div id="classificationStep" style="display: <?= $student ? 'none' : 'block' ?>;">
                        <div class="mb-3">
                            <label for="classification" class="form-label">Learning Mode</label>
                            <select class="form-select" id="classification" name="classification">
                                <option value="">Select Classification</option>
                                <option value="On-site" <?= ($student && $student['classification'] == 'On-site') ? 'selected' : '' ?>>On-site</option>
                                <option value="Online" <?= ($student && $student['classification'] == 'Online') ? 'selected' : '' ?>>Online</option>
                            </select>
                            <div id="classificationError" class="text-danger"></div>
                        </div>
                        <div class="text-end mt-3">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="button" class="btn btn-primary" onclick="nextStep()">Next</button>
                        </div>
                    </div>

                    <div id="studentDetailsStep" style="display: <?= $student ? 'block' : 'none' ?>;">
                        <?php if (!$student): ?>
                        <div class="mb-3">
                            <button type="button" class="btn btn-secondary btn-sm" onclick="prevStep()">
                                <i class="fas fa-arrow-left"></i> Back to Classification
                            </button>
                        </div>
                        <?php endif; ?>

                        <div class="mb-3">
                            <label for="firstName" class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" value="<?= $student['first_name'] ?? '' ?>">
                            <div id="firstNameError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="middleName" class="form-label">Middle Name</label>
                            <input type="text" class="form-control" id="middleName" name="middleName" value="<?= $student['middle_name'] ?? '' ?>">
                            <div id="middleNameError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" value="<?= $student['last_name'] ?? '' ?>">
                            <div id="lastNameError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="contactNumber" class="form-label">Contact Number</label>
                            <input type="text" class="form-control" id="contactNumber" name="contactNumber" value="<?= $student['contact_number'] ?? '' ?>">
                            <div id="contactNumberError" class="text-danger"></div>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?= $student['email'] ?? '' ?>">
                            <div id="emailError" class="text-danger"></div>
                        </div>

                        <div id="onsiteFields" class="<?= ($student && $student['classification'] == 'Online') ? 'd-none' : '' ?>">
                            <div class="mb-3">
                                <label for="college" class="form-label">College</label>
                                <select class="form-select" id="college" name="college">
                                    <option value="">Select College</option>
                                    <?php foreach ($colleges as $college): ?>
                                        <option value="<?= $college['college_id'] ?>" 
                                            <?= ($student && $student['college_id'] == $college['college_id']) ? 'selected' : '' ?>>
                                            <?= clean_input($college['college_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="collegeError" class="text-danger"></div>
                            </div>

                            <div class="mb-3">
                                <label for="program" class="form-label">Program</label>
                                <select class="form-select" id="program" name="program">
                                    <option value="">Select Program</option>
                                    <?php foreach ($programs as $program): ?>
                                        <option value="<?= $program['program_id'] ?>" 
                                            <?= ($student && $student['program_id'] == $program['program_id']) ? 'selected' : '' ?>>
                                            <?= clean_input($program['program_name']) ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="programError" class="text-danger"></div>
                            </div>

                            <div class="mb-3">
                                <label for="yearLevel" class="form-label">Year Level</label>
                                <select class="form-select" id="yearLevel" name="yearLevel">
                                    <option value="">Select Year Level</option>
                                    <?php foreach ($yearLevels as $level): ?>
                                        <option value="<?= $level ?>" 
                                            <?= ($student && $student['year_level'] == $level) ? 'selected' : '' ?>>
                                            <?= $level ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <div id="yearLevelError" class="text-danger"></div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="image" class="form-label">Certificate of Registration (COR)</label>
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                                <div id="imageError" class="text-danger"></div>

                                <div id="image-preview" class="mt-2" <?= ($student && !empty($student['cor_path'])) ? '' : 'style="display:none;"' ?>>
                                    <img id="preview-img" src="<?= $student && !empty($student['cor_path']) ? '../../assets/cors/' . $student['cor_path'] : '' ?>" alt="Student COR Image" class="img-thumbnail" width="150">
                                </div>
                            </div>
                        </div>

                        <div id="onlineFields" class="<?= ($student && $student['classification'] == 'On-site') ? 'd-none' : '' ?>">
                            <div class="mb-3">
                                <label for="address" class="form-label">Address</label>
                                <input type="text" class="form-control" id="address" name="address" value="<?= $student['address'] ?? '' ?>">
                                <div id="addressError" class="text-danger"></div>
                            </div>

                            <div class="mb-3">
                                <label for="school" class="form-label">School (Optional)</label>
                                <input type="text" class="form-control" id="school" name="school" value="<?= $student['school'] ?? '' ?>">
                                <div id="schoolError" class="text-danger"></div>
                            </div>
                            
                            <div class="mb-3">
                                <label for="collegeText" class="form-label">College (Optional)</label>
                                <input type="text" class="form-control" id="collegeText" name="collegeText" value="<?= $student['ol_college'] ?? '' ?>">
                                <div id="collegeTextError" class="text-danger"></div>
                            </div>

                            <div class="mb-3">
                                <label for="programText" class="form-label">Program (Optional)</label>
                                <input type="text" class="form-control" id="programText" name="programText" value="<?= $student['ol_program'] ?? '' ?>">
                                <div id="programTextError" class="text-danger"></div>
                            </div>
                        </div>
                        
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <button type="submit" id="confirmSaveStudent" class="btn btn-primary">Add Student</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>