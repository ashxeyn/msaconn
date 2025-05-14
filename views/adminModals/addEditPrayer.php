<div class="modal fade" id="addEditPrayerModal" tabindex="-1" aria-labelledby="addEditPrayerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editPrayerForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Prayer Schedule</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="prayer_id" id="editPrayerId">
                    <div class="mb-3 position-relative">
                        <label for="editTime" class="form-label">Time</label>
                        <input type="time" class="form-control" id="editTime" name="time">
                        <span class="invalid-icon" id="editTimeIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editTimeError" class="text-danger"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="editDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="editDate" name="date">
                        <span class="invalid-icon" id="editDateIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editDateError" class="text-danger"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="editTopic" class="form-label">Topic</label>
                        <input type="text" class="form-control" id="editTopic" name="topic">
                        <span class="invalid-icon" id="editTopicIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editTopicError" class="text-danger"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="editSpeaker" class="form-label">Speaker</label>
                        <input type="text" class="form-control" id="editSpeaker" name="speaker" placeholder="Speaker name or TBA">
                        <span class="invalid-icon" id="editSpeakerIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editSpeakerError" class="text-danger"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="editLocation" class="form-label">Location</label>
                        <input type="text" class="form-control" id="editLocation" name="location">
                        <span class="invalid-icon" id="editLocationIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editLocationError" class="text-danger"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="editPrayerFormSubmit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>