<div class="modal fade" id="editFileModal" tabindex="-1" aria-labelledby="editFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editFileForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit File</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="file_id" id="editFileId">
                    <div class="mb-3 position-relative">
                        <label for="editFileName" class="form-label">File Name</label>
                        <input type="text" class="form-control" id="editFileName" name="file_name">
                        <span class="invalid-icon" id="editFileNameIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editFileNameError" class="text-danger"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="editFile" class="form-label">File</label>
                        <input type="file" class="form-control" id="editFile" name="file" accept=".pdf,.docx">
                        <span class="invalid-icon" id="editFileIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editFileError" class="text-danger"></div>
                        <small class="text-muted">Only PDF and DOCX files are accepted.</small>
                        <div id="current-file-info" class="mt-2" style="display: none;">
                            <p><strong>Current file:</strong> <span id="current-file-name"></span></p>
                            <p><strong>Type:</strong> <span id="current-file-type"></span></p>
                            <p><strong>Size:</strong> <span id="current-file-size"></span></p>
                            <small class="text-muted">Upload a new file only if you want to replace the current one.</small>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="editFileFormSubmit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>