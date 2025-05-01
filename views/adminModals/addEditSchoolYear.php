<div class="modal fade" id="editSchoolYearModal" tabindex="-1" aria-labelledby="editSchoolYearModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editSchoolYearForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit School Year</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="school_year_id" id="editSchoolYearId">
                    <div class="mb-3">
                        <label for="editSchoolYear" class="form-label">School Year</label>
                        <input type="text" class="form-control" id="editSchoolYear" name="school_year" placeholder="Format: yyyy-yyyy (e.g. 2024-2025)">
                        <div id="editSchoolYearError" class="text-danger"></div>
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