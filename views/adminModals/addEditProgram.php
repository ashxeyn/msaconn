<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();
$colleges = $adminObj->fetchColleges();

$programId = $_GET['program_id'] ?? null;
$program = null;

if ($programId) {
    $program = $adminObj->getProgramById($programId);
}
?>

<div class="modal fade" id="addEditProgramModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="programModalTitle">
                    <?= $program ? 'Edit Program' : 'Add Program' ?>
                </h5>
            </div>
            <div class="modal-body">
                <form id="programForm">
                    <input type="hidden" id="programId" name="programId" value="<?= $program ? $program['program_id'] : '' ?>">

                    <div class="mb-3">
                        <label for="collegeSelect" class="form-label">Select College</label>
                        <select class="form-select" id="collegeSelect" name="collegeSelect">
                            <option value="">Select College</option>
                            <?php foreach ($colleges as $college): ?>
                                <option value="<?= $college['college_id'] ?>" <?= ($program && $program['college_id'] == $college['college_id']) ? 'selected' : '' ?>>
                                    <?= clean_input($college['college_name']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                        <div id="collegeSelectError" class="text-danger error-message"></div>
                    </div>

                    <div class="mb-3 position-relative">
                        <label for="programName" class="form-label">Program Name</label>
                        <input type="text" class="form-control" id="programName" name="programName" value="<?= $program ? clean_input($program['program_name']) : '' ?>" required>
                        <span class="invalid-icon" id="programNameIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="programNameError" class="text-danger error-message"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="confirmSaveProgram">
                            <?= $program ? 'Update Program' : 'Add Program' ?>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>