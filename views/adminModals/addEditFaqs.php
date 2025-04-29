<div class="modal fade" id="editFaqModal" tabindex="-1" aria-labelledby="editFaqModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="editFaqForm">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit FAQ</h5>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="faq_id" id="editFaqId">
                    <div class="mb-3">
                        <label for="editQuestion" class="form-label">Question</label>
                        <input type="text" class="form-control" id="editQuestion" name="question">
                        <div id="editQuestionError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editAnswer" class="form-label">Answer</label>
                        <textarea class="form-control" id="editAnswer" name="answer" rows="3"></textarea>
                        <div id="editAnswerError" class="text-danger"></div>
                    </div>
                    <div class="mb-3">
                        <label for="editCategory" class="form-label">Category</label>
                        <select class="form-control" id="editCategory" name="category">
                            <option value="">Select Category</option>
                            <option value="General Questions">General Questions</option>
                            <option value="Events and Activities">Events and Activities</option>
                            <option value="Donation and Support">Donation and Support</option>
                            <option value="Contact and Support">Contact and Support</option>
                            <option value="Other">Other</option>
                        </select>
                        <div id="editCategoryError" class="text-danger"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="editFaqFormSubmit" class="btn btn-primary">Save</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
            </div>
        </form>
    </div>
</div>