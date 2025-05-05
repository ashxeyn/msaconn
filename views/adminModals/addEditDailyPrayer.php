<div class="modal fade" id="editDailyPrayerModal" tabindex="-1" aria-labelledby="editDailyPrayerModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editDailyPrayerForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Prayer Schedule</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="prayer_id" id="editPrayerId">
                    <div class="mb-3 position-relative">
                        <label for="editPrayerType" class="form-label">Prayer Type</label>
                        <select class="form-control" id="editPrayerType" name="prayer_type">
                            <option value="">Select Prayer Type</option>
                            <option value="fajr">Fajr</option>
                            <option value="dhuhr">Dhuhr</option>
                            <option value="jumu'ah">Jumu'ah</option>
                            <option value="asr">Asr</option>
                            <option value="maghrib">Maghrib</option>
                            <option value="isha">Isha</option>
                        </select>
                        <span class="invalid-icon" id="editPrayerTypeIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editPrayerTypeError" class="text-danger"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="editPrayerDate" class="form-label">Date</label>
                        <input type="date" class="form-control" id="editPrayerDate" name="date">
                        <span class="invalid-icon" id="editPrayerDateIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editPrayerDateError" class="text-danger"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="editSpeaker" class="form-label">Speaker (leave empty for TBA)</label>
                        <input type="text" class="form-control" id="editSpeaker" name="speaker">
                        <span class="invalid-icon" id="editSpeakerIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editSpeakerError" class="text-danger"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="editTopic" class="form-label">Topic</label>
                        <input type="text" class="form-control" id="editTopic" name="topic">
                        <span class="invalid-icon" id="editTopicIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editTopicError" class="text-danger"></div>
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
                    <button type="submit" id="editDailyPrayerFormSubmit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>