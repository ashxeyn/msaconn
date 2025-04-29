<div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editEventForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Event</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="event_id" id="editEventId">
                    <div class="mb-3">
                        <label for="editDescription" class="form-label">Description</label>
                        <textarea class="form-control" id="editDescription" name="description"></textarea>
                        <div id="editDescriptionError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editImage" class="form-label">Event Image</label>
                        <input class="form-control" type="file" id="editImage" name="image">
                        <div id="editImageError" class="text-danger"></div>
                        <small class="text-muted">Leave blank to keep current image.</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="editEventFormSubmit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>
