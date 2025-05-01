<div class="modal fade" id="editAboutModal" tabindex="-1" aria-labelledby="editAboutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editAboutForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit About MSA</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="id" id="editAboutId">
                    <div class="mb-3">
                        <label for="editMission" class="form-label">Mission</label>
                        <textarea class="form-control" id="editMission" name="mission"></textarea>
                        <div id="editMissionError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editVision" class="form-label">Vision</label>
                        <textarea class="form-control" id="editVision" name="vision"></textarea>
                        <div id="editVisionError" class="text-danger"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="editAboutFormSubmit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>