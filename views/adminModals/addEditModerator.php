<?php
require_once '../../classes/adminClass.php';
require_once '../../classes/accountClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$accountObj = new Account();
$positions = $accountObj->fetchOfficerPositions();
?>

<div class="modal fade" id="editModeratorModal" tabindex="-1" aria-labelledby="editModeratorModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg moderator-modal">
        <div class="modal-content">
            <form id="editModeratorForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModeratorModalLabel">Edit Moderator</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="editModeratorId">
                    
                    <!-- Left Column -->
                    <div class="modal-section">
                        <h6 class="section-title">Personal Information</h6>
                    <div class="mb-3 position-relative">
                        <label for="editFirstName" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editFirstName" name="firstName">
                        <span class="invalid-icon" id="editFirstNameIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editFirstNameError" class="text-danger"></div>
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="editMiddleName" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="editMiddleName" name="middleName">
                        <span class="invalid-icon" id="editMiddleNameIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editMiddleNameError" class="text-danger"></div>
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="editLastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editLastName" name="lastName">
                        <span class="invalid-icon" id="editLastNameIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editLastNameError" class="text-danger"></div>
                    </div>

                    <div class="mb-3">
                        <label for="editPositionId" class="form-label">Position <span class="text-danger">*</span></label>
                        <select class="form-select" id="editPositionId" name="positionId">
                            <option value="">Select Position</option>
                            <?php foreach ($positions as $position): ?>
                                <option value="<?= $position['position_id'] ?>"><?= $position['position_name'] ?></option>
                            <?php endforeach; ?>
                        </select>
                        <div id="editPositionIdError" class="text-danger"></div>
                    </div>

                    </div>


                    <!-- Right Column -->
                    <div class="modal-section">
                        <h6 class="section-title">Account Information</h6>
                    <div class="mb-3 position-relative">
                        <label for="editUsername" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editUsername" name="username">
                        <span class="invalid-icon" id="editUsernameIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editUsernameError" class="text-danger"></div>
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="editEmail" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="editEmail" name="email">
                        <span class="invalid-icon" id="editEmailIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editEmailError" class="text-danger"></div>
                    </div>

                    <div class="mb-3 position-relative" id="passwordContainer">
                        <label for="editPassword" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="editPassword" name="password">
                        <span class="invalid-icon" id="editPasswordIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editPasswordError" class="text-danger"></div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="editModeratorFormSubmit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>