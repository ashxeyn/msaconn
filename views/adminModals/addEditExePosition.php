<div class="modal fade" id="editExePositionModal" tabindex="-1" aria-labelledby="editExePositionModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editPositionForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Executive Position</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="position_id" id="editPositionId">
                    <div class="mb-3">
                        <label for="editPositionName" class="form-label">Position Name</label>
                        <input type="text" class="form-control" id="editPositionName" name="position_name">
                        <div id="editPositionNameError" class="text-danger"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="editPositionFormSubmit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>