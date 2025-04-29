<div class="modal fade" id="editCalendarModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Activity</h5>
            </div>
            <div class="modal-body">
                <form id="editCalendarForm">
                    <input type="hidden" id="editActivityId" name="activity_id">

                    <div class="mb-3">
                        <label class="form-label">Date</label>
                        <input type="date" class="form-control" name="activity_date" id="editActivityDate">
                        <div class="text-danger" id="editActivityDateError"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Activity</label>
                        <input type="text" class="form-control" name="title" id="editTitle">
                        <div class="text-danger" id="editTitleError"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <textarea class="form-control" name="description" id="editDescription"></textarea>
                        <div class="text-danger" id="editDescriptionError"></div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary" id="editCalendarFormSubmit">Add Activity</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
