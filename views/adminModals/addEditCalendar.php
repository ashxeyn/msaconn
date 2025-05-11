<div class="modal fade" id="editCalendarModal" tabindex="-1" aria-labelledby="editCalendarModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editCalendarForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Activity</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="activity_id" id="editActivityId">
                    <div class="mb-3 position-relative">
                        <label for="editActivityDate" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="editActivityDate" name="activity_date">
                        <div id="editActivityDateError" class="text-danger"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="editEndDate" class="form-label">End Date (Optional)</label>
                        <input type="date" class="form-control" id="editEndDate" name="end_date">
                        <div id="editEndDateError" class="text-danger"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="editTime" class="form-label">Time</label>
                        <input type="time" class="form-control" id="editTime" name="time">
                        <span class="invalid-icon" id="editTimeIcon" style="display:none;"><i class="fas fa-exclamation-circle" style="color:#dc3545;"></i></span>
                        <div id="editTimeError" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="editVenue" class="form-label">Venue</label>
                        <small class="form-text text-muted">If not yet decided, put <b>TBA</b> (To Be Announced).</small>
                        <input type="text" class="form-control" id="editVenue" name="venue">
                        <span class="invalid-icon" id="editVenueIcon" style="display:none;"><i class="fas fa-exclamation-circle" style="color:#dc3545;"></i></span>
                        <div id="editVenueError" class="invalid-feedback"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="editTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="editTitle" name="title">
                        <span class="invalid-icon" id="editTitleIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editTitleError" class="text-danger"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="description"></textarea>
                        <span class="invalid-icon" id="editDescriptionIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editDescriptionError" class="text-danger"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="editCalendarFormSubmit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>