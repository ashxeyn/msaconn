<?php
require_once '../../classes/adminClass.php';
require_once '../../classes/accountClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$accountObj = new Account();
$positions = $accountObj->fetchOfficerPositions();
?>

<div class="modal fade" id="editModeratorModal" tabindex="-1" aria-labelledby="editModeratorModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form id="editModeratorForm" enctype="multipart/form-data">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModeratorModalLabel">Edit Moderator</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="user_id" id="editModeratorId">
                    <div class="mb-3">
                        <label for="editFirstName" class="form-label">First Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editFirstName" name="firstName">
                        <div id="editFirstNameError" class="text-danger"></div>
                    </div>

                    <div class="mb-3">
                        <label for="editMiddleName" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="editMiddleName" name="middleName">
                    </div>

                    <div class="mb-3">
                        <label for="editLastName" class="form-label">Last Name <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editLastName" name="lastName">
                        <div id="editLastNameError" class="text-danger"></div>
                    </div>

                    <div class="mb-3">
                        <label for="editUsername" class="form-label">Username <span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="editUsername" name="username">
                        <div id="editUsernameError" class="text-danger"></div>
                    </div>

                    <div class="mb-3">
                        <label for="editEmail" class="form-label">Email <span class="text-danger">*</span></label>
                        <input type="email" class="form-control" id="editEmail" name="email">
                        <div id="editEmailError" class="text-danger"></div>
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

                    <div class="mb-3" id="passwordContainer">
                        <label for="editPassword" class="form-label">Password <span class="text-danger">*</span></label>
                        <input type="password" class="form-control" id="editPassword" name="password">
                        <div id="editPasswordError" class="text-danger"></div>
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