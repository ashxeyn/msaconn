<div class="modal fade" id="addEditPrayerModal" tabindex="-1" aria-labelledby="addEditPrayerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="prayerForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="prayerModalTitle">Add Prayer Schedule</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="prayer_id" id="prayerId">
                    <div class="mb-3 position-relative">
                        <label for="khutbahDate" class="form-label">Date</label>
                        <input type="date" class="form-control" name="khutbah_date" id="khutbahDate">
                        <span class="invalid-icon" id="khutbahDateIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="khutbahDateError" class="text-danger"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="speaker" class="form-label">Speaker</label>
                        <input type="text" class="form-control" name="speaker" id="speaker">
                        <span class="invalid-icon" id="speakerIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="speakerError" class="text-danger"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="topic" class="form-label">Topic</label>
                        <input type="text" class="form-control" name="topic" id="topic">
                        <span class="invalid-icon" id="topicIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="topicError" class="text-danger"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="location" class="form-label">Location</label>
                        <input type="text" class="form-control" name="location" id="location">
                        <span class="invalid-icon" id="locationIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="locationError" class="text-danger"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="prayerFormSubmit">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>