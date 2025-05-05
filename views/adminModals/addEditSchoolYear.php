<div class="modal fade" id="editSchoolYearModal" tabindex="-1" aria-labelledby="editSchoolYearModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editSchoolYearForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit School Year</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="school_year_id" id="editSchoolYearId">
                    <div class="mb-3 position-relative">
                        <label for="editSchoolYear" class="form-label">School Year</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="editSchoolYear" name="school_year" placeholder="Format: yyyy-yyyy (e.g. 2024-2025)">
                            <span class="input-group-text">
                                <i class="fas fa-calendar-alt"></i>
                            </span>
                        </div>
                        <span class="invalid-icon" id="editSchoolYearIcon" style="display:none;"><i class="fas fa-exclamation-circle"></i></span>
                        <div id="editSchoolYearError" class="text-danger"></div>
                        <small class="text-muted">Please enter the school year in the format yyyy-yyyy</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" id="editSchoolYearFormSubmit" class="btn btn-primary">Save</button>
                </div>
            </div>
        </form>
    </div>
</div>