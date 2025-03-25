<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();

$collegeId = $_GET['college_id'] ?? null;
$college = null;
?>

<div class="modal fade" id="addEditCollegeModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="collegeModalTitle">
                    <?= $college ? 'Edit College' : 'Add College' ?>
                </h5>
            </div>
            <div class="modal-body">
                <form id="collegeForm">
                    <input type="hidden" id="collegeId" name="collegeId" value="<?= $college ? $college['college_id'] : '' ?>">
                    <div class="mb-3">
                        <label for="collegeName" class="form-label">College Name</label>
                        <input type="text" class="form-control" id="collegeName" name="collegeName" value="<?= $college ? clean_input($college['college_name']) : '' ?>" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="confirmSaveCollege">
                            <?= $college ? 'Update College' : 'Add College' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
