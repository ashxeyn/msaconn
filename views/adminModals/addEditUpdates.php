<div class="modal fade" id="editUpdateModal" tabindex="-1" aria-labelledby="editUpdateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl"> 
        <form id="editUpdateForm" enctype="multipart/form-data">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Organization Update</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="update_id" id="editUpdateId">
                    <input type="hidden" name="deleted_images" id="deletedImages" value="[]">
                    <div class="mb-3 position-relative">
                        <label for="editTitle" class="form-label">Title</label>
                        <input type="text" class="form-control" id="editTitle" name="title">
 
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="editContent" class="form-label">Content</label>
                        <textarea class="form-control" id="editContent" name="content" rows="10"></textarea>
                        <span class="invalid-icon" id="editContentIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editContentError" class="text-danger"></div>
                    </div>
                    <div class="mb-3 position-relative">
                        <label for="editImages" class="form-label">Update Images</label>
                        <div class="input-group mb-3">
                            <input class="form-control" type="file" id="editImages" name="images[]" accept="image/*" multiple>
                            <button class="btn btn-outline-secondary" type="button" id="addMoreImages">Add More</button>
                        </div>
                        <span class="invalid-icon" id="editImagesIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editImagesError" class="text-danger"></div>
                        <small class="text-muted">You can select multiple images. Leave blank to keep current images.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Selected New Images Preview</label>
                        <div id="selectedImagesPreview" class="d-flex flex-wrap gap-2">
                        </div>
                    </div>
                    
                    <div id="currentImagesContainer" class="mb-3 d-none">
                        <label class="form-label">Current Images</label>
                        <div id="currentImages" class="d-flex flex-wrap gap-2">
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="editUpdateFormSubmit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>