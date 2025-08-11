document.addEventListener('DOMContentLoaded', function() {
    const selects = document.querySelectorAll('.modal .form-select');
    
    selects.forEach(select => {
        select.addEventListener('change', function() {
            this.blur(); 
        });
        
        document.addEventListener('click', function(e) {
            if (!select.contains(e.target)) {
                select.blur();
            }
        });
    });
});

// GENERAL FUNCTIONS
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview-img').src = e.target.result;
            document.getElementById('image-preview').style.display = 'flex';
        };
        reader.readAsDataURL(file);
    }
}

function removeImage() {
    document.getElementById('image').value = ""; 
    document.getElementById('image-preview').style.display = 'none'; 
}

function viewPhoto(photoName, folder) {
    $('.modal').modal('hide'); 
    setTimeout(() => {
        const modal = $('#photoModal');
        modal.attr({
            'aria-hidden': 'false'
        });
        $('#modalPhoto').attr('src', `../../assets/${folder}/${photoName}`);
        modal.modal('show'); 
    }, 300);
}

function clearValidationErrors() {
    $('.error-message').text('');
}


function showToast(title, message, type) {
    const toastHTML = `
        <div class="toast align-items-center text-white bg-${type} border-0" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="d-flex">
                <div class="toast-body">
                    <strong>${title}</strong>: ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
        </div>
    `;
    
    const toastContainer = document.getElementById('toastContainer');
    if (!toastContainer) {
        const container = document.createElement('div');
        container.id = 'toastContainer';
        container.className = 'toast-container position-fixed bottom-0 end-0 p-3';
        document.body.appendChild(container);
    }
    
    $('#toastContainer').append(toastHTML);
    const toastElement = $('.toast').last();
    const toast = new bootstrap.Toast(toastElement, { autohide: true, delay: 3000 });
    toast.show();
    
    setTimeout(() => {
        toastElement.remove();
    }, 3500);
}

document.getElementById('searchOrgUpdates').addEventListener('input', function() {
    const searchTerm = this.value.toLowerCase();
    const cards = document.querySelectorAll('#orgUpdatesContainer .col-md-4');
    
    cards.forEach(card => {
        const text = card.textContent.toLowerCase();
        card.style.display = text.includes(searchTerm) ? 'block' : 'none';
    });
});

// SCHOOL CONFIG FUNCTIONS
function validateProgramForm() {
    let isValid = true;
    clearProgramValidationErrors();

    const programName = $('#programName').val().trim();
    if (programName === '') {
        $('#programName').addClass('is-invalid');
        $('#programNameIcon').show();
        $('#programNameError').text('Program name is required');
        isValid = false;
    } else {
        $('#programName').removeClass('is-invalid');
        $('#programNameIcon').hide();
        $('#programNameError').text('');
    }

    const collegeSelect = $('#collegeSelect').val();
    if (collegeSelect === '') {
        $('#collegeSelect').addClass('is-invalid');
        $('#collegeSelectError').text('Please select a college');
        isValid = false;
    } else {
        $('#collegeSelect').removeClass('is-invalid');
        $('#collegeSelectError').text('');
    }

    return isValid;
}

function clearProgramValidationErrors() {
    $('#programNameError').text('');
    $('#collegeSelectError').text('');
    $('#programName').removeClass('is-invalid');
    $('#collegeSelect').removeClass('is-invalid');
    $('#programNameIcon').hide();
}

function openCollegeModal(modalId, collegeId, action) {
    $('.modal').modal('hide'); 
    $('.modal-backdrop').remove();
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.attr('aria-hidden', 'false');
        modal.modal('show'); 
        setCollegeId(collegeId, action);
    }, 300);
}

function setCollegeId(collegeId, action) {
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getCollege.php",
            type: "GET",
            data: { college_id: collegeId },
            success: function(response) {
                try {
                    const college = JSON.parse(response);
                    $('#collegeId').val(college.college_id);
                    $('#collegeName').val(college.college_name);
                    $('#collegeModalTitle').text('Edit College');
                    $('#confirmSaveCollege').text('Update College');
                    $('#addEditCollegeModal').modal('show');
                    clearValidationErrors();
                } catch (e) {
                    console.error("Invalid JSON response:", response);
                    alert("An error occurred while fetching the college data.");
                }
            },
            error: function() {
                alert("An error occurred while fetching the college data.");
            }
        });

        $('#confirmSaveCollege').off('click').on('click', function (e) {
            e.preventDefault(); 
            if (validateCollegeForm()) {
                processCollege(collegeId, 'edit');
            }
        });
    } else if (action === 'delete') {
        $('#collegeIdToDelete').val(collegeId);
        $('#deleteCollegeModal').modal('show');
        $('#confirmDeleteCollege').off('click').on('click', function () {
            const reason = $('#collegeDeleteReason').val().trim();
            if (reason === '') {
                $('#collegeDeleteReason').addClass('is-invalid');
                $('#collogeDeleteReasonIcon').show();
                $('#collegeDeleteReasonError').text('Please provide a reason for deletion');
                return;
            }
            $('#collegeDeleteReasonError').text('');
            processCollege(collegeId, 'delete');
        });
    } else if (action === 'add') {
        $('#collegeForm')[0].reset();
        $('#collegeModalTitle').text('Add College');
        $('#confirmSaveCollege').text('Add College');
        clearValidationErrors();
        $('#confirmSaveCollege').off('click').on('click', function (e) {
            e.preventDefault();
            if (validateCollegeForm()) {
                processCollege(null, 'add');
            }
        });
    } else if (action === 'restore') {
        $('#collegeIdToRestore').val(collegeId);
        $('#restoreCollegeModal').modal('show');
        $('#confirmRestoreCollege').off('click').on('click', function () {
            processCollege(collegeId, 'restore');
        });
    }
}

function validateCollegeForm() {
    let isValid = true;
    clearCollegeValidationErrors();

    const collegeName = $('#collegeName').val().trim();
    if (collegeName === '') {
        $('#collegeName').addClass('is-invalid');
        $('#collegeNameIcon').show();
        $('#collegeNameError').text('College name is required');
        isValid = false;
    } else {
        $('#collegeName').removeClass('is-invalid');
        $('#collegeNameIcon').hide();
        $('#collegeNameError').text('');
    }

    return isValid;
}

function clearCollegeValidationErrors() {
    $('#collegeNameError').text('');
    $('#collegeName').removeClass('is-invalid');
    $('#collegeNameIcon').hide();
}

function processCollege(collegeId, action) {
    let formData = new FormData();
    
    if (action === 'add' || action === 'edit') {
        formData = new FormData(document.getElementById('collegeForm'));
    } else if (action === 'delete') {
        formData.append('deleteReason', $('#collegeDeleteReason').val());
    }
    
    if (collegeId) {
        formData.append('college_id', collegeId);
    }
    formData.append('action', action);

    $.ajax({
        url: "../../handler/admin/collegeAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();
                if (action === 'restore') {
                    loadArchives();
                } else {
                    loadSchoolConfigSection();
                }
                showToast('Success', action === 'delete' ? 'College has been archived' : 
                                     action === 'restore' ? 'College has been restored' : 
                                     'College has been ' + (action === 'edit' ? 'updated' : 'added'), 'success');
            } else {
                alert("Failed to process request: " + response);
            }
        },
        error: function() {
            alert("An error occurred while processing the request.");
        }
    });
}

function openProgramModal(modalId, programId, action) {
    $('.modal').modal('hide'); 
    $('.modal-backdrop').remove();
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.attr('aria-hidden', 'false');
        modal.modal('show'); 
        setProgramId(programId, action);
    }, 300);
}

function setProgramId(programId, action) {
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getProgram.php",
            type: "GET",
            data: { program_id: programId },
            success: function(response) {
                try {
                    const program = JSON.parse(response);
                    $('#programId').val(program.program_id);
                    $('#programName').val(program.program_name);
                    $('#collegeSelect').val(program.college_id);
                    $('#programModalTitle').text('Edit Program');
                    $('#confirmSaveProgram').text('Update Program');
                    $('#addEditProgramModal').modal('show');
                    clearValidationErrors();
                } catch (e) {
                    console.error("Invalid JSON response:", response);
                    alert("An error occurred while fetching the program data.");
                }
            },
            error: function() {
                alert("An error occurred while fetching the program data.");
            }
        });

        $('#confirmSaveProgram').off('click').on('click', function (e) {
            e.preventDefault();
            if (validateProgramForm()) {
                processProgram(programId, 'edit');
            }
        });
    } else if (action === 'delete') {
        $('#programIdToDelete').val(programId);
        $('#deleteProgramModal').modal('show');
        $('#confirmDeleteProgram').off('click').on('click', function () {
            const reason = $('#programDeleteReason').val().trim();
            if (reason === '') {
                $('#programDeleteReason').addClass('is-invalid');
                $('#programDeleteReasonIcon').show();
                $('#programDeleteReasonError').text('Please provide a reason for deletion');
                return;
            }
            $('#programDeleteReasonError').text('');
            processProgram(programId, 'delete');
        });
    } else if (action === 'add') {
        $('#programForm')[0].reset();
        $('#programModalTitle').text('Add Program');
        $('#confirmSaveProgram').text('Add Program');
        clearValidationErrors();
        $('#confirmSaveProgram').off('click').on('click', function (e) {
            e.preventDefault();
            if (validateProgramForm()) {
                processProgram(null, 'add');
            }
        });
    } else if (action === 'restore') {
        $('#programIdToRestore').val(programId);
        $('#restoreProgramModal').modal('show');
        $('#confirmRestoreProgram').off('click').on('click', function () {
            processProgram(programId, 'restore');
        });
    }
}

function processProgram(programId, action) {
    let formData = new FormData();
    
    if (action === 'add' || action === 'edit') {
        formData = new FormData(document.getElementById('programForm'));
    } else if (action === 'delete') {
        formData.append('deleteReason', $('#programDeleteReason').val());
    }
    
    if (programId) {
        formData.append('program_id', programId);
    }
    formData.append('action', action);

    $.ajax({
        url: "../../handler/admin/programAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            console.log("Server response:", response);
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();
                if (action === 'restore') {
                    loadArchives();
                } else {
                    loadProgramSection();
                }
                showToast('Success', action === 'delete' ? 'Program has been archived' : 
                                     action === 'restore' ? 'Program has been restored' : 
                                     'Program has been ' + (action === 'edit' ? 'updated' : 'added'), 'success');
            } else {
                console.error("Failed to process request:", response);
                alert("Failed to process request: " + response);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX error:", status, error);
            alert("An error occurred while processing the request.");
        }
    });
}

// EVENT FUNCTIONS
function openEventModal(modalId, eventId, action) {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove(); 
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.modal('show'); 
        setEventId(eventId, action);
    }, 300);
}


function setEventId(eventId, action) {
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getEvent.php",
            type: "GET",
            data: { event_id: eventId },
            success: function(response) {
                try {
                    const event = JSON.parse(response);
                    $('#editEventId').val(event.event_id);
                    $('#editDescription').val(event.description);
                    $('#editEventModal .modal-title').text('Edit Event');
                    $('#editEventFormSubmit').text('Update Event');
                    clearValidationErrors();
                    $('#editEventModal').modal('show');
                } catch (e) {
                    console.error("Invalid JSON:", response);
                    alert("Failed to load event details.");
                }
            },
            error: function() {
                alert("Failed to load event details.");
            }
        });

        $('#editEventForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateEventForm()) {
                processEvent(eventId, 'edit');
            }
        });
    } else if (action === 'add') {
        $('#editEventForm')[0].reset();
        clearValidationErrors();
        $('#editEventModal .modal-title').text('Add Event');
        $('#editEventFormSubmit').text('Add Event');
        $('#editEventModal').modal('show');

        $('#editEventForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateEventForm()) {
                processEvent(null, 'add');
            }
        });
    } else if (action === 'delete') {
        $('#archiveEventId').val(eventId);
        $('#archiveEventModal').modal('show');
    
        $('#confirmArchiveEvent').off('click').on('click', function () {
            const reason = $('#archiveReason').val().trim();
            if (reason === '') {
                $('#archiveReasonError').text('Please provide a reason for archiving');
                return;
            }
            $('#archiveReasonError').text('');
            processEvent(eventId, 'delete');
        });    
    } else if (action === 'restore') {
        $('#restoreEventId').val(eventId);
        $('#restoreEventModal').modal('show');

        $('#restoreEventForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            processEvent(eventId, 'restore');
        });
    }
}

function validateEventForm() {
    let isValid = true;
    clearValidationErrors();

    const description = $('#editDescription').val().trim();
    const imageInput = $('#editImage')[0];
    const isEdit = $('#editEventId').val() !== "";

    if (description === '') {
        $('#editDescriptionError').text('Event description is required');
        isValid = false;
    }

    if (!isEdit) {
        if (imageInput.files.length === 0) {
            $('#editImageError').text('Event image is required');
            isValid = false;
        }
    }

    return isValid;
}

function processEvent(eventId, action) {
    let formData = new FormData();

    if (action === 'add' || action === 'edit') {
        formData = new FormData(document.getElementById('editEventForm'));
    } else if (action === 'delete') {
        formData.append('reason', $('#archiveReason').val());
    } else if (action === 'restore') {
        formData.append('event_id', $('#restoreEventId').val());
    }

    if (eventId) {
        formData.append('event_id', eventId);
    }
    formData.append('action', action);

    $.ajax({
        url: "../../handler/admin/eventAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();

                if (action === 'restore') {
                    loadArchives(); 
                } else {
                    loadEventsSection(); 
                }

                showToast('Success', 
                    action === 'delete' ? 'Event has been archived.' :
                    action === 'restore' ? 'Event has been restored.' :
                    'Event has been ' + (action === 'edit' ? 'updated' : 'added') + '.', 
                    'success');
            } else {
                alert("Failed to process request: " + response);
            }
        },
        error: function() {
            alert("An error occurred while processing the request.");
        }
    });
}

// CALENDAR FUNCTIONS
function openCalendarModal(modalId, activityId, action) {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove(); 
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.modal('show'); 
        setCalendarId(activityId, action);
    }, 300);
}

function setCalendarId(activityId, action) {
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getCalendarEvents.php",
            type: "GET",
            data: { activity_id: activityId },
            success: function(response) {
                try {
                    const activity = JSON.parse(response);
                    $('#editActivityId').val(activity.activity_id);
                    $('#editActivityDate').val(activity.activity_date);
                    $('#editEndDate').val(activity.end_date || '');
                    $('#editTime').val(activity.time || '');
                    $('#editVenue').val(activity.venue || '');
                    $('#editTitle').val(activity.title);
                    $('#editDescription').val(activity.description);
                    $('#editCalendarModal .modal-title').text('Edit Activity');
                    $('#editCalendarFormSubmit').text('Update Activity');
                    clearCalendarValidationErrors();
                    $('#editCalendarModal').modal('show');
                } catch (e) {
                    console.error("Invalid JSON:", response);
                    alert("Failed to load activity details.");
                }
            },
            error: function() {
                alert("Failed to load activity details.");
            }
        });

        $('#editCalendarForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateCalendarForm()) {
                processCalendar(activityId, 'edit');
            }
        });
    } else if (action === 'add') {
        $('#editCalendarForm')[0].reset();
        clearCalendarValidationErrors();
        $('#editCalendarModal .modal-title').text('Add Activity');
        $('#editCalendarFormSubmit').text('Add Activity');
        $('#editCalendarModal').modal('show');

        $('#editCalendarForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateCalendarForm()) {
                processCalendar(null, 'add');
            }
        });
    } else if (action === 'delete') {
        $('#archiveActivityId').val(activityId);
        $('#archiveCalendarModal').modal('show');
    
        $('#confirmArchiveActivity').off('click').on('click', function () {
            const reason = $('#archiveReason').val().trim();
            if (reason === '') {
                $('#archiveReason').addClass('is-invalid');
                $('#archiveReasonIcon').show();
                $('#archiveReasonError').text('Please provide a reason for archiving');
                return;
            }
            $('#archiveReasonError').text('');
            processCalendar(activityId, 'delete');
        });    
    } else if (action === 'restore') {
        $('#restoreActivityId').val(activityId);
        $('#restoreCalendarModal').modal('show');

        $('#restoreCalendarForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            processCalendar(activityId, 'restore');
        });
    }
}

function validateCalendarForm() {
    let isValid = true;
    clearCalendarValidationErrors();

    const activityDate = $('#editActivityDate').val().trim();
    if (activityDate === '') {
        $('#editActivityDate').addClass('is-invalid');
        $('#editActivityDateError').text('Start date is required');
        isValid = false;
    } else {
        $('#editActivityDate').removeClass('is-invalid');
        $('#editActivityDateError').text('');
    }

    const endDate = $('#editEndDate').val().trim();
    if (endDate !== '' && endDate < activityDate) {
        $('#editEndDate').addClass('is-invalid');
        $('#editEndDateError').text('End date must be after or equal to start date');
        isValid = false;
    } else {
        $('#editEndDate').removeClass('is-invalid');
        $('#editEndDateError').text('');
    }

    const time = $('#editTime').val().trim();
    if (time === '') {
        $('#editTime').addClass('is-invalid');
        $('#editTimeIcon').show();
        $('#editTimeError').text('Time is required');
    } else {
        $('#editTime').removeClass('is-invalid');
        $('#editTimeIcon').hide();
        $('#editTimeError').text('');
    }

    const venue = $('#editVenue').val().trim();
    if (venue === '') {
        $('#editVenue').addClass('is-invalid');
        $('#editVenueIcon').show();
        $('#editVenueError').text('Venue is required');
    } else {
        $('#editVenue').removeClass('is-invalid');
        $('#editVenueIcon').hide();
        $('#editVenueError').text('');
    }

    const title = $('#editTitle').val().trim();
    if (title === '') {
        $('#editTitle').addClass('is-invalid');
        $('#editTitleIcon').show();
        $('#editTitleError').text('Title is required');
        isValid = false;
    } else {
        $('#editTitle').removeClass('is-invalid');
        $('#editTitleIcon').hide();
        $('#editTitleError').text('');
    }

    const description = $('#editDescription').val().trim();
    if (description === '') {
        $('#editDescription').addClass('is-invalid');
        $('#editDescriptionIcon').show();
        $('#editDescriptionError').text('Description is required');
        isValid = false;
    } else {
        $('#editDescription').removeClass('is-invalid');
        $('#editDescriptionIcon').hide();
        $('#editDescriptionError').text('');
    }

    return isValid;
}

function clearCalendarValidationErrors() {
    $('#editActivityDateError').text('');
    $('#editEndDateError').text('');
    $('#editTimeError').text('');
    $('#editVenueError').text('');
    $('#editTitleError').text('');
    $('#editDescriptionError').text('');
    $('#editActivityDate').removeClass('is-invalid');
    $('#editEndDate').removeClass('is-invalid');
    $('#editTime').removeClass('is-invalid');
    $('#editVenue').removeClass('is-invalid');
    $('#editTitle').removeClass('is-invalid');
    $('#editDescription').removeClass('is-invalid');
    $('#editTitleIcon').hide();
    $('#editDescriptionIcon').hide();
    $('#editTimeIcon').hide();
    $('#editVenueIcon').hide();
}

function processCalendar(activityId, action) {
    const data = {
        action: action,
        activity_id: activityId,
        activity_date: $('#editActivityDate').val(),
        end_date: $('#editEndDate').val(),
        time: $('#editTime').val(),
        venue: $('#editVenue').val(),
        title: $('#editTitle').val(),
        description: $('#editDescription').val()
    };

    // Add reason for delete action
    if (action === 'delete') {
        data.reason = $('#archiveReason').val();
    }

    $.ajax({
        url: '../../handler/admin/calendarAction.php',
        type: 'POST',
        data: data,
        success: function(response) {
            if (response.trim() === 'success') {
                showToast('Success', 'Calendar event updated.', 'success');
                if (typeof loadCalendarSection === 'function') {
                    $(".modal").modal("hide");
                    $("body").removeClass("modal-open");
                    $(".modal-backdrop").remove();
                    loadCalendarSection();
                } else {
                    location.reload();
                }
            } else if (response.trim() === 'error: time_venue_required') {
                if ($('#editTime').val().trim() === '') {
                    $('#editTime').addClass('is-invalid');
                    $('#editTimeIcon').show();
                    $('#editTimeError').text('Time is required');
                }
                if ($('#editVenue').val().trim() === '') {
                    $('#editVenue').addClass('is-invalid');
                    $('#editVenueIcon').show();
                    $('#editVenueError').text('Venue is required');
                }
            } else if (response.trim() === 'error: end_date_before_start') {
                $('#editEndDate').addClass('is-invalid');
                $('#editEndDateError').text('End date must be after or equal to start date');
            } else if (response.trim() === 'error: reason_required') {
                $('#archiveReason').addClass('is-invalid');
                $('#archiveReasonIcon').show();
                $('#archiveReasonError').text('Please provide a reason for archiving');
            } else {
                showToast('Error', 'Failed to update calendar event.', 'danger');
            }
        },
        error: function() {
            showToast('Error', 'Failed to update calendar event.', 'danger');
        }
    });
}

// PRAYER SCHEDULE FUNCTIONS
function openPrayerModal(modalId, prayerId, action) {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove(); 
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.modal('show'); 
        setPrayerId(prayerId, action);
    }, 300);
}

function setPrayerId(prayerId, action) {
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getPrayerSched.php",
            type: "GET",
            data: { prayer_id: prayerId },
            success: function(response) {
                try {
                    const prayer = JSON.parse(response);
                    $('#editPrayerId').val(prayer.prayer_id);
                    $('#editDate').val(prayer.date);
                    $('#editTime').val(prayer.time);
                    $('#editTopic').val(prayer.topic);
                    $('#editSpeaker').val(prayer.speaker);
                    $('#editLocation').val(prayer.location);
                    $('#addEditPrayerModal .modal-title').text('Edit Prayer Schedule');
                    $('#editPrayerFormSubmit').text('Update Prayer Schedule');
                    clearPrayerValidationErrors();
                    $('#addEditPrayerModal').modal('show');
                } catch (e) {
                    console.error("Invalid JSON:", response);
                    alert("Failed to load prayer schedule details.");
                }
            },
            error: function() {
                alert("Failed to load prayer schedule details.");
            }
        });

        $('#editPrayerForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validatePrayerForm()) {
                processPrayer(prayerId, 'edit');
            }
        });
    } else if (action === 'add') {
        $('#editPrayerForm')[0].reset();
        clearPrayerValidationErrors();
        $('#addEditPrayerModal .modal-title').text('Add Prayer Schedule');
        $('#editPrayerFormSubmit').text('Add Prayer Schedule');
        $('#addEditPrayerModal').modal('show');

        $('#editPrayerForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validatePrayerForm()) {
                processPrayer(null, 'add');
            }
        });
    } else if (action === 'delete') {
        $('#deletePrayerId').val(prayerId);
        $('#deletePrayerModal').modal('show');
    
        $('#confirmDeletePrayer').off('click').on('click', function () {
            const reason = $('#deleteReason').val().trim();
            if (reason === '') {
                $('#deleteReason').addClass('is-invalid');
                $('#deleteReasonIcon').show();
                $('#deleteReasonError').text('Please provide a reason for archiving');
                return;
            }
            $('#deleteReasonError').text('');
            processPrayer(prayerId, 'delete');
        });    
    } else if (action === 'restore') {
        $('#restorePrayerId').val(prayerId);
        $('#restorePrayerModal').modal('show');

        $('#restorePrayerForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            processPrayer(prayerId, 'restore');
        });
    }
}

function validatePrayerForm() {
    let isValid = true;
    clearPrayerValidationErrors();

    const time = $('#editTime').val().trim();
    if (time === '') {
        $('#editTime').addClass('is-invalid');
        $('#editTimeIcon').show();
        $('#editTimeError').text('Time is required');
        isValid = false;
    } else {
        $('#editTime').removeClass('is-invalid');
        $('#editTimeIcon').hide();
        $('#editTimeError').text('');
    }

    const date = $('#editDate').val().trim();
    if (date === '') {
        $('#editDate').addClass('is-invalid');
        $('#editDateIcon').show();
        $('#editDateError').text('Date is required');
        isValid = false;
    } else {
        const selectedDate = new Date(date);
        if (selectedDate.getDay() !== 5) { 
            $('#editDate').addClass('is-invalid');
            $('#editDateIcon').show();
            $('#editDateError').text('Date must be a Friday');
            isValid = false;
        } else {
            $('#editDate').removeClass('is-invalid');
            $('#editDateIcon').hide();
            $('#editDateError').text('');
        }
    }

    const topic = $('#editTopic').val().trim();
    if (topic === '') {
        $('#editTopic').addClass('is-invalid');
        $('#editTopicIcon').show();
        $('#editTopicError').text('Topic is required');
        isValid = false;
    } else {
        $('#editTopic').removeClass('is-invalid');
        $('#editTopicIcon').hide();
        $('#editTopicError').text('');
    }

    const speaker = $('#editSpeaker').val().trim();
    if (speaker === '') {
        $('#editSpeaker').addClass('is-invalid');
        $('#editSpeakerIcon').show();
        $('#editSpeakerError').text('Speaker is required');
        isValid = false;
    } else {
        $('#editSpeaker').removeClass('is-invalid');
        $('#editSpeakerIcon').hide();
        $('#editSpeakerError').text('');
    }

    const location = $('#editLocation').val().trim();
    if (location === '') {
        $('#editLocation').addClass('is-invalid');
        $('#editLocationIcon').show();
        $('#editLocationError').text('Location is required');
        isValid = false;
    } else {
        $('#editLocation').removeClass('is-invalid');
        $('#editLocationIcon').hide();
        $('#editLocationError').text('');
    }

    return isValid;
}

function clearPrayerValidationErrors() {
    $('#editDateError').text('');
    $('#editTimeError').text('');
    $('#editTopicError').text('');
    $('#editSpeakerError').text('');
    $('#editLocationError').text('');
    $('#editDate').removeClass('is-invalid');
    $('#editTime').removeClass('is-invalid');
    $('#editTopic').removeClass('is-invalid');
    $('#editSpeaker').removeClass('is-invalid');
    $('#editLocation').removeClass('is-invalid');
    $('#editDateIcon').hide();
    $('#editTimeIcon').hide();
    $('#editTopicIcon').hide();
    $('#editSpeakerIcon').hide();
    $('#editLocationIcon').hide();
}

function processPrayer(prayerId, action) {
    let formData = new FormData();

    if (action === 'add' || action === 'edit') {
        formData = new FormData(document.getElementById('editPrayerForm'));
    } else if (action === 'delete') {
        formData.append('reason', $('#deleteReason').val());
    } else if (action === 'restore') {
        formData.append('prayer_id', $('#restorePrayerId').val());
    }

    if (prayerId) {
        formData.append('prayer_id', prayerId);
    }
    formData.append('action', action);

    $.ajax({
        url: "../../handler/admin/prayerAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();

                if (action === 'restore') {
                    loadArchives(); 
                } else {
                    loadPrayerSchedSection(); 
                }

                showToast('Success', 
                    action === 'delete' ? 'Prayer schedule has been archived.' :
                    action === 'restore' ? 'Prayer schedule has been restored.' :
                    'Prayer schedule has been ' + (action === 'edit' ? 'updated' : 'added') + '.', 
                    'success');
            } else {
                alert("Failed to process request: " + response);
            }
        },
        error: function() {
            alert("An error occurred while processing the request.");
        }
    });
}

// TRANSPARENCY FUNCTIONS
function openTransactionModal(modalId, reportId, action, transactionType) {
    $('.modal').modal('hide'); 
    $('.modal-backdrop').remove();
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.attr('aria-hidden', 'false');
        modal.modal('show'); 
        setTransactionId(reportId, action, transactionType);
    }, 300);
}

function setTransactionId(reportId, action, transactionType) {
    clearTransactionValidationErrors();
    
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getTransparency.php",
            type: "GET",
            data: { 
                action: 'get_transaction',
                report_id: reportId 
            },
            success: function(response) {
                const transaction = JSON.parse(response);
                
                if (transactionType === 'Cash In') {
                    $('#reportId').val(transaction.report_id);
                    $('#cashInDate').val(transaction.report_date);
                    $('#cashInEndDate').val(transaction.end_date || '');
                    $('#cashInDetail').val(transaction.expense_detail);
                    $('#cashInCategory').val(transaction.expense_category);
                    $('#cashInAmount').val(transaction.amount);
                    $('#cashInSemester').val(transaction.semester);
                    $('#cashInSchoolYearId').val(transaction.school_year_id);
                    $('#cashInModalTitle').text('Edit Cash-In');
                    $('#confirmSaveCashIn').text('Update Cash-In');
                    
                    $('#cashInForm').off('submit').on('submit', function(e) {
                        e.preventDefault();
                        if (validateCashForm('In')) {
                            processTransaction(reportId, 'edit', 'cash_in');
                        }
                    });
                } else {
                    $('#reportIdOut').val(transaction.report_id);
                    $('#cashOutDate').val(transaction.report_date);
                    $('#cashOutEndDate').val(transaction.end_date || '');
                    $('#cashOutDetail').val(transaction.expense_detail);
                    $('#cashOutCategory').val(transaction.expense_category);
                    $('#cashOutAmount').val(transaction.amount);
                    $('#cashOutSemester').val(transaction.semester);
                    $('#cashOutSchoolYearId').val(transaction.school_year_id);
                    $('#cashOutModalTitle').text('Edit Cash-Out');
                    $('#confirmSaveCashOut').text('Update Cash-Out');
                    
                    $('#cashOutForm').off('submit').on('submit', function(e) {
                        e.preventDefault();
                        if (validateCashForm('Out')) {
                            processTransaction(reportId, 'edit', 'cash_out');
                        }
                    });
                }
            },
            error: function() {
                alert("An error occurred while fetching the transaction data.");
            }
        });
    } else if (action === 'delete') {
        if (transactionType === 'Cash In') {
            $('#archiveCashInId').val(reportId);
            $('#archiveCashInModal').modal('show');
            
            $('#confirmArchiveCashIn').off('click').on('click', function() {
                const reason = $('#archiveCashInReason').val().trim();
                if (reason === '') {
                    $('#archiveCashInReason').addClass('is-invalid');
                    $('#archiveCashInReasonIcon').show();
                    $('#archiveCashInReasonError').text('Please provide a reason for archiving');
                    return;
                }
                $('#archiveCashInReasonError').text('');
                processTransaction(reportId, 'delete', 'cash_in');
            });
        } else {
            $('#archiveCashOutId').val(reportId);
            $('#archiveCashOutModal').modal('show');
            
            $('#confirmArchiveCashOut').off('click').on('click', function() {
                const reason = $('#archiveCashOutReason').val().trim();
                if (reason === '') {
                    $('#archiveCashOutReason').addClass('is-invalid');
                    $('#archiveCashOutReasonIcon').show();
                    $('#archiveCashOutReasonError').text('Please provide a reason for archiving');
                    return;
                }
                $('#archiveCashOutReasonError').text('');
                processTransaction(reportId, 'delete', 'cash_out');
            });
        }
    } else if (action === 'restore') {
        $('#restoreTransactionId').val(reportId);
        $('#restoreTransactionType').val(transactionType === 'Cash In' ? 'cash_in' : 'cash_out');
        $('#restoreTransactionModal').modal('show');
    
        $('#restoreTransactionForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            processTransaction(reportId, 'restore', $('#restoreTransactionType').val());
        });
    } else if (action === 'add') {
        if (transactionType === 'Cash In') {
            $('#cashInForm')[0].reset();
            $('#reportId').val('');
            $('#cashInSchoolYearId').val($('#schoolYearSelect').val());
            $('#cashInSemester').val($('#semesterSelect').val());
            $('#cashInModalTitle').text('Add Cash-In');
            $('#confirmSaveCashIn').text('Add Cash-In');
            
            $('#cashInForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                if (validateCashForm('In')) {
                    processTransaction(null, 'add', 'cash_in');
                }
            });
        } else {
            $('#cashOutForm')[0].reset();
            $('#reportIdOut').val('');
            $('#cashOutSchoolYearId').val($('#schoolYearSelect').val());
            $('#cashOutSemester').val($('#semesterSelect').val());
            $('#cashOutModalTitle').text('Add Cash-Out');
            $('#confirmSaveCashOut').text('Add Cash-Out');
            
            $('#cashOutForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                if (validateCashForm('Out')) {
                    processTransaction(null, 'add', 'cash_out');
                }
            });
        }
    }
}

function validateCashForm(type) {
    let isValid = true;
    clearCashValidationErrors(type);

    const date = $(`#cash${type}Date`).val().trim();
    if (date === '') {
        $(`#cash${type}Date`).addClass('is-invalid');
        $(`#cash${type}DateError`).text('Start date is required');
        isValid = false;
    } else {
        $(`#cash${type}Date`).removeClass('is-invalid');
        $(`#cash${type}DateError`).text('');
    }
    
    const endDate = $(`#cash${type}EndDate`).val().trim();
    if (endDate !== '' && date !== '') {
        if (new Date(endDate) < new Date(date)) {
            $(`#cash${type}EndDate`).addClass('is-invalid');
            $(`#cash${type}EndDateError`).text('End date must be after or equal to start date');
            isValid = false;
        } else {
            $(`#cash${type}EndDate`).removeClass('is-invalid');
            $(`#cash${type}EndDateError`).text('');
        }
    } else {
        $(`#cash${type}EndDate`).removeClass('is-invalid');
        $(`#cash${type}EndDateError`).text('');
    }

    const detail = $(`#cash${type}Detail`).val().trim();
    if (detail === '') {
        $(`#cash${type}Detail`).addClass('is-invalid');
        $(`#cash${type}DetailIcon`).show();
        $(`#cash${type}DetailError`).text('Detail is required');
        isValid = false;
    } else {
        $(`#cash${type}Detail`).removeClass('is-invalid');
        $(`#cash${type}DetailIcon`).hide();
        $(`#cash${type}DetailError`).text('');
    }

    const category = $(`#cash${type}Category`).val().trim();
    if (category === '') {
        $(`#cash${type}Category`).addClass('is-invalid');
        $(`#cash${type}CategoryIcon`).show();
        $(`#cash${type}CategoryError`).text('Category is required');
        isValid = false;
    } else {
        $(`#cash${type}Category`).removeClass('is-invalid');
        $(`#cash${type}CategoryIcon`).hide();
        $(`#cash${type}CategoryError`).text('');
    }

    const amount = $(`#cash${type}Amount`).val().trim();
    if (amount === '') {
        $(`#cash${type}Amount`).addClass('is-invalid');
        $(`#cash${type}AmountIcon`).show();
        $(`#cash${type}AmountError`).text('Amount is required');
        isValid = false;
    } else if (parseFloat(amount) <= 0) {
        $(`#cash${type}Amount`).addClass('is-invalid');
        $(`#cash${type}AmountIcon`).show();
        $(`#cash${type}AmountError`).text('Amount must be greater than zero');
        isValid = false;
    } else {
        $(`#cash${type}Amount`).removeClass('is-invalid');
        $(`#cash${type}AmountIcon`).hide();
        $(`#cash${type}AmountError`).text('');
    }

    const semester = $(`#cash${type}Semester`).val();
    if (!semester) {
        $(`#cash${type}Semester`).addClass('is-invalid');
        $(`#cash${type}Semester`).siblings('.invalid-feedback, .text-danger').text('Semester is required');
        isValid = false;
    } else {
        $(`#cash${type}Semester`).removeClass('is-invalid');
        $(`#cash${type}Semester`).siblings('.invalid-feedback, .text-danger').text('');
    }

    return isValid;
}

function clearCashValidationErrors(type) {
    $(`#cash${type}DateError`).text('');
    $(`#cash${type}EndDateError`).text('');
    $(`#cash${type}DetailError`).text('');
    $(`#cash${type}CategoryError`).text('');
    $(`#cash${type}AmountError`).text('');
    $(`#cash${type}Date`).removeClass('is-invalid');
    $(`#cash${type}EndDate`).removeClass('is-invalid');
    $(`#cash${type}Detail`).removeClass('is-invalid');
    $(`#cash${type}Category`).removeClass('is-invalid');
    $(`#cash${type}Amount`).removeClass('is-invalid');
    $(`#cash${type}DetailIcon`).hide();
    $(`#cash${type}CategoryIcon`).hide();
    $(`#cash${type}AmountIcon`).hide();
    $(`#cash${type}Semester`).removeClass('is-invalid');
    $(`#cash${type}Semester`).siblings('.invalid-feedback, .text-danger').text('');
}

function clearTransactionValidationErrors() {
    $('#cashInDateError').text('');
    $('#cashInEndDateError').text('');
    $('#cashInDetailError').text('');
    $('#cashInCategoryError').text('');
    $('#cashInAmountError').text('');
    
    $('#cashOutDateError').text('');
    $('#cashOutEndDateError').text('');
    $('#cashOutDetailError').text('');
    $('#cashOutCategoryError').text('');
    $('#cashOutAmountError').text('');
    
    $('#archiveCashInReasonError').text('');
    $('#archiveCashOutReasonError').text('');
}

function processTransaction(reportId, action, type) {
    let formData = new FormData();
    
    if (action === 'delete') {
        formData.append('action', action);
        formData.append('type', type);
        formData.append('report_id', reportId);
        if (type === 'cash_in') {
            formData.append('reason', $('#archiveCashInReason').val());
        } else {
            formData.append('reason', $('#archiveCashOutReason').val());
        }
    } else if (action === 'restore') {
        formData.append('action', action);
        formData.append('type', type);
        formData.append('report_id', reportId);
    } else {
        if (type === 'cash_in') {
            formData = new FormData(document.getElementById('cashInForm'));
        } else {
            formData = new FormData(document.getElementById('cashOutForm'));
        }
        
        if (reportId) {
            formData.append('report_id', reportId);
        }
        formData.append('action', action);
        formData.append('type', type);
    }

    $.ajax({
        url: "../../handler/admin/transparencyAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();
                
                if (action === 'restore') {
                    if (type === 'cash_in') {
                        loadArchives();
                    } else {
                        loadArchives();
                    }
                } else {
                    loadTransparencySection();
                }

                showToast('Success', 
                    action === 'delete' ? 'Transaction has been archived.' :
                    action === 'restore' ? 'Transaction has been restored.' :
                    'Transaction has been ' + (action === 'edit' ? 'updated' : 'added') + '.', 
                    'success');
            } else {
                console.log(response);
                alert("Failed to process request: " + response);
            }
        },
        error: function() {
            alert("An error occurred while processing the request.");
        }
    });
}


// Transparency Filter Functions

function initDatepickers() {
    $('.input-group.date').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true,
        zIndexOffset: 1000 
    });
}

$(document).ready(function() {
    initDatepickers();

    $(document).on('change', '.filter-control, .filter-date', function() {
        applyFilters();
    });

    $(document).on('click', '#clearDates', function() {
        $('#startDate').val('');
        $('#endDate').val('');
        applyFilters();
    });
});

function applyFilters() {
    const schoolYearId = $('#schoolYearSelect').val();
    const semester = $('#semesterSelect').val();
    const startDate = $('#startDate').val();
    const endDate = $('#endDate').val();

    const params = {};
    if (schoolYearId) params.school_year_id = schoolYearId;
    if (semester) params.semester = semester;
    if (startDate) params.start_date = startDate;
    if (endDate) params.end_date = endDate;

    loadFilteredTransparencySection(params);
}

function loadFilteredTransparencySection(params) {
    $.ajax({
        url: "../admin/transparency.php",
        method: 'GET',
        data: params,
        success: function (response) {
            $('#contentArea').html(response);
            initDatepickers(); 
        },
        error: function (xhr, status, error) {
            console.error('Error loading transparency section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Transparency section. Please try again.</p>');
        }
    });
}

// FAQS FUNCTIONS
function openFaqModal(modalId, faqId, action) {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove();
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.attr('aria-hidden', 'false');
        modal.modal('show');
        setFaqId(faqId, action);
    }, 300);
}

function setFaqId(faqId, action) {
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getFaq.php",
            type: "GET",
            data: { faq_id: faqId },
            success: function(response) {
                try {
                    const faq = JSON.parse(response);
                    $('#editFaqId').val(faq.faq_id);
                    $('#editQuestion').val(faq.question);
                    $('#editAnswer').val(faq.answer);
                    $('#editCategory').val(faq.category);
                    $('#editFaqModal .modal-title').text('Edit FAQ');
                    $('#editFaqFormSubmit').text('Update FAQ');
                    clearValidationErrors();
                    $('#editFaqModal').modal('show');
                } catch (e) {
                    console.error("Invalid JSON:", response);
                    alert("Failed to load FAQ details.");
                }
            },
            error: function() {
                alert("Failed to load FAQ details.");
            }
        });

        $('#editFaqForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateFaqForm()) {
                processFaq(faqId, 'edit');
            }
        });
    } else if (action === 'add') {
        $('#editFaqForm')[0].reset();
        clearValidationErrors();
        $('#editFaqModal .modal-title').text('Add FAQ');
        $('#editFaqFormSubmit').text('Add FAQ');
        $('#editFaqModal').modal('show');

        $('#editFaqForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateFaqForm()) {
                processFaq(null, 'add');
            }
        });
    } else if (action === 'delete') {
        $('#archiveFaqId').val(faqId);
        $('#archiveFaqModal').modal('show');
    
        $('#confirmArchiveFaq').off('click').on('click', function () {
            const reason = $('#archiveReason').val().trim();
            if (reason === '') {
                $('#archiveReason').addClass('is-invalid');
                $('#archiveReasonIcon').show();
                $('#archiveReasonError').text('Please provide a reason for archiving');
                return;
            }
            $('#archiveReasonError').text('');
            processFaq(faqId, 'delete');
        });    
    } else if (action === 'restore') {
        $('#restoreFaqId').val(faqId);
        $('#restoreFaqModal').modal('show');

        $('#restoreFaqForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            processFaq(faqId, 'restore');
        });
    }
}

function validateFaqForm() {
    let isValid = true;
    clearFaqValidationErrors();

    const question = $('#editQuestion').val().trim();
    const answer = $('#editAnswer').val().trim();
    const category = $('#editCategory').val();

    if (question === '') {
        $('#editQuestion').addClass('is-invalid');
        $('#editQuestionIcon').show();
        $('#editQuestionError').text('Question is required');
        isValid = false;
    } else {
        $('#editQuestion').removeClass('is-invalid');
        $('#editQuestionIcon').hide();
        $('#editQuestionError').text('');
    }

    if (answer === '') {
        $('#editAnswer').addClass('is-invalid');
        $('#editAnswerIcon').show();
        $('#editAnswerError').text('Answer is required');
        isValid = false;
    } else {
        $('#editAnswer').removeClass('is-invalid');
        $('#editAnswerIcon').hide();
        $('#editAnswerError').text('');
    }

    if (category === '') {
        $('#editCategory').addClass('is-invalid');
        $('#editCategoryError').text('Category is required');
        isValid = false;
    } else {
        $('#editCategory').removeClass('is-invalid');
        $('#editCategoryError').text('');
    }

    return isValid;
}

function clearFaqValidationErrors() {
    $('#editQuestionError').text('');
    $('#editAnswerError').text('');
    $('#editCategoryError').text('');
    $('#editQuestion').removeClass('is-invalid');
    $('#editAnswer').removeClass('is-invalid');
    $('#editCategory').removeClass('is-invalid');
    $('#editQuestionIcon').hide();
    $('#editAnswerIcon').hide();
}

function clearValidationErrors() {
    $('#editQuestionError').text('');
    $('#editAnswerError').text('');
    $('#editCategoryError').text('');
    $('#archiveReasonError').text('');
}

function processFaq(faqId, action) {
    let formData = new FormData();

    if (action === 'add' || action === 'edit') {
        formData = new FormData(document.getElementById('editFaqForm'));
    } else if (action === 'delete') {
        formData.append('reason', $('#archiveReason').val());
    } else if (action === 'restore') {
        formData.append('faq_id', $('#restoreFaqId').val());
    }

    if (faqId) {
        formData.append('faq_id', faqId);
    }
    formData.append('action', action);

    $.ajax({
        url: "../../handler/admin/faqsAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();

                if (action === 'restore') {
                    loadArchives(); 
                } else {
                    loadFaqsSection(); 
                }

                showToast('Success', 
                    action === 'delete' ? 'FAQ has been archived.' :
                    action === 'restore' ? 'FAQ has been restored.' :
                    'FAQ has been ' + (action === 'edit' ? 'updated' : 'added') + '.', 
                    'success');
            } else {
                alert("Failed to process request: " + response);
            }
        },
        error: function() {
            alert("An error occurred while processing the request.");
        }
    });
}

// ABOUTS FUNCTIONS
function openAboutModal(modalId, aboutId, action) {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove(); 
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.modal('show'); 
        setAboutId(aboutId, action);
    }, 300);
}

function setAboutId(aboutId, action) {
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getAbouts.php",
            type: "GET",
            data: { id: aboutId },
            success: function(response) {
                try {
                    const about = JSON.parse(response);
                    $('#editAboutId').val(about.id);
                    $('#editMission').val(about.mission);
                    $('#editVision').val(about.vision);
                    $('#editAboutModal .modal-title').text('Edit About MSA');
                    $('#editAboutFormSubmit').text('Update About');
                    clearValidationErrors();
                    $('#editAboutModal').modal('show');
                } catch (e) {
                    console.error("Invalid JSON:", response);
                    alert("Failed to load about details.");
                }
            },
            error: function() {
                alert("Failed to load about details.");
            }
        });

        $('#editAboutForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateAboutForm()) {
                processAbout(aboutId, 'edit');
            }
        });
    } else if (action === 'add') {
        $('#editAboutForm')[0].reset();
        clearValidationErrors();
        $('#editAboutModal .modal-title').text('Add About MSA');
        $('#editAboutFormSubmit').text('Add About');
        $('#editAboutModal').modal('show');

        $('#editAboutForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateAboutForm()) {
                processAbout(null, 'add');
            }
        });
    } else if (action === 'delete') {
        $('#archiveAboutId').val(aboutId);
        $('#archiveAboutModal').modal('show');
    
        $('#confirmArchiveAbout').off('click').on('click', function () {
            const reason = $('#archiveReason').val().trim();
            if (reason === '') {
                $('#archiveReason').addClass('is-invalid');
                $('#archiveReasonIcon').show();
                $('#archiveReasonError').text('Please provide a reason for archiving');
                return;
            }
            $('#archiveReasonError').text('');
            processAbout(aboutId, 'delete');
        });    
    } else if (action === 'restore') {
        $('#restoreAboutId').val(aboutId);
        $('#restoreAboutModal').modal('show');

        $('#restoreAboutForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            processAbout(aboutId, 'restore');
        });
    }
}

function validateAboutForm() {
    let isValid = true;
    clearAboutValidationErrors();

    const mission = $('#editMission').val().trim();
    const vision = $('#editVision').val().trim();

    if (mission === '') {
        $('#editMission').addClass('is-invalid');
        $('#editMissionIcon').show();
        $('#editMissionError').text('Mission statement is required');
        isValid = false;
    } else {
        $('#editMission').removeClass('is-invalid');
        $('#editMissionIcon').hide();
        $('#editMissionError').text('');
    }

    if (vision === '') {
        $('#editVision').addClass('is-invalid');
        $('#editVisionIcon').show();
        $('#editVisionError').text('Vision statement is required');
        isValid = false;
    } else {
        $('#editVision').removeClass('is-invalid');
        $('#editVisionIcon').hide();
        $('#editVisionError').text('');
    }

    return isValid;
}

function clearAboutValidationErrors() {
    $('#editMissionError').text('');
    $('#editVisionError').text('');
    $('#editMission').removeClass('is-invalid');
    $('#editVision').removeClass('is-invalid');
    $('#editMissionIcon').hide();
    $('#editVisionIcon').hide();
}

function processAbout(aboutId, action) {
    let formData = new FormData();

    if (action === 'add' || action === 'edit') {
        formData = new FormData(document.getElementById('editAboutForm'));
    } else if (action === 'delete') {
        formData.append('reason', $('#archiveReason').val());
    } else if (action === 'restore') {
        formData.append('id', $('#restoreAboutId').val());
    }

    if (aboutId) {
        formData.append('id', aboutId);
    }
    formData.append('action', action);

    $.ajax({
        url: "../../handler/admin/aboutsAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();

                if (action === 'restore') {
                    loadArchives(); 
                } else {
                    loadAboutsSection(); 
                }

                showToast('Success', 
                    action === 'delete' ? 'About information has been archived.' :
                    action === 'restore' ? 'About information has been restored.' :
                    'About information has been ' + (action === 'edit' ? 'updated' : 'added') + '.', 
                    'success');
            } else {
                alert("Failed to process request: " + response);
            }
        },
        error: function() {
            alert("An error occurred while processing the request.");
        }
    });
}

// DOWNLOADS FUNCTIONS
function openFileModal(modalId, fileId, action) {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove();
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.modal('show');
        modal.modal('show'); 
        setFileId(fileId, action);
    }, 300);
}


function setFileId(fileId, action) {
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getFile.php",
            type: "GET",
            data: { file_id: fileId },
            success: function(response) {
                try {
                    const file = JSON.parse(response);
                    $('#editFileId').val(file.file_id);
                    $('#editFileName').val(file.file_name);
                    $('#editFileModal .modal-title').text('Edit File');
                    $('#editFileFormSubmit').text('Update File');
                    clearValidationErrors();
                    
                    $('#current-file-info').show();
                    $('#current-file-name').text(file.file_name);

                    let fileType = file.file_type;
                    if (fileType === 'application/pdf') {
                        fileType = 'PDF';
                    } else if (fileType === 'application/vnd.openxmlformats-officedocument.wordprocessingml.document') {
                        fileType = 'DOCX';
                    }

                    $('#current-file-type').text(fileType);
                    $('#current-file-size').text(formatFileSize(file.file_size));
                    $('#editFileModal').modal('show');
                } catch (e) {
                    console.error("Invalid JSON:", response);
                    alert("Failed to load file details.");
                }
            },
            error: function() {
                alert("Failed to load file details.");
            }
        });

        $('#editFileForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateFileForm()) {
                processFile(fileId, 'edit');
            }
        });
    } else if (action === 'add') {
        $('#editFileForm')[0].reset();
        clearValidationErrors();
        $('#editFileModal .modal-title').text('Add File');
        $('#editFileFormSubmit').text('Add File');
        $('#current-file-info').hide();
        $('#editFileModal').modal('show');
        
        $('#editFileForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateFileForm()) {
                processFile(null, 'add');
            }
        });
    } else if (action === 'delete') {
        $('#archiveFileId').val(fileId);
        $('#archiveFileModal').modal('show');
    
        $('#confirmArchiveFile').off('click').on('click', function () {
            const reason = $('#archiveReason').val().trim();
            if (reason === '') {
                $('#archiveReason').addClass('is-invalid');
                $('#archiveReasonIcon').show();
                $('#archiveReasonError').text('Please provide a reason for archiving');
                return;
            }
            $('#archiveReasonError').text('');
            processFile(fileId, 'delete');
        });
    } else if (action === 'restore') {
        $('#restoreFileId').val(fileId);
        $('#restoreFileModal').modal('show');

        $('#restoreFileForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            processFile(fileId, 'restore');
        });
    }
}

function validateFileForm() {
    let isValid = true;
    clearValidationErrors();

    const fileName = $('#editFileName').val().trim();
    const fileInput = $('#editFile')[0];
    const isEdit = $('#editFileId').val() !== "";

    if (fileName === '') {
        $('#editFileName').addClass('is-invalid');
        $('#editFileNameIcon').show();
        $('#editFileNameError').text('File name is required');
        isValid = false;
    } else {
        $('#editFileName').removeClass('is-invalid');
        $('#editFileNameIcon').hide();
    }

    if (!isEdit) {
        if (fileInput.files.length === 0) {
            $('#editFile').addClass('is-invalid');
            $('#editFileIcon').show();
            $('#editFileError').text('File is required');
            isValid = false;
        } else {
            const file = fileInput.files[0];
            const fileType = file.type;
            const validTypes = ['application/pdf', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
            
            if (!validTypes.includes(fileType)) {
                $('#editFile').addClass('is-invalid');
                $('#editFileIcon').show();
                $('#editFileError').text('Only PDF and DOCX files are allowed');
                isValid = false;
            } else {
                $('#editFile').removeClass('is-invalid');
                $('#editFileIcon').hide();
            }
        }
    }

    return isValid;
}

function clearValidationErrors() {
    $('.text-danger').text('');
}

function processFile(fileId, action) {
    let formData = new FormData();

    if (action === 'add' || action === 'edit') {
        formData = new FormData(document.getElementById('editFileForm'));
    } else if (action === 'delete') {
        formData.append('reason', $('#archiveReason').val());
    } else if (action === 'restore') {
        formData.append('file_id', $('#restoreFileId').val());
    }

    if (fileId) {
        formData.append('file_id', fileId);
    }
    formData.append('action', action);

    $.ajax({
        url: "../../handler/admin/fileAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();

                if (action === 'restore') {
                    loadArchives(); 
                } else {
                    loadDownloadablesSection(); 
                }

                showToast('Success', 
                    action === 'delete' ? 'File has been archived.' :
                    action === 'restore' ? 'File has been restored.' :
                    'File has been ' + (action === 'edit' ? 'updated' : 'added') + '.', 
                    'success');
            } else {
                alert("Failed to process request: " + response);
            }
        },
        error: function() {
            alert("An error occurred while processing the request.");
        }
    });
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// STUDENT FUNCTIONS
function initAddressDropdowns() {
    console.log("Initializing address dropdowns..."); // Debug log

    $('#addEditStudentModal').on('shown.bs.modal', function() {
        fetchRegions();
    });

    $('#region').on('change', function() {
        const regionCode = $(this).val();
        if (regionCode) {
            fetchProvinces(regionCode);
        } else {
            resetDropdowns(['province', 'city', 'barangay']);
        }
    });

    $('#province').on('change', function() {
        const provinceCode = $(this).val();
        if (provinceCode) {
            fetchCities(provinceCode);
        } else {
            resetDropdowns(['city', 'barangay']);
        }
    });

    $('#city').on('change', function() {
        const cityCode = $(this).val();
        if (cityCode) {
            fetchBarangays(cityCode);
        } else {
            resetDropdowns(['barangay']);
        }
    });
}

function fetchRegions() {
    $.ajax({
        url: 'https://psgc.gitlab.io/api/regions',
        method: 'GET',
        success: function(regions) {
            const regionSelect = $('#region');
            regionSelect.empty().append('<option value="">Select Region</option>');
            regions.forEach(region => {
                regionSelect.append(`<option value="${region.code}">${region.name}</option>`);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching regions:', error);
        }
    });
}

function fetchProvinces(regionCode) {
    $.ajax({
        url: `https://psgc.gitlab.io/api/regions/${regionCode}/provinces`,
        method: 'GET',
        success: function(provinces) {
            const provinceSelect = $('#province');
            provinceSelect.empty().append('<option value="">Select Province</option>');
            provinces.forEach(province => {
                provinceSelect.append(`<option value="${province.code}">${province.name}</option>`);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching provinces:', error);
        }
    });
}

function fetchCities(provinceCode) {
    $.ajax({
        url: `https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities`,
        method: 'GET',
        success: function(cities) {
            const citySelect = $('#city');
            citySelect.empty().append('<option value="">Select City/Municipality</option>');
            cities.forEach(city => {
                citySelect.append(`<option value="${city.code}">${city.name}</option>`);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching cities:', error);
        }
    });
}

function fetchBarangays(cityCode) {
    $.ajax({
        url: `https://psgc.gitlab.io/api/cities-municipalities/${cityCode}/barangays`,
        method: 'GET',
        success: function(barangays) {
            const barangaySelect = $('#barangay');
            barangaySelect.empty().append('<option value="">Select Barangay</option>');
            barangays.forEach(barangay => {
                barangaySelect.append(`<option value="${barangay.code}">${barangay.name}</option>`);
            });
        },
        error: function(xhr, status, error) {
            console.error('Error fetching barangays:', error);
        }
    });
}

function resetDropdowns(dropdowns) {
    dropdowns.forEach(dropdown => {
        $(`#${dropdown}`).empty().append(`<option value="">Select ${dropdown.charAt(0).toUpperCase() + dropdown.slice(1)}</option>`);
    });
}

function openStudentModal(modalId, studentId, action) {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove(); 
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.modal('show'); 
        setStudentId(studentId, action);
    }, 300);
}

function setStudentId(studentId, action) {
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getStudent.php",
            type: "GET",
            data: { enrollment_id: studentId },
            success: function(response) {
                try {
                    const student = JSON.parse(response);
                    $('#enrollmentId').val(student.enrollment_id);
                    $('#firstName').val(student.first_name);
                    $('#middleName').val(student.middle_name);
                    $('#lastName').val(student.last_name);
                    $('#classification').val(student.classification);
                    $('#email').val(student.email);
                    $('#contactNumber').val(student.contact_number);
                    $('#existing_image').val(student.cor_path);
                    
                    initAddressDropdowns();
                    
                    if (student.region_code) {
                        $('#region').val(student.region_code).trigger('change');
                        setTimeout(() => {
                            if (student.province_code) {
                                $('#province').val(student.province_code).trigger('change');
                                setTimeout(() => {
                                    if (student.city_code) {
                                        $('#city').val(student.city_code).trigger('change');
                                        setTimeout(() => {
                                            if (student.barangay_code) {
                                                $('#barangay').val(student.barangay_code);
                                            }
                                        }, 500);
                                    }
                                }, 500);
                            }
                        }, 500);
                    }
                    
                    $('#street').val(student.street);
                    $('#zipCode').val(student.zip_code);

                    $('#modalTitle').text('Edit Student');
                    $('#confirmSaveStudent').text('Update Student');
                    clearValidationErrors();

                    if (student.classification === 'On-site') {
                        $('#onsiteFields').removeClass('d-none');
                        $('#onlineFields').addClass('d-none');
                        $('#college').val(student.college_id);
                        loadPrograms(student.college_id, student.program_id);
                        $('#yearLevel').val(student.year_level);
                        
                        if (student.cor_path) {
                            $('#image-preview').show();
                            $('#preview-img').attr('src', `../../assets/enrollment/${student.cor_path}`);
                        } else {
                            $('#image-preview').hide();
                        }
                    } else {
                        $('#onsiteFields').addClass('d-none');
                        $('#onlineFields').removeClass('d-none');

                        $('#school').val(student.school);
                        $('#collegeText').val(student.ol_college || '');
                        $('#programText').val(student.ol_program || '');
                    }
                } catch (e) {
                    console.error("Invalid JSON:", response);
                    alert("Failed to load student details.");
                }
            },
            error: function() {
                alert("Failed to load student details.");
            }
        });

        $('#studentForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateStudentForm()) {
                processStudent(studentId, 'edit');
            }
        });
    } else if (action === 'add') {
        $('#studentForm')[0].reset();
        $('#image-preview').hide();
        clearValidationErrors();
        $('#modalTitle').text('Add Student');
        $('#confirmSaveStudent').text('Add Student');
        
        $('#classificationStep').show();
        $('#studentDetailsStep').hide();
        
        initAddressDropdowns();
        
        $('#studentForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateStudentForm()) {
                processStudent(null, 'add');
            }
        });
    } else if (action === 'delete') {
        $('#archiveStudentForm')[0].reset();
        $('#archiveReasonError').text('');
        $('#archiveStudentId').val(studentId);
        $('#archiveStudentModal').modal('show');
    
        $('#archiveStudentForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            const reason = $('#archiveReason').val().trim();
            $('#archiveReasonError').text('');
            $('#archiveReason').removeClass('is-invalid');
            
            if (!reason) {
                $('#archiveReason').addClass('is-invalid');
                $('#studentDeleteReasonIcon').show();
                $('#archiveReasonError').text('Please provide a reason for archiving');
                return;
            }
            
            processStudent(studentId, 'delete');
        });
    } else if (action === 'restore') {
        $('#restoreStudentId').val(studentId);
        $('#restoreStudentModal').modal('show');

        $('#restoreStudentForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            processStudent(studentId, 'restore');
        });
    }
}

function validateStudentForm() {
    let isValid = true;
    clearValidationErrors();

    const firstName = $('#firstName').val().trim();
    const lastName = $('#lastName').val().trim();
    const classification = $('#classification').val();
    const contactNumber = $('#contactNumber').val().trim();
    const email = $('#email').val().trim();
    const isEdit = $('#enrollmentId').val() !== "";

    if (firstName === '') {
        $('#firstNameError').text('First name is required');
        $('#firstName').addClass('is-invalid');
        isValid = false;
    }

    if (lastName === '') {
        $('#lastNameError').text('Last name is required');
        $('#lastName').addClass('is-invalid');
        isValid = false;
    }
    
    if (!classification) {
        $('#classificationError').text('Please select a learning mode');
        $('#classification').addClass('is-invalid');
        isValid = false;
    }
    
    if (contactNumber === '') {
        $('#contactNumberError').text('Contact number is required');
        $('#contactNumber').addClass('is-invalid');
        isValid = false;
    } else if (!/^[0-9]{11}$/.test(contactNumber)) {
        $('#contactNumberError').text('Please enter a valid 11-digit phone number');
        $('#contactNumber').addClass('is-invalid');
        isValid = false;
    }
    
    if (email === '') {
        $('#emailError').text('Email is required');
        $('#email').addClass('is-invalid');
        isValid = false;
    } else {
        const emailPattern = classification === 'On-site' ? /@wmsu\.edu\.ph$/ : /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            $('#emailError').text(classification === 'On-site' ? 'Email must be a valid @wmsu.edu.ph address' : 'Please enter a valid email address');
            $('#email').addClass('is-invalid');
            isValid = false;
        }
    }

    const region = $('#region').val();
    const province = $('#province').val();
    const city = $('#city').val();
    const barangay = $('#barangay').val();
    const street = $('#street').val().trim();
    const zipCode = $('#zipCode').val().trim();

    if (!region) {
        $('#regionError').text('Region is required');
        $('#region').addClass('is-invalid');
        isValid = false;
    }
    
    if (!province) {
        $('#provinceError').text('Province is required');
        $('#province').addClass('is-invalid');
        isValid = false;
    }
    
    if (!city) {
        $('#cityError').text('City/Municipality is required');
        $('#city').addClass('is-invalid');
        isValid = false;
    }
    
    if (!barangay) {
        $('#barangayError').text('Barangay is required');
        $('#barangay').addClass('is-invalid');
        isValid = false;
    }

    if (!street) {
        $('#streetError').text('Street/House No./Blk/Lot is required');
        $('#street').addClass('is-invalid');
        isValid = false;
    }
    
    if (!zipCode) {
        $('#zipCodeError').text('Zip code is required');
        $('#zipCode').addClass('is-invalid');
        isValid = false;
    }

    if (classification === 'On-site') {
        const college = $('#college').val();
        const program = $('#program').val();
        const yearLevel = $('#yearLevel').val();
        const imageInput = $('#image')[0];
        
        if (!college) {
            $('#collegeError').text('Please select a college');
            $('#college').addClass('is-invalid');
            isValid = false;
        }
        
        if (!program) {
            $('#programError').text('Please select a program');
            $('#program').addClass('is-invalid');
            isValid = false;
        }
        
        if (!yearLevel) {
            $('#yearLevelError').text('Please select a year level');
            $('#yearLevel').addClass('is-invalid');
            isValid = false;
        }
        
        if (!isEdit && imageInput.files.length === 0 && !$('#existing_image').val()) {
            $('#imageError').text('Certificate of Registration (COR) is required');
            $('#image').addClass('is-invalid');
            isValid = false;
        }
    }
    
    return isValid;
}

function clearValidationErrors() {
    $('.text-danger').text('');
    $('.is-invalid').removeClass('is-invalid');
}

function nextStep() {
    const classification = $('#classification').val();
    if (!classification) {
        $('#classificationError').text('Please select a learning mode');
        $('#classification').addClass('is-invalid');
        return;
    }
    
    $('#classificationError').text('');
    $('#classification').removeClass('is-invalid');
    $('#classificationStep').hide();
    $('#studentDetailsStep').show();
    
    if (classification === 'On-site') {
        $('#onsiteFields').removeClass('d-none');
        $('#onlineFields').addClass('d-none');
    } else {
        $('#onsiteFields').addClass('d-none');
        $('#onlineFields').removeClass('d-none');
    }
}

function prevStep() {
    $('#studentDetailsStep').hide();
    $('#classificationStep').show();
}

function processStudent(studentId, action) {
    let formData;
    
    if (action === 'delete') {
        formData = new FormData(document.getElementById('archiveStudentForm'));
    } else if (action === 'restore') {
        formData = new FormData(document.getElementById('restoreStudentForm'));
    } else {
        formData = new FormData(document.getElementById('studentForm'));
    }
    
    formData.append('action', action);
    
    if (!formData.has('enrollmentId') && studentId) {
        formData.append('enrollmentId', studentId);
    }

    $.ajax({
        url: "../../handler/admin/studentAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();

                if (action === 'restore') {
                    loadArchives(); 
                } else {
                    loadStudentsSection(); 
                }

                showToast('Success', 
                    action === 'delete' ? 'Student has been archived.' :
                    action === 'restore' ? 'Student has been restored.' :
                    'Student has been ' + (action === 'edit' ? 'updated' : 'added') + '.', 
                    'success');
            } else if (response.trim().startsWith("error:")) {
                const errorMsg = response.trim().replace("error:", "").trim();
                if (errorMsg === "invalid_email_format") {
                    $('#emailError').text('Email must be a valid @wmsu.edu.ph address');
                    $('#email').addClass('is-invalid');
                } else if (errorMsg === "invalid_email") {
                    $('#emailError').text('Please enter a valid email address');
                    $('#email').addClass('is-invalid');
                } else if (errorMsg === "reason_required") {
                    $('#archiveReasonError').text('Please provide a reason for archiving');
                    $('#archiveReason').addClass('is-invalid');
                } else {
                    alert("Failed to process request: " + errorMsg);
                }
            } else {
                console.log("Server response:", response);
                alert("Failed to process request: " + response);
            }
        },
        error: function(xhr, status, error) {
            console.error("AJAX Error:", status, error);
            alert("An error occurred while processing the request.");
        }
    });
}

function loadPrograms(collegeId, selectedProgramId = null) {
    if (!collegeId) {
        $('#program').html('<option value="">Select Program</option>');
        return;
    }
    
    $.ajax({
        url: "../../handler/admin/getCollegeProgram.php",
        type: "GET",
        data: { college_id: collegeId },
        success: function(response) {
            try {
                const programs = JSON.parse(response);
                let options = '<option value="">Select Program</option>';
                
                programs.forEach(program => {
                    const selected = (selectedProgramId && program.program_id == selectedProgramId) ? 'selected' : '';
                    options += `<option value="${program.program_id}" ${selected}>${program.program_name}</option>`;
                });
                
                $('#program').html(options);
                $('#programError').text('');
            } catch (e) {
                console.error("Invalid JSON:", response);
            }
        },
        error: function() {
            alert("Error loading programs");
        }
    });
}

$(document).ready(function() {
    $('#contactNumber').on('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    $(document).on('change', '#region', function() {
        $('#province').val('').trigger('change');
    });

    $(document).on('change', '#province', function() {
        const province = $(this).val();
        const citySelect = $('#city');
        
        citySelect.html('<option value="">Select City/Municipality</option>');
        $('#barangay').html('<option value="">Select Barangay</option>');
        
        if (province) {
            const cities = regionData.cities[province] || [];
            cities.forEach(city => {
                citySelect.append(`<option value="${city}">${city}</option>`);
            });
        }
    });

    $(document).on('change', '#city', function() {
        const city = $(this).val();
        const barangaySelect = $('#barangay');
        
        barangaySelect.html('<option value="">Select Barangay</option>');
        
        if (city) {
            const barangays = regionData.barangays[city] || [];
            barangays.forEach(barangay => {
                barangaySelect.append(`<option value="${barangay}">${barangay}</option>`);
            });
        }
    });

    $(document).on('change', '#college', function() {
        const collegeId = $(this).val();
        loadPrograms(collegeId);
    });

    $(document).on('change', '#classification', function() {
        const classification = $(this).val();
        
        if (classification === 'On-site') {
            $('#onsiteFields').removeClass('d-none');
            $('#onlineFields').addClass('d-none');
        } else if (classification === 'Online') {
            $('#onsiteFields').addClass('d-none');
            $('#onlineFields').removeClass('d-none');
        }
        
        $('#email').val('');
        $('#emailError').text('');
    });
});

const regionData = {
    regions: ['Zamboanga Peninsula'],
    provinces: [
        'Zamboanga del Norte',
        'Zamboanga del Sur',
        'Zamboanga Sibugay',
        'Zamboanga City',
        'Isabela City'
    ],
    cities: {
        'Zamboanga del Norte': [
            'Dapitan City',
            'Dipolog City',
            'Katipunan',
            'La Libertad',
            'Labason',
            'Liloy',
            'Manukan',
            'Polanco',
            'Rizal',
            'Roxas',
            'Sergio Osmeña Sr.',
            'Siayan',
            'Sindangan',
            'Siocon',
            'Tampilisan'
        ],
        'Zamboanga del Sur': [
            'Aurora',
            'Bayog',
            'Dimataling',
            'Dinas',
            'Dumalinao',
            'Dumingag',
            'Guipos',
            'Josefina',
            'Kumalarang',
            'Labangan',
            'Lakewood',
            'Lapuyan',
            'Mahayag',
            'Margosatubig',
            'Midsalip',
            'Molave',
            'Pagadian City',
            'Pitogo',
            'Ramon Magsaysay',
            'San Miguel',
            'San Pablo',
            'Sominot',
            'Tabina',
            'Tambulig',
            'Tigbao',
            'Tukuran',
            'Vincenzo A. Sagun'
        ],
        'Zamboanga Sibugay': [
            'Alicia',
            'Buug',
            'Diplahan',
            'Imelda',
            'Ipil',
            'Kabasalan',
            'Mabuhay',
            'Malangas',
            'Naga',
            'Olutanga',
            'Payao',
            'Roseller Lim',
            'Siay',
            'Talusan',
            'Titay',
            'Tungawan'
        ],
        'Zamboanga City': ['Zamboanga City'],
        'Isabela City': ['Isabela City']
    },
    barangays: {
        'Zamboanga City': [
            'Arena Blanco',
            'Ayala',
            'Baluno',
            'Boalan',
            'Bolong',
            'Buenavista',
            'Bunguiao',
            'Busay',
            'Cabaluay',
            'Cabatangan',
            'Calarian',
            'Canelar',
            'Divisoria',
            'Guiwan',
            'Lunzuran',
            'Putik',
            'Recodo',
            'San Jose Gusu',
            'Sta. Maria',
            'Tetuan'
        ],
        'Dipolog City': [
            'Barra',
            'Biasong',
            'Central',
            'Cogon',
            'Dicayas',
            'Diwan',
            'Estaka',
            'Galas',
            'Gulayon',
            'Lugdungan',
            'Magsaysay',
            'Olingan',
            'Sicayab',
            'Sta. Isabel',
            'Turno'
        ],
        'Pagadian City': [
            'Balangasan',
            'Balintawak',
            'Baliwasan',
            'Baloyboan',
            'Banale',
            'Bogo Capalaran',
            'Buenavista',
            'Bulatok',
            'Bulatin',
            'Dampalan',
            'Dao',
            'Gatas',
            'Kahayagan',
            'Lumbia',
            'Muricay',
            'Napolan',
            'Pulangbato',
            'San Jose',
            'San Pedro',
            'Tiguma'
        ],
        'Dapitan City': [
            'Bagting',
            'Baylimango',
            'Burgos',
            'Cogon',
            'Ilihan',
            'Kalipunan',
            'La Libertad',
            'Linguisan',
            'Masidlakon',
            'Sulangon'
        ],
        'Isabela City': [
            'Aguada',
            'Balatanay',
            'Binuangan',
            'Busay',
            'Cabunbata',
            'Candiis',
            'Cauitan',
            'Lanote',
            'Malamawi',
            'Tabuk'
        ],
        'Ipil': [
            'Bacalan',
            'Baluran',
            'Bunguiao',
            'Don Andres',
            'Guintolan',
            'Labrador',
            'Sanito',
            'Sibugay',
            'Taway',
            'Tiayon'
        ]
    }
};

// OFFICER FUNCTIONS
function openOfficerModal(modalId, officerId, action) {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove(); 
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.modal('show'); 
        setOfficerId(officerId, action);
    }, 300);
}

function setOfficerId(officerId, action) {
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getOfficer.php",
            type: "GET",
            data: { officer_id: officerId },
            success: function(response) {
                try {
                    const officer = JSON.parse(response);
                    $('#editOfficerId').val(officer.officer_id);
                    $('#editFirstName').val(officer.first_name);
                    $('#editMiddleName').val(officer.middle_name);
                    $('#editSurname').val(officer.last_name);
                    $('#editProgram').val(officer.program_id);
                    $('#editPosition').val(officer.position_id);
                    $('#editSchoolYear').val(officer.school_year_id);
                    
                    if (officer.office) {
                        $(`input[name="office"][value="${officer.office}"]`).prop('checked', true);
                    }
                    
                    clearValidationErrors();
                    $('#editOfficerModal .modal-title').text('Edit Officer');
                    $('#editOfficerFormSubmit').text('Update Officer');

                    if (officer.image) {
                        $('#image-preview').show();
                        $('#preview-img').attr('src', `../../assets/officers/${officer.image}`);
                    } else {
                        $('#image-preview').hide();
                    }
                    
                    $('#editOfficerModal').modal('show');
                } catch (e) {
                    console.error("Invalid JSON:", response);
                    alert("Failed to load officer details.");
                }
            },
            error: function() {
                alert("Failed to load officer details.");
            }
        });

        $('#editOfficerForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateOfficerForm()) {
                processOfficer(officerId, 'edit');
            }
        });
    } else if (action === 'add') {
        $('#editOfficerForm')[0].reset();
        $('#image-preview').hide();
        clearValidationErrors();
        $('#editOfficerModal .modal-title').text('Add Officer');
        $('#editOfficerFormSubmit').text('Add Officer');
        $('#editOfficerModal').modal('show');

        $('#editOfficerForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateOfficerForm()) {
                processOfficer(null, 'add');
            }
        });
    } else if (action === 'delete') {
        $('#archiveOfficerId').val(officerId);
        $('#archiveOfficerModal').modal('show');
    
        $('#confirmArchiveOfficer').off('click').on('click', function () {
            const reason = $('#archiveReason').val().trim();
            if (reason === '') {
                $('#archiveReason').addClass('is-invalid');
                $('#archiveReasonIcon').show();
                $('#archiveReasonError').text('Please provide a reason for archiving');
                return;
            }
            $('#archiveReasonError').text('');
            processOfficer(officerId, 'delete');
        });
    } else if (action === 'restore') {
        $('#restoreOfficerId').val(officerId);
        $('#restoreOfficerModal').modal('show');

        $('#restoreOfficerForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            processOfficer(officerId, 'restore');
        });
    }
}

function validateOfficerForm() {
    let isValid = true;
    clearValidationErrors();

    const firstName = $('#editFirstName').val().trim();
    const surname = $('#editSurname').val().trim();
    const position = $('#editPosition').val().trim();
    const program = $('#editProgram').val().trim();
    const schoolYear = $('#editSchoolYear').val().trim();
    const office = $('input[name="office"]:checked').val();
    const positionText = $('#editPosition option:selected').text().trim().toLowerCase();

    if (firstName === '') {
        $('#editFirstNameError').text('First name is required');
        $('#editFirstName').addClass('is-invalid');
        $('#editFirstNameIcon').show();
        isValid = false;
    } else {
        $('#editFirstName').removeClass('is-invalid');
        $('#editFirstNameIcon').hide();
    }

    if (surname === '') {
        $('#editSurnameError').text('Surname is required');
        $('#editSurname').addClass('is-invalid');
        $('#editSurnameIcon').show();
        isValid = false;
    } else {
        $('#editSurname').removeClass('is-invalid');
        $('#editSurnameIcon').hide();
    }

    if (positionText !== 'adviser' && positionText !== 'consultant' && !office) {
        $('#editOfficeError').text('Please select an office');
        isValid = false;
    } else {
        $('#editOfficeError').text('');
    }

    if (positionText !== 'adviser' && positionText !== 'consultant' && program === '') {
        $('#editProgramError').text('Program is required');
        $('#editProgram').addClass('is-invalid');
        isValid = false;
    } else {
        $('#editProgram').removeClass('is-invalid');
        $('#editProgramError').text('');
    }

    if (position === '') {
        $('#editPositionError').text('Position is required');
        $('#editPosition').addClass('is-invalid');
        isValid = false;
    } else {
        $('#editPosition').removeClass('is-invalid');
    }

    if (schoolYear === '') {
        $('#editSchoolYearError').text('School year is required');
        $('#editSchoolYear').addClass('is-invalid');
        isValid = false;
    } else {
        $('#editSchoolYear').removeClass('is-invalid');
    }

    return isValid;
}

function clearValidationErrors() {
    $('#editFirstNameError').text('');
    $('#editMiddleNameError').text('');
    $('#editSurnameError').text('');
    $('#editPositionError').text('');
    $('#editProgramError').text('');
    $('#editSchoolYearError').text('');
    $('#archiveReasonError').text('');

    $('#editFirstName').removeClass('is-invalid');
    $('#editFirstNameIcon').hide();
    $('#editSurname').removeClass('is-invalid');
    $('#editSurnameIcon').hide();
    $('#editProgram').removeClass('is-invalid');
    $('#editPosition').removeClass('is-invalid');
    $('#editSchoolYear').removeClass('is-invalid');
    $('#editImage').removeClass('is-invalid');
    $('#editImageIcon').hide();
}

function processOfficer(officerId, action) {
    let formData = new FormData();

    if (action === 'add' || action === 'edit') {
        formData = new FormData(document.getElementById('editOfficerForm'));
    } else if (action === 'delete') {
        formData.append('reason', $('#archiveReason').val());
    } else if (action === 'restore') {
        formData.append('officer_id', $('#restoreOfficerId').val());
    }

    if (officerId) {
        formData.append('officer_id', officerId);
    }
    formData.append('action', action);

    $.ajax({
        url: "../../handler/admin/officersAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();

                if (action === 'restore') {
                    loadArchives(); 
                } else {
                    loadOfficersSection(); 
                }

                showToast('Success', 
                    action === 'delete' ? 'Officer has been archived.' :
                    action === 'restore' ? 'Officer has been restored.' :
                    'Officer has been ' + (action === 'edit' ? 'updated' : 'added') + '.', 
                    'success');
            } else {
                alert("Failed to process request: " + response);
            }
        },
        error: function() {
            alert("An error occurred while processing the request.");
        }
    });
}

// VOLUNTEER FUNCTIONS
function openVolunteerModal(modalId, volunteerId, action) {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove(); 
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.modal('show'); 
        setVolunteerId(volunteerId, action);
    }, 300);
}

function setVolunteerId(volunteerId, action) {
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getVolunteer.php",
            type: "GET",
            data: { volunteer_id: volunteerId },
            success: function(response) {
                try {
                    const volunteer = JSON.parse(response);
                    $('#volunteerId').val(volunteer.volunteer_id);
                    $('#firstName').val(volunteer.first_name);
                    $('#middleName').val(volunteer.middle_name);
                    $('#surname').val(volunteer.last_name);
                    $('#year').val(volunteer.year_level);
                    $('#program').val(volunteer.program_id);
                    $('#contact').val(volunteer.contact);
                    $('#email').val(volunteer.email);
                    $('#existing_image').val(volunteer.cor_file);
                    
                    if (volunteer.cor_file) {
                        $('#image-preview').show();
                        $('#preview-img').attr('src', '../../assets/cors/' + volunteer.cor_file);
                    } else {
                        $('#image-preview').hide();
                    }
                    
                    clearValidationErrors();
                    $('.modal-title').text('Edit Volunteer');
                    $('#volunteerFormSubmit').text('Update Volunteer');
                    $('#editVolunteerModal').modal('show');
                } catch (e) {
                    console.error("Invalid JSON:", response);
                    alert("Failed to load volunteer details.");
                }
            },
            error: function() {
                alert("Failed to load volunteer details.");
            }
        });

        $('#volunteerForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateVolunteerForm()) {
                processVolunteer(volunteerId, 'edit');
            }
        });
    } else if (action === 'add') {
        $('#volunteerForm')[0].reset();
        $('#image-preview').hide();
        clearValidationErrors();
        $('.modal-title').text('Add Volunteer');
        $('#volunteerFormSubmit').text('Add Volunteer');
        $('#editVolunteerModal').modal('show');

        $('#volunteerForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateVolunteerForm()) {
                processVolunteer(null, 'add');
            }
        });
    } else if (action === 'delete') {
        $('#archiveVolunteerId').val(volunteerId);
        $('#archiveVolunteerModal').modal('show');
    
        $('#confirmArchiveVolunteer').off('click').on('click', function () {
            const reason = $('#archiveReason').val().trim();
            if (reason === '') {
                $('#archiveReason').addClass('is-invalid');
                $('#archiveReasonIcon').show();
                $('#archiveReasonError').text('Please provide a reason for archiving');
                return;
            }
            $('#archiveReasonError').text('');
            processVolunteer(volunteerId, 'delete');
        });    
    } else if (action === 'restore') {
        $('#restoreVolunteerId').val(volunteerId);
        $('#restoreVolunteerModal').modal('show');

        $('#restoreVolunteerForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            processVolunteer(volunteerId, 'restore');
        });
    }
}

function validateVolunteerForm() {
    let isValid = true;
    clearVolunteerValidationErrors();

    const firstName = $('#firstName').val().trim();
    const lastName = $('#surname').val().trim();
    const year = $('#year').val();
    const program = $('#program').val();
    const contact = $('#contact').val().trim();
    const email = $('#email').val().trim();
    const imageInput = $('#image')[0];
    const isEdit = $('#volunteerId').val() !== "";

    if (firstName === '') {
        $('#firstNameError').text('First name is required');
        $('#firstName').addClass('is-invalid');
        isValid = false;
    }
    if (lastName === '') {
        $('#surnameError').text('Last name is required');
        $('#surname').addClass('is-invalid');
        isValid = false;
    }
    if (!year) {
        $('#yearError').text('Year level is required');
        $('#year').addClass('is-invalid');
        isValid = false;
    }
    if (!program) {
        $('#programError').text('Program is required');
        $('#program').addClass('is-invalid');
        isValid = false;
    }
    if (contact === '') {
        $('#contactError').text('Contact number is required');
        $('#contact').addClass('is-invalid');
        isValid = false;
    } else if (!/^\d{11}$/.test(contact)) {
        $('#contactError').text('Contact must be an 11-digit number');
        $('#contact').addClass('is-invalid');
        isValid = false;
    }
    if (email === '') {
        $('#emailError').text('Email is required');
        $('#email').addClass('is-invalid');
        isValid = false;
    } else if (!/^\S+@\S+\.\S+$/.test(email)) {
        $('#emailError').text('Please enter a valid email address');
        $('#email').addClass('is-invalid');
        isValid = false;
    }
    if (!isEdit && imageInput.files.length === 0) {
        $('#imageError').text('Certificate of Registration is required');
        $('#image').addClass('is-invalid');
        isValid = false;
    }
    return isValid;
}

function clearVolunteerValidationErrors() {
    $('#firstNameError').text('');
    $('#surnameError').text('');
    $('#yearError').text('');
    $('#programError').text('');
    $('#contactError').text('');
    $('#emailError').text('');
    $('#imageError').text('');
    $('#firstName').removeClass('is-invalid');
    $('#surname').removeClass('is-invalid');
    $('#year').removeClass('is-invalid');
    $('#program').removeClass('is-invalid');
    $('#contact').removeClass('is-invalid');
    $('#email').removeClass('is-invalid');
    $('#image').removeClass('is-invalid');
}

$(document).on('submit', '#volunteerForm', function(e) {
    e.preventDefault();
    if (validateVolunteerForm()) {
        const volunteerId = $('#volunteerId').val();
        const action = volunteerId ? 'edit' : 'add';
        processVolunteer(volunteerId, action);
    }
});

$('#addVolunteerModal').on('hidden.bs.modal', function () {
    clearVolunteerValidationErrors();
    $('#volunteerForm')[0].reset();
});

$('[data-bs-dismiss="modal"]').on('click', function() {
    clearVolunteerValidationErrors();
    $('#volunteerForm')[0].reset();
});

function processVolunteer(volunteerId, action) {
    let formData = new FormData();

    if (action === 'add' || action === 'edit') {
        formData = new FormData(document.getElementById('volunteerForm'));
    } else if (action === 'delete') {
        formData.append('reason', $('#archiveReason').val());
    } else if (action === 'restore') {
        formData.append('volunteer_id', $('#restoreVolunteerId').val());
    }

    if (volunteerId) {
        formData.append('volunteer_id', volunteerId);
    }
    formData.append('action', action);

    $.ajax({
        url: "../../handler/admin/volunteerAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();

                if (action === 'restore') {
                    loadArchives(); 
                } else {
                    loadVolunteersSection(); 
                }

                showToast('Success', 
                    action === 'delete' ? 'Volunteer has been archived.' :
                    action === 'restore' ? 'Volunteer has been restored.' :
                    'Volunteer has been ' + (action === 'edit' ? 'updated' : 'added') + '.', 
                    'success');
            } else {
                alert("Failed to process request: " + response);
            }
        },
        error: function() {
            alert("An error occurred while processing the request.");
        }
    });
}

// REGISTRATION FUNCTIONS
function openModal(modalId, volunteerId, action) {
    $('.modal').modal('hide'); 
    $('.modal-backdrop').remove(); -
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.attr('aria-hidden', 'false');
        modal.modal('show'); 
        setRegistrationId(volunteerId, action);
    }, 300);
}

function setRegistrationId(volunteerId, action) {
    if (action === 'approve') {
        $('#confirmApprove').off('click').on('click', function () {
            processRegistration(volunteerId, 'approve');
        });
    } else if (action === 'reject') {
        $('#confirmReject').off('click').on('click', function () {
            processRegistration(volunteerId, 'reject');
        });
    }
}

function processRegistration(volunteerId, action) {
    $.ajax({
        url: "../../handler/admin/approveRegistration.php",
        type: "POST",
        data: { volunteer_id: volunteerId, action: action },
        success: function(response) {
            console.log("Server response:", response); 
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();
                loadRegistrationsSection(); 
                if (action === 'approve') {
                    showToast('Success', 'Volunteer registration approved.', 'success');
                } else if (action === 'reject') {
                    showToast('Success', 'Volunteer registration rejected.', 'success');
                }
            } else {
                console.log("Failed to process request:", response); 
                alert("Failed to process request.");
            }
        },
        error: function(xhr, status, error) {
            console.log("AJAX error:", status, error); 
            alert("An error occurred while processing the request.");
        }
    });
}

// ENROLLMENT FUNCTIONS
function openEnrollmentModal(modalId, enrollmentId, action) {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove();
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.attr('aria-hidden', 'false');
        modal.modal('show');
        setEnrollmentId(enrollmentId, action);
    }, 300);
}

function setEnrollmentId(enrollmentId, action) {
    if (action === 'enroll') {
        $('#confirmEnroll').off('click').on('click', function () {
            processEnrollment(enrollmentId, 'enroll');
        });
    } else if (action === 'reject') {
        $('#confirmReject').off('click').on('click', function () {
            processEnrollment(enrollmentId, 'reject');
        });
    }
}

function processEnrollment(enrollmentId, action) {
    $.ajax({
        url: "../../handler/admin/enrollmentAction.php",
        type: "POST",
        data: { enrollment_id: enrollmentId, action: action },
        success: function(response) {
            console.log("Server response:", response);
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();
                loadEnrollmentSection   ();
                if (action === 'enroll') {
                    showToast('Success', 'Enrollment approved.', 'success');
                } else if (action === 'reject') {
                    showToast('Success', 'Enrollment rejected.', 'success');
                }
            } else {
                console.log("Failed to process request:", response);
                alert("Failed to process request.");
            }
        },
        error: function(xhr, status, error) {
            console.log("AJAX error:", status, error);
            alert("An error occurred while processing the request.");
        }
    });
}

// MODERATOR FUNCTIONS
function openModeratorModal(modalId, moderatorId, action) {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove();
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.modal('show');
        setModeratorId(moderatorId, action);
    }, 300);
}

function setModeratorId(moderatorId, action) {
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getModerator.php",
            type: "GET",
            data: { user_id: moderatorId },
            success: function(response) {
                try {
                    const moderator = JSON.parse(response);
                    $('#editModeratorId').val(moderator.user_id);
                    $('#editFirstName').val(moderator.first_name);
                    $('#editMiddleName').val(moderator.middle_name);
                    $('#editLastName').val(moderator.last_name);
                    $('#editUsername').val(moderator.username);
                    $('#editEmail').val(moderator.email);
                    $('#editPositionId').val(moderator.position_id);
                    $('#editModeratorModal .modal-title').text('Edit Moderator');
                    $('#editModeratorFormSubmit').text('Update Moderator');
                    clearValidationErrors();
                    
                    $('#passwordContainer').hide();
                    
                    $('#editModeratorModal').modal('show');
                } catch (e) {
                    console.error("Invalid JSON:", response);
                    showToast('Error', 'Failed to load moderator details.', 'error');
                }
            },
            error: function() {
                showToast('Error', 'Failed to load moderator details.', 'error');
            }
        });

        $('#editModeratorForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateModeratorForm()) {
                processModerator(moderatorId, 'edit');
            }
        });
    } else if (action === 'add') {
        $('#editModeratorForm')[0].reset();
        clearValidationErrors();
        $('#editModeratorModal .modal-title').text('Add Moderator');
        $('#editModeratorFormSubmit').text('Add Moderator');
        
        $('#passwordContainer').show();
        
        $('#editModeratorModal').modal('show');

        $('#editModeratorForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateModeratorForm(true)) {
                processModerator(null, 'add');
            }
        });
    } else if (action === 'delete') {
        $('#archiveModeratorId').val(moderatorId);
        $('#archiveReason').val('');
        $('#archiveReasonError').text('');
        $('#archiveModeratorModal').modal('show');
    
        $('#confirmArchiveModerator').off('click').on('click', function() {
            const reason = $('#archiveReason').val().trim();
            if (reason === '') {
                $('#archiveReason').addClass('is-invalid');
                $('#archiveReasonIcon').show();
                $('#archiveReasonError').text('Please provide a reason for archiving');
                return;
            }
            $('#archiveReasonError').text('');
            processModerator(moderatorId, 'delete');
        });    
    } else if (action === 'restore') {
        $('#restoreModeratorId').val(moderatorId);
        $('#restoreModeratorModal').modal('show');

        $('#restoreModeratorForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            processModerator(moderatorId, 'restore');
        });
    }
}

function validateModeratorForm(isAdd = false) {
    let isValid = true;
    clearValidationErrors();

    const firstName = $('#editFirstName').val().trim();
    const lastName = $('#editLastName').val().trim();
    const username = $('#editUsername').val().trim();
    const email = $('#editEmail').val().trim();
    const positionId = $('#editPositionId').val().trim();
    const password = $('#editPassword').val() ? $('#editPassword').val().trim() : '';

    if (firstName === '') {
        $('#editFirstNameError').text('First name is required');
        $('#editFirstName').addClass('is-invalid');
        $('#editFirstNameIcon').show();
        isValid = false;
    } else {
        $('#editFirstName').removeClass('is-invalid');
        $('#editFirstNameIcon').hide();
    }

    if (lastName === '') {
        $('#editLastNameError').text('Last name is required');
        $('#editLastName').addClass('is-invalid');
        $('#editLastNameIcon').show();
        isValid = false;
    } else {
        $('#editLastName').removeClass('is-invalid');
        $('#editLastNameIcon').hide();
    }

    if (username === '') {
        $('#editUsernameError').text('Username is required');
        $('#editUsername').addClass('is-invalid');
        $('#editUsernameIcon').show();
        isValid = false;
    } else {
        $('#editUsername').removeClass('is-invalid');
        $('#editUsernameIcon').hide();
    }

    if (email === '') {
        $('#editEmailError').text('Email is required');
        $('#editEmail').addClass('is-invalid');
        $('#editEmailIcon').show();
        isValid = false;
    } else if (!isValidEmail(email)) {
        $('#editEmailError').text('Invalid email format');
        $('#editEmail').addClass('is-invalid');
        $('#editEmailIcon').show();
        isValid = false;
    } else {
        $('#editEmail').removeClass('is-invalid');
        $('#editEmailIcon').hide();
    }

    if (positionId === '') {
        $('#editPositionIdError').text('Position is required');
        $('#editPositionId').addClass('is-invalid');
        isValid = false;
    } else {
        $('#editPositionId').removeClass('is-invalid');
    }

    if (isAdd) {
        if (password === '') {
            $('#editPasswordError').text('Password is required');
            $('#editPassword').addClass('is-invalid');
            $('#editPasswordIcon').show();
            isValid = false;
        } else if (password.length < 8) {
            $('#editPasswordError').text('Password must be at least 8 characters');
            $('#editPassword').addClass('is-invalid');
            $('#editPasswordIcon').show();
            isValid = false;
        } else {
            $('#editPassword').removeClass('is-invalid');
            $('#editPasswordIcon').hide();
        }
    } else {
        $('#editPassword').removeClass('is-invalid');
        $('#editPasswordIcon').hide();
    }

    return isValid;
}

function isValidEmail(email) {
    const re = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    return re.test(email);
}

function clearValidationErrors() {
    $('#editFirstNameError, #editLastNameError, #editUsernameError, #editEmailError, #editPositionIdError, #editPasswordError, #archiveReasonError').text('');
    $('#editFirstName').removeClass('is-invalid');
    $('#editFirstNameIcon').hide();
    $('#editLastName').removeClass('is-invalid');
    $('#editLastNameIcon').hide();
    $('#editUsername').removeClass('is-invalid');
    $('#editUsernameIcon').hide();
    $('#editEmail').removeClass('is-invalid');
    $('#editEmailIcon').hide();
    $('#editPassword').removeClass('is-invalid');
    $('#editPasswordIcon').hide();
    $('#editPositionId').removeClass('is-invalid');
}

function processModerator(moderatorId, action) {
    let formData = new FormData();

    if (action === 'add' || action === 'edit') {
        formData.append('firstName', $('#editFirstName').val());
        formData.append('middleName', $('#editMiddleName').val());
        formData.append('lastName', $('#editLastName').val());
        formData.append('username', $('#editUsername').val());
        formData.append('email', $('#editEmail').val());
        formData.append('positionId', $('#editPositionId').val());
        
        if (action === 'add') {
            formData.append('password', $('#editPassword').val());
        }
    } else if (action === 'delete') {
        formData.append('reason', $('#archiveReason').val());
    } else if (action === 'restore') {
        formData.append('user_id', $('#restoreModeratorId').val());
    }

    if (moderatorId) {
        formData.append('user_id', moderatorId);
    }
    formData.append('action', action);

    $.ajax({
        url: "../../handler/admin/moderatorAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.includes("error:username_exists")) {
                $('#editUsernameError').text('Username already exists');
                return;
            }
            
            if (response.includes("error:email_exists")) {
                $('#editEmailError').text('Email already exists');
                return;
            }
            
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();

                if (action === 'restore') {
                    loadArchives(); 
                } else {
                    loadModeratorsSection(); 
                }

                showToast('Success', 
                    action === 'delete' ? 'Moderator has been archived.' :
                    action === 'restore' ? 'Moderator has been restored.' :
                    'Moderator has been ' + (action === 'edit' ? 'updated' : 'added') + '.', 
                    'success');
            } else {
                showToast('Error', 'Failed to process request.', 'error');
            }
        },
        error: function() {
            showToast('Error', 'An error occurred while processing the request.', 'error');
        }
    });
}

// UPDATES FUNCTIONS
function initSearchOrgUpdates() {
    $('#searchOrgUpdates').on('keyup', function() {
        const searchTerm = $(this).val().toLowerCase();
        $('.org-update-card').each(function() {
            const title = $(this).find('.card-title').text().toLowerCase();
            const content = $(this).find('.card-text').text().toLowerCase();
            const author = $(this).find('.update-author').text().toLowerCase();

            if (title.includes(searchTerm) || content.includes(searchTerm) || author.includes(searchTerm)) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    });
}

function openUpdateModal(modalId, updateId, action) {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove(); 
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.modal('show'); 
        setUpdateId(updateId, action);
    }, 300);
}

function initImagePreview() {
    $('#deletedImages').val('[]');
    $('#selectedImagesPreview').empty();
    
    $('#editImages').off('change').on('change', function(e) {
        updateImagePreview(this);
    });

    $('#addMoreImages').off('click').on('click', function() {
        $('#editImages').click();
    });
}

function updateImagePreview(input) {
    if (input.files && input.files.length > 0) {
        const existingFiles = Array.from($('#selectedImagesPreview .selected-image')).map(
            el => $(el).data('file-name')
        );
        
        const dataTransfer = new DataTransfer();
        
        if (input.files) {
            Array.from(input.files).forEach(file => {
                dataTransfer.items.add(file);
            });
        }
        
        for (let i = 0; i < input.files.length; i++) {
            const file = input.files[i];
            const reader = new FileReader();
            
            if (existingFiles.includes(file.name)) {
                continue;
            }
            
            reader.onload = function(e) {
                const imgPreview = $(`
                    <div class="position-relative selected-image mb-2 me-2" data-file-name="${file.name}">
                        <img src="${e.target.result}" class="img-thumbnail" style="width: 100px; height: 70px; object-fit: cover;">
                        <button type="button" class="btn btn-sm btn-danger position-absolute" style="top: 0; right: 0; padding: 0 5px;" onclick="removeSelectedImage(this)">×</button>
                    </div>
                `);
                $('#selectedImagesPreview').append(imgPreview);
            };
            
            reader.readAsDataURL(file);
        }
    }
}

function removeSelectedImage(btn) {
    const fileNameToRemove = $(btn).closest('.selected-image').data('file-name');
    $(btn).closest('.selected-image').remove();
    removeFileFromInput(fileNameToRemove);
}

function removeFileFromInput(fileName) {
    const input = document.getElementById('editImages');
    
    if (input.files && input.files.length > 0) {
        const dt = new DataTransfer();
        
        for (let i = 0; i < input.files.length; i++) {
            const file = input.files[i];
            if (file.name !== fileName) {
                dt.items.add(file);
            }
        }
        
        input.files = dt.files;
    }
    
    updateFileInput();
}

function removeCurrentImage(btn, imageId) {
    const deletedImageIds = JSON.parse($('#deletedImages').val() || '[]');
    deletedImageIds.push(imageId);
    $('#deletedImages').val(JSON.stringify(deletedImageIds));
    
    $(btn).closest('.current-image-item').remove();
    
    $('#editImagesError').text('Image marked for deletion. Changes will apply when form is submitted.').removeClass('text-danger').addClass('text-info');
    setTimeout(() => {
        $('#editImagesError').text('').removeClass('text-info');
    }, 3000);
}

function updateFileInput() {
    $('#editImagesError').text('Image removed from preview. Changes will apply when form is submitted.').removeClass('text-danger').addClass('text-info');
    setTimeout(() => {
        $('#editImagesError').text('').removeClass('text-info');
    }, 3000);
}

function setUpdateId(updateId, action) {
    $('#editUpdateForm')[0].reset();
    $('#selectedImagesPreview').empty();
    $('#deletedImages').val('[]');
    
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getOrgUpdates.php",
            type: "GET",
            data: { update_id: updateId },
            success: function(response) {
                try {
                    const data = JSON.parse(response);
                    const update = data.update;
                    const images = data.images;
                    
                    $('#editUpdateId').val(update.update_id);
                    $('#editTitle').val(update.title);
                    $('#editContent').val(update.content);
                    
                    if (images && images.length > 0) {
                        $('#currentImagesContainer').removeClass('d-none');
                        $('#currentImages').empty();
                        
                        images.forEach(image => {
                            const imgPreview = $(`
                                <div class="position-relative current-image-item me-2 mb-2">
                                    <img src="../../assets/updates/${image.file_path}" class="img-thumbnail" style="width: 100px; height: 70px; object-fit: cover;">
                                    <button type="button" class="btn btn-sm btn-danger position-absolute" style="top: 0; right: 0; padding: 0 5px;" onclick="removeCurrentImage(this, ${image.image_id})">×</button>
                                </div>
                            `);
                            $('#currentImages').append(imgPreview);
                        });
                    } else {
                        $('#currentImagesContainer').addClass('d-none');
                    }
                    
                    $('#editUpdateModal .modal-title').text('Edit Organization Update');
                    $('#editUpdateFormSubmit').text('Update');
                    clearValidationErrors();
                    initImagePreview();
                    $('#editUpdateModal').modal('show');
                } catch (e) {
                    console.error("Invalid JSON:", response);
                    alert("Failed to load update details.");
                }
            },
            error: function() {
                alert("Failed to load update details.");
            }
        });

        $('#editUpdateForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateUpdateForm('edit')) {
                processUpdate(updateId, 'edit');
            }
        });
    } else if (action === 'add') {
        $('#editUpdateForm')[0].reset();
        clearValidationErrors();
        $('#currentImagesContainer').addClass('d-none');
        $('#editUpdateModal .modal-title').text('Add Organization Update');
        $('#editUpdateFormSubmit').text('Add Update');
        initImagePreview();
        $('#editUpdateModal').modal('show');

        $('#editUpdateForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateUpdateForm('add')) {
                processUpdate(null, 'add');
            }
        });
    } else if (action === 'delete') {
        $('#archiveUpdateId').val(updateId);
        $('#archiveUpdateModal').modal('show');
    
        $('#confirmArchiveUpdate').off('click').on('click', function () {
            const reason = $('#archiveReason').val().trim();
            if (reason === '') {
                $('#archiveReason').addClass('is-invalid');
                $('#archiveReasonIcon').show();
                $('#archiveReasonError').text('Please provide a reason for archiving');
                return;
            }
            $('#archiveReasonError').text('');
            processUpdate(updateId, 'delete');
        });    
    } else if (action === 'restore') {
        $('#restoreUpdateId').val(updateId);
        $('#restoreUpdateModal').modal('show');

        $('#restoreUpdateForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            processUpdate(updateId, 'restore');
        });
    }
}

function validateUpdateForm(action) {
    let isValid = true;
    clearUpdateValidationErrors();

    const title = $('#editTitle').val().trim();
    if (title === '') {
        $('#editTitle').addClass('is-invalid');
        $('#editTitleIcon').show();
        $('#editTitleError').text('Title is required');
        isValid = false;
    } else {
        $('#editTitle').removeClass('is-invalid');
        $('#editTitleIcon').hide();
        $('#editTitleError').text('');
    }

    const content = $('#editContent').val().trim();
    if (content === '') {
        $('#editContent').addClass('is-invalid');
        $('#editContentIcon').show();
        $('#editContentError').text('Content is required');
        isValid = false;
    } else {
        $('#editContent').removeClass('is-invalid');
        $('#editContentIcon').hide();
        $('#editContentError').text('');
    }

    const imagesInput = $('#editImages')[0];
    const hasSelectedImages = $('#selectedImagesPreview .selected-image').length > 0;
    if (action === 'add' && !hasSelectedImages && imagesInput.files.length === 0) {
        $('#editImages').addClass('is-invalid');
        $('#editImagesIcon').show();
        $('#editImagesError').text('At least one image is required');
        isValid = false;
    } else if (action === 'edit') {
        const remainingCurrentImages = $('#currentImages .current-image-item').length;
        const totalImagesAfterChanges = remainingCurrentImages + (imagesInput.files ? imagesInput.files.length : 0);
        if (totalImagesAfterChanges === 0) {
            $('#editImages').addClass('is-invalid');
            $('#editImagesIcon').show();
            $('#editImagesError').text('At least one image is required. You cannot delete all images without adding new ones.').removeClass('text-info').addClass('text-danger');
            isValid = false;
        } else {
            $('#editImages').removeClass('is-invalid');
            $('#editImagesIcon').hide();
            $('#editImagesError').text('');
        }
    } else {
        $('#editImages').removeClass('is-invalid');
        $('#editImagesIcon').hide();
        $('#editImagesError').text('');
    }

    return isValid;
}

function clearUpdateValidationErrors() {
    $('#editTitleError').text('');
    $('#editContentError').text('');
    $('#editImagesError').text('');
    $('#editTitle').removeClass('is-invalid');
    $('#editContent').removeClass('is-invalid');
    $('#editImages').removeClass('is-invalid');
    $('#editTitleIcon').hide();
    $('#editContentIcon').hide();
    $('#editImagesIcon').hide();
}

function processUpdate(updateId, action) {
    let formData = new FormData();

    if (action === 'add' || action === 'edit') {
        formData = new FormData(document.getElementById('editUpdateForm'));
    } else if (action === 'delete') {
        formData.append('reason', $('#archiveReason').val());
    } else if (action === 'restore') {
        formData.append('update_id', $('#restoreUpdateId').val());
    }

    if (updateId) {
        formData.append('update_id', updateId);
    }
    formData.append('action', action);

    $.ajax({
        url: "../../handler/admin/orgUpdatesAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();

                if (action === 'restore') {
                    loadArchives(); 
                } else {
                    loadUpdatesSection(); 
                }

                showToast('Success', 
                    action === 'delete' ? 'Organization update has been archived.' :
                    action === 'restore' ? 'Organization update has been restored.' :
                    'Organization update has been ' + (action === 'edit' ? 'updated' : 'added') + '.', 
                    'success');
            } else {
                alert("Failed to process request: " + response);
            }
        },
        error: function() {
            alert("An error occurred while processing the request.");
        }
    });
}

function clearValidationErrors() {
    $('#editTitleError, #editContentError, #editImagesError, #archiveReasonError').text('')
    .removeClass('text-info text-danger')
    .addClass('text-danger');
}

$(document).on('hidden.bs.modal', function () {
    if ($('.modal.show').length === 0) { 
        $('body').removeClass('modal-open'); 
        $('.modal-backdrop').remove();
    }
});

// EXECUTIVE POSITION FUNCTIONS
function openPositionModal(modalId, positionId, action) {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove(); 
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.modal('show'); 
        setPositionId(positionId, action);
    }, 300);
}

function setPositionId(positionId, action) {
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getExePosition.php",
            type: "GET",
            data: { position_id: positionId },
            success: function(response) {
                try {
                    const position = JSON.parse(response);
                    $('#editPositionId').val(position.position_id);
                    $('#editPositionName').val(position.position_name);
                    $('#editExePositionModal .modal-title').text('Edit Executive Position');
                    $('#editPositionFormSubmit').text('Update Position');
                    clearValidationErrors();
                    $('#editExePositionModal').modal('show');
                } catch (e) {
                    console.error("Invalid JSON:", response);
                    alert("Failed to load position details.");
                }
            },
            error: function() {
                alert("Failed to load position details.");
            }
        });

        $('#editPositionForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validatePositionForm()) {
                processPosition(positionId, 'edit');
            }
        });
    } else if (action === 'add') {
        $('#editPositionForm')[0].reset();
        clearValidationErrors();
        $('#editExePositionModal .modal-title').text('Add Executive Position');
        $('#editPositionFormSubmit').text('Add Position');
        $('#editExePositionModal').modal('show');

        $('#editPositionForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validatePositionForm()) {
                processPosition(null, 'add');
            }
        });
    } else if (action === 'delete') {
        $('#archivePositionId').val(positionId);
        $('#archiveExePositionModal').modal('show');
    
        $('#confirmArchivePosition').off('click').on('click', function () {
            const reason = $('#archiveReason').val().trim();
            if (reason === '') {
                $('#archiveReason').addClass('is-invalid');
                $('#archiveReasonIcon').show();
                $('#archiveReasonError').text('Please provide a reason for archiving');
                return;
            }
            $('#archiveReasonError').text('');
            processPosition(positionId, 'delete');
        });    
    } else if (action === 'restore') {
        $('#restorePositionId').val(positionId);
        $('#restoreExePositionModal').modal('show');

        $('#restoreExePositionForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            processPosition(positionId, 'restore');
        });
    }
}

function validatePositionForm() {
    let isValid = true;
    clearPositionValidationErrors();

    const positionName = $('#editPositionName').val().trim();
    if (positionName === '') {
        $('#editPositionName').addClass('is-invalid');
        $('#editPositionNameIcon').show();
        $('#editPositionNameError').text('Position name is required');
        isValid = false;
    } else {
        $('#editPositionName').removeClass('is-invalid');
        $('#editPositionNameIcon').hide();
        $('#editPositionNameError').text('');
    }

    return isValid;
}

function clearPositionValidationErrors() {
    $('#editPositionNameError').text('');
    $('#editPositionName').removeClass('is-invalid');
    $('#editPositionNameIcon').hide();
}

function processPosition(positionId, action) {
    let formData = new FormData();

    if (action === 'add' || action === 'edit') {
        formData = new FormData(document.getElementById('editPositionForm'));
    } else if (action === 'delete') {
        formData.append('reason', $('#archiveReason').val());
    } else if (action === 'restore') {
        formData.append('position_id', $('#restorePositionId').val());
    }

    if (positionId) {
        formData.append('position_id', positionId);
    }
    formData.append('action', action);

    $.ajax({
        url: "../../handler/admin/exePositionAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();

                if (action === 'restore') {
                    loadArchives(); 
                } else {
                    loadExecutivePositionsSection(); 
                }

                showToast('Success', 
                    action === 'delete' ? 'Position has been archived.' :
                    action === 'restore' ? 'Position has been restored.' :
                    'Position has been ' + (action === 'edit' ? 'updated' : 'added') + '.', 
                    'success');
            } else if (response.trim() === "error: duplicate_position") {
                if (action === 'add' || action === 'edit') {
                    $('#editPositionNameError').text('This position already exists. Please use a different name.');
                } else {
                    alert("Duplicate position name detected.");
                }
            } else {
                alert("Failed to process request: " + response);
            }
        },
        error: function() {
            alert("An error occurred while processing the request.");
        }
    });
}

// SCHOOL YEAR FUNCTIONS
function openSchoolYearModal(modalId, schoolYearId, action) {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove(); 
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.modal('show'); 
        setSchoolYearId(schoolYearId, action);
    }, 300);
}

function setSchoolYearId(schoolYearId, action) {
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getSchoolYear.php",
            type: "GET",
            data: { school_year_id: schoolYearId },
            success: function(response) {
                try {
                    const schoolYear = JSON.parse(response);
                    $('#editSchoolYearId').val(schoolYear.school_year_id);
                    $('#editSchoolYear').val(schoolYear.school_year);
                    $('#editSchoolYearModal .modal-title').text('Edit School Year');
                    $('#editSchoolYearFormSubmit').text('Update School Year');
                    clearValidationErrors();
                    $('#editSchoolYearModal').modal('show');
                } catch (e) {
                    console.error("Invalid JSON:", response);
                    alert("Failed to load school year details.");
                }
            },
            error: function() {
                alert("Failed to load school year details.");
            }
        });

        $('#editSchoolYearForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateSchoolYearForm()) {
                processSchoolYear(schoolYearId, 'edit');
            }
        });
    } else if (action === 'add') {
        $('#editSchoolYearForm')[0].reset();
        clearValidationErrors();
        $('#editSchoolYearModal .modal-title').text('Add School Year');
        $('#editSchoolYearFormSubmit').text('Add School Year');
        $('#editSchoolYearModal').modal('show');

        $('#editSchoolYearForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateSchoolYearForm()) {
                processSchoolYear(null, 'add');
            }
        });
    } else if (action === 'delete') {
        $('#archiveSchoolYearId').val(schoolYearId);
        $('#archiveSchoolYearModal').modal('show');
    
        $('#confirmArchiveSchoolYear').off('click').on('click', function () {
            const reason = $('#archiveReason').val().trim();
            if (reason === '') {
                $('#archiveReason').addClass('is-invalid');
                $('#archiveReasonIcon').show();
                $('#archiveReasonError').text('Please provide a reason for archiving');
                return;
            }
            $('#archiveReasonError').text('');
            processSchoolYear(schoolYearId, 'delete');
        });    
    } else if (action === 'restore') {
        $('#restoreSchoolYearId').val(schoolYearId);
        $('#restoreSchoolYearModal').modal('show');

        $('#restoreSchoolYearForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            processSchoolYear(schoolYearId, 'restore');
        });
    }
}

function validateSchoolYearForm() {
    let isValid = true;
    clearValidationErrors();

    const schoolYear = $('#editSchoolYear').val().trim();
    
    if (schoolYear === '') {
        $('#editSchoolYearError').text('School year is required');
        isValid = false;
    } else {
        const regex = /^\d{4}-\d{4}$/;
        if (!regex.test(schoolYear)) {
            $('#editSchoolYearError').text('School year must be in format yyyy-yyyy (e.g. 2024-2025)');
            isValid = false;
        } else {
            const years = schoolYear.split('-');
            const firstYear = parseInt(years[0], 10);
            const secondYear = parseInt(years[1], 10);
            
            if (secondYear !== firstYear + 1) {
                $('#editSchoolYearError').text('The second year should be one year after the first year');
                isValid = false;
            }
        }
    }

    return isValid;
}

function processSchoolYear(schoolYearId, action) {
    let formData = new FormData();

    if (action === 'add' || action === 'edit') {
        formData = new FormData(document.getElementById('editSchoolYearForm'));
    } else if (action === 'delete') {
        formData.append('reason', $('#archiveReason').val());
    } else if (action === 'restore') {
        formData.append('school_year_id', $('#restoreSchoolYearId').val());
    }

    if (schoolYearId) {
        formData.append('school_year_id', schoolYearId);
    }
    formData.append('action', action);

    $.ajax({
        url: "../../handler/admin/schoolYearAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();

                if (action === 'restore') {
                    loadArchives(); 
                } else {
                    loadOthersSections(); 
                }

                showToast('Success', 
                    action === 'delete' ? 'School year has been archived.' :
                    action === 'restore' ? 'School year has been restored.' :
                    'School year has been ' + (action === 'edit' ? 'updated' : 'added') + '.', 
                    'success');
            } else if (response.trim() === "duplicate") {
                $('#editSchoolYearError').text('This school year already exists');
            } else {
                alert("Failed to process request: " + response);
            }
        },
        error: function() {
            alert("An error occurred while processing the request.");
        }
    });
}

// SITE MANAGEMENT FUNCTIONS
function openSiteModal(modalId, pageId, action, isActive) {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove(); 
    setTimeout(() => {
        const modal = $('#' + modalId);
        $('#logo-image-preview').hide();
        $('#background-image-preview').hide();
        $('#logo-preview-img').attr('src', '');
        $('#background-preview-img').attr('src', '');
        $('#addEditImage').val('');
        modal.modal('show'); 
        setSitePageId(pageId, action, isActive);
    }, 300);
}

function setSitePageId(pageId, action, isActive) {
    if (pageId === 'carousel_group' && action === 'edit_carousel_group') {
        $.ajax({
            url: "../../handler/admin/getSite.php",
            type: "GET",
            data: { page_type: 'carousel', limit: 4 },
            success: function(response) {
                try {
                    const carousels = JSON.parse(response);
                    $('#editCarouselGroupForm')[0].reset();
                    $('.img-preview').attr('src', '');
                    for (let i = 1; i <= 4; i++) {
                        const carousel = carousels[i-1] || {};
                        $(`#carouselId${i}`).val(carousel.page_id || '');
                        $(`#carouselTitle${i}`).val(carousel.title || '');
                        $(`#carouselActive${i}`).prop('checked', carousel.is_active == 1 || carousel.is_active === '1');
                        if (carousel.image_path) {
                            $(`#carouselPreview${i}`).attr('src', '../../' + carousel.image_path);
                        } else {
                            $(`#carouselPreview${i}`).attr('src', '');
                        }
                    }
                } catch (e) {
                    showToast('Error', 'Failed to load carousel data.', 'danger');
                }
            },
            error: function() {
                showToast('Error', 'Failed to load carousel data.', 'danger');
            }
        });

        $('#editCarouselGroupForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            let valid = false;
            for (let i = 1; i <= 4; i++) {
                if ($(`#carouselId${i}`).val() || $(`#carouselImage${i}`)[0].files.length > 0 || $(`#carouselTitle${i}`).val().trim() !== '') {
                    valid = true;
                    break;
                }
            }
            if (!valid) {
                showToast('Error', 'Please fill at least one carousel image or title.', 'danger');
                return;
            }
            processSite('carousel_group', 'edit_carousel_group');
        });
        return;
    }
    if (action === 'add') {
        $('#addEditSiteForm')[0].reset();
        $('#addEditSiteId').val('');
        $('#addEditPageType').val('');
        clearSiteValidationErrors();
        $('#siteStep1').show();
        $('#siteStep2').hide();
        $('#siteBackBtn').hide();
        $('#siteNextBtn').show();
        $('#siteSaveBtn').hide();
        $('#addEditModalTitle').text('Add New Page');
        $("#addEditSiteForm button[type='submit']").text('Save');
        $('#logo-image-preview').hide();
        $('#logo-preview-img').attr('src', '');
        $('#orgNameGroup').hide();
        $('#schoolNameGroup').hide();
        $('#webNameGroup').hide();
        $('#fbLinkGroup').hide();
    } else if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getSite.php",
            type: "GET",
            data: { page_id: pageId },
            success: function(response) {
                try {
                    const page = JSON.parse(response);
                    $('#addEditSiteId').val(page.page_id);
                    $('#addEditPageType').val(page.page_type);
                    $('#addEditTitle').val(page.title);
                    $('#addEditDescription').val(page.description);
                    $('#addEditContactNo').val(page.contact_no);
                    $('#addEditEmail').val(page.email);
                    $('#addEditOrgName').val(page.org_name || '');
                    $('#addEditSchoolName').val(page.school_name || '');
                    $('#addEditWebName').val(page.web_name || '');
                    $('#addEditFbLink').val(page.fb_link || '');
                    $('#siteStep1').hide();
                    $('#siteStep2').show();
                    $('#siteBackLink').hide();
                    $('#siteNextBtn').hide();
                    $('#siteSaveBtn').show();
                    $('#addEditModalTitle').text('Edit Page');
                    $("#addEditSiteForm button[type='submit']").text('Update');
                    toggleFieldsBasedOnType(page.page_type);
                    clearSiteValidationErrors();
                    if (page.page_type === 'logo' && page.image_path) {
                        $('#logo-image-preview').show();
                        $('#logo-preview-img').attr('src', '../../' + page.image_path);
                    } else {
                        $('#logo-image-preview').hide();
                        $('#logo-preview-img').attr('src', '');
                    }
                    if (page.page_type === 'background' && page.image_path) {
                        $('#background-image-preview').show();
                        $('#background-preview-img').attr('src', '../../' + page.image_path);
                    } else {
                        $('#background-image-preview').hide();
                        $('#background-preview-img').attr('src', '');
                    }
                } catch (e) {
                    showToast('Error', 'Failed to load page details.', 'danger');
                }
            },
            error: function() {
                showToast('Error', 'Failed to load page details.', 'danger');
            }
        });
    } else if (action === 'toggle') {
        if (pageId === 'carousel_group') {
            $('#toggleSiteId').val('carousel_group');
            $('#toggleSiteTitle').text(isActive ? 'Deactivate Carousel' : 'Activate Carousel');
            $('#toggleSiteMessage').text(isActive ? 'Are you sure you want to deactivate all carousel images? They will be hidden from the website.' : 'Are you sure you want to activate all carousel images? They will be visible on the website.');
            $('#confirmToggleSite').removeClass('btn-success btn-warning').addClass(isActive ? 'btn-warning' : 'btn-success').text(isActive ? 'Deactivate All' : 'Activate All');
            $('#toggleSiteModal').modal('show');
            $('#toggleSiteForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                $.ajax({
                    url: '../../handler/admin/siteAction.php',
                    type: 'POST',
                    data: { action: 'toggle_carousel_group', status: isActive ? 0 : 1 },
                    success: function(response) {
                        let result;
                        try {
                            result = typeof response === 'object' ? response : JSON.parse(response);
                        } catch (e) {
                            showToast('Error', 'An error occurred while toggling carousel.', 'danger');
                            return;
                        }
                        if (result.success) {
                            showToast('Success', result.message || 'Carousel status updated.', 'success');
                            $(".modal").modal("hide");
                            $("body").removeClass("modal-open");
                            $(".modal-backdrop").remove();
                            loadPersonalization();
                        } else {
                            showToast('Error', result.message || 'Failed to update carousel status.', 'danger');
                        }
                    },
                    error: function() {
                        showToast('Error', 'An error occurred while toggling carousel.', 'danger');
                    }
                });
            });
        } else {
            $('#toggleSiteId').val(pageId);
            if (isActive) {
                $('#toggleSiteTitle').text('Deactivate Page');
                $('#toggleSiteMessage').text('Are you sure you want to deactivate this page? It will be hidden from the website.');
                $('#confirmToggleSite').removeClass('btn-success').addClass('btn-warning').text('Deactivate');
            } else {
                $('#toggleSiteTitle').text('Activate Page');
                $('#toggleSiteMessage').text('Are you sure you want to activate this page? It will be visible on the website.');
                $('#confirmToggleSite').removeClass('btn-warning').addClass('btn-success').text('Activate');
            }
            $('#toggleSiteModal').modal('show');
            $('#toggleSiteForm').off('submit').on('submit', function(e) {
                e.preventDefault();
                processSite(pageId, 'toggle');
            });
        }
    }

    $('#siteNextBtn').off('click').on('click', function(e) {
        e.preventDefault();
        const pageType = $('#addEditPageType').val();
        if (!pageType) {
            $('#addEditPageType').addClass('is-invalid');
            $('#addEditPageTypeIcon').show();
            $('#addEditPageTypeError').text('Please select a page type');
            return false;
        }
        $('#addEditPageType').removeClass('is-invalid');
        $('#addEditPageTypeIcon').hide();
        $('#addEditPageTypeError').text('');
        $('#siteStep1').hide();
        $('#siteStep2').show();
        $('#siteBackLink').show();
        $('#siteNextBtn').hide();
        $('#siteSaveBtn').show();
        toggleFieldsBasedOnType(pageType);
        clearSiteValidationErrors();
    });

    $('#siteBackLink').off('click').on('click', function(e) {
        e.preventDefault();
        $('#siteStep1').show();
        $('#siteStep2').hide();
        $('#siteBackLink').hide();
        $('#siteNextBtn').show();
        $('#siteSaveBtn').hide();
        $('#addEditModalTitle').text('Add New Page');
    });

    $('#addEditPageType').off('change').on('change', function() {
        if ($('#siteStep2').is(':visible')) {
            toggleFieldsBasedOnType($(this).val());
        }
    });

    $('#addEditSiteForm').off('submit').on('submit', function(e) {
        e.preventDefault();
        if ($('#siteStep2').is(':visible')) {
            if (validateSiteForm(action)) {
                processSite(pageId, action);
            }
        }
    });
    $('#addEditImage').off('change').on('change', function(e) {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(ev) {
                const pageType = $('#addEditPageType').val();
                if (pageType === 'logo') {
                    $('#logo-image-preview').show();
                    $('#logo-preview-img').attr('src', ev.target.result);
                    $('#background-image-preview').hide();
                } else if (pageType === 'background') {
                    $('#background-image-preview').show();
                    $('#background-preview-img').attr('src', ev.target.result);
                    $('#logo-image-preview').hide();
                }
            };
            reader.readAsDataURL(file);
        }
    });
}

function toggleFieldsBasedOnType(pageType) {
    $('#descriptionGroup').hide();
    $('#contactGroup').hide();
    $('#emailGroup').hide();
    $('#imageGroup').hide();
    $('#logo-image-preview').hide();
    $('#background-image-preview').hide();
    $('#orgNameGroup').hide();
    $('#schoolNameGroup').hide();
    $('#webNameGroup').hide();
    $('#fbLinkGroup').hide();
    
    $('#addEditImage').val('');
    $('#logo-preview-img').attr('src', '');
    $('#background-preview-img').attr('src', '');

    if (["logo", "background", "carousel"].includes(pageType)) {
        $('#imageGroup').show();
    } else if (pageType === 'footer') {
        $('#contactGroup').show();
        $('#emailGroup').show();
        $('#orgNameGroup').show();
        $('#schoolNameGroup').show();
        $('#webNameGroup').show();
        $('#fbLinkGroup').show();
    } else {
        $('#descriptionGroup').show();
    }
}

function validateSiteForm(action) {
    let isValid = true;
    clearSiteValidationErrors();
    const pageType = $('#addEditPageType').val();
    const title = $('#addEditTitle').val().trim();
    if (title === '') {
        $('#addEditTitle').addClass('is-invalid');
        $('#addEditTitleIcon').show();
        $('#addEditTitleError').text('Title is required');
        isValid = false;
    } else {
        $('#addEditTitle').removeClass('is-invalid');
        $('#addEditTitleIcon').hide();
        $('#addEditTitleError').text('');
    }

    if (["logo", "background", "carousel"].includes(pageType)) {
        const image = $('#addEditImage')[0].files[0];
        if (!image && $('#logo-preview-img').attr('src') === '' && $('#background-preview-img').attr('src') === '') {
            $('#addEditImage').addClass('is-invalid');
            $('#addEditImageIcon').show();
            $('#addEditImageError').text('Image is required');
            isValid = false;
        } else {
            $('#addEditImage').removeClass('is-invalid');
            $('#addEditImageIcon').hide();
            $('#addEditImageError').text('');
        }
    } else if (pageType === 'footer') {
        const contactNo = $('#addEditContactNo').val().trim();
        if (!contactNo) {
            $('#addEditContactNo').addClass('is-invalid');
            $('#addEditContactNoIcon').show();
            $('#addEditContactNoError').text('Contact number is required');
            isValid = false;
        } else {
            $('#addEditContactNo').removeClass('is-invalid');
            $('#addEditContactNoIcon').hide();
            $('#addEditContactNoError').text('');
        }
        const email = $('#addEditEmail').val().trim();
        if (!email) {
            $('#addEditEmail').addClass('is-invalid');
            $('#addEditEmailIcon').show();
            $('#addEditEmailError').text('Email is required');
            isValid = false;
        } else {
            $('#addEditEmail').removeClass('is-invalid');
            $('#addEditEmailIcon').hide();
            $('#addEditEmailError').text('');
        }
        const orgName = $('#addEditOrgName').val().trim();
        if (!orgName) {
            $('#addEditOrgName').addClass('is-invalid');
            $('#addEditOrgNameIcon').show();
            $('#addEditOrgNameError').text('Organization name is required');
            isValid = false;
        } else {
            $('#addEditOrgName').removeClass('is-invalid');
            $('#addEditOrgNameIcon').hide();
            $('#addEditOrgNameError').text('');
        }
        const schoolName = $('#addEditSchoolName').val().trim();
        if (!schoolName) {
            $('#addEditSchoolName').addClass('is-invalid');
            $('#addEditSchoolNameIcon').show();
            $('#addEditSchoolNameError').text('School name is required');
            isValid = false;
        } else {
            $('#addEditSchoolName').removeClass('is-invalid');
            $('#addEditSchoolNameIcon').hide();
            $('#addEditSchoolNameError').text('');
        }
        const webName = $('#addEditWebName').val().trim();
        if (!webName) {
            $('#addEditWebName').addClass('is-invalid');
            $('#addEditWebNameIcon').show();
            $('#addEditWebNameError').text('Website name is required');
            isValid = false;
        } else {
            $('#addEditWebName').removeClass('is-invalid');
            $('#addEditWebNameIcon').hide();
            $('#addEditWebNameError').text('');
        }
        const fbLink = $('#addEditFbLink').val().trim();
        if (!fbLink) {
            $('#addEditFbLink').addClass('is-invalid');
            $('#addEditFbLinkIcon').show();
            $('#addEditFbLinkError').text('Facebook link is required');
            isValid = false;
        } else {
            $('#addEditFbLink').removeClass('is-invalid');
            $('#addEditFbLinkIcon').hide();
            $('#addEditFbLinkError').text('');
        }
    } else {
        // registration, about, volunteer, calendar, faqs, transparency, home
        const description = $('#addEditDescription').val().trim();
        if (description === '') {
            $('#addEditDescription').addClass('is-invalid');
            $('#addEditDescriptionIcon').show();
            $('#addEditDescriptionError').text('Description is required');
            isValid = false;
        } else {
            $('#addEditDescription').removeClass('is-invalid');
            $('#addEditDescriptionIcon').hide();
            $('#addEditDescriptionError').text('');
        }
    }
    return isValid;
}

function clearSiteValidationErrors() {
    $('#addEditTitleError').text('');
    $('#addEditDescriptionError').text('');
    $('#addEditContactNoError').text('');
    $('#addEditEmailError').text('');
    $('#addEditPageTypeError').text('');
    $('#addEditImageError').text('');
    $('#addEditOrgNameError').text('');
    $('#addEditSchoolNameError').text('');
    $('#addEditWebNameError').text('');
    $('#addEditFbLinkError').text('');
    $('#addEditTitle').removeClass('is-invalid');
    $('#addEditDescription').removeClass('is-invalid');
    $('#addEditContactNo').removeClass('is-invalid');
    $('#addEditEmail').removeClass('is-invalid');
    $('#addEditImage').removeClass('is-invalid');
    $('#addEditOrgName').removeClass('is-invalid');
    $('#addEditSchoolName').removeClass('is-invalid');
    $('#addEditWebName').removeClass('is-invalid');
    $('#addEditFbLink').removeClass('is-invalid');
    $('#addEditTitleIcon').hide();
    $('#addEditDescriptionIcon').hide();
    $('#addEditContactNoIcon').hide();
    $('#addEditEmailIcon').hide();
    $('#addEditImageIcon').hide();
    $('#addEditOrgNameIcon').hide();
    $('#addEditSchoolNameIcon').hide();
    $('#addEditWebNameIcon').hide();
    $('#addEditFbLinkIcon').hide();
}

function processSite(pageId, action) {
    let formData = new FormData();
    if (action === 'edit_carousel_group') {
        formData = new FormData(document.getElementById('editCarouselGroupForm'));
        formData.append('action', 'edit_carousel_group');
    } else if (action === 'edit' || action === 'add') {
        formData = new FormData(document.getElementById('addEditSiteForm'));
        const imageFile = $('#addEditImage')[0].files[0];
        if (imageFile) {
            formData.append('image', imageFile);
        }
    } else if (action === 'toggle') {
        if (pageId === 'carousel_group' || $('#toggleSiteId').val() === 'carousel_group') {
            formData.append('action', 'toggle_carousel_group');
        } else {
            formData.append('page_id', $('#toggleSiteId').val());
            formData.append('action', 'toggle');
        }
    }
    if (pageId && pageId !== 'carousel_group') {
        formData.append('page_id', pageId);
    }
    if (action !== 'toggle' && action !== 'edit_carousel_group') {
        formData.append('action', action);
    }
    $.ajax({
        url: "../../handler/admin/siteAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            let result = response;
            try {
                result = typeof response === 'object' ? response : JSON.parse(response);
            } catch (e) {}
            if (result.success || response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();
                if (typeof loadPersonalization === 'function') {
                    loadPersonalization();
                } else {
                    location.reload();
                }
                showToast('Success',
                    action === 'toggle' ? 'Page status has been updated.' :
                    action === 'add' ? 'New page has been added.' :
                    action === 'edit_carousel_group' ? 'Carousel images updated.' :
                    'Page has been updated.',
                    'success');
            } else if (response.trim().startsWith('error:')) {
                const errorMsg = response.trim().replace('error:', '').trim();
                showToast('Error', errorMsg, 'danger');
            } else {
                showToast('Error', 'Failed to process request: ' + response, 'danger');
            }
        },
        error: function() {
            showToast('Error', 'An error occurred while processing the request.', 'danger');
        }
    });
}

// DAILY PRAYER FUNCTIONS
function openDailyPrayerModal(modalId, prayerId, action) {
    $('.modal').modal('hide');
    $('.modal-backdrop').remove(); 
    setTimeout(() => {
        const modal = $('#' + modalId);
        modal.modal('show'); 
        setDailyPrayerId(prayerId, action);
    }, 300);
}

function setDailyPrayerId(prayerId, action) {
    if (action === 'edit') {
        $.ajax({
            url: "../../handler/admin/getDailyPrayer.php",
            type: "GET",
            data: { prayer_id: prayerId },
            success: function(response) {
                try {
                    const prayer = JSON.parse(response);
                    $('#editPrayerId').val(prayer.prayer_id);
                    $('#editPrayerType').val(prayer.prayer_type);
                    $('#editPrayerDate').val(prayer.date);
                    $('#editPrayerTime').val(prayer.time || '');
                    $('#editPrayerIqamah').val(prayer.iqamah || '');
                    $('#editLocation').val(prayer.location);
                    $('#editDailyPrayerModal .modal-title').text('Edit Prayer Schedule');
                    $('#editDailyPrayerFormSubmit').text('Update Prayer Schedule');
                    clearDailyPrayerValidationErrors();
                    $('#editDailyPrayerModal').modal('show');
                } catch (e) {
                    console.error("Invalid JSON:", response);
                    alert("Failed to load prayer details.");
                }
            },
            error: function() {
                alert("Failed to load prayer details.");
            }
        });

        $('#editDailyPrayerForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateDailyPrayerForm()) {
                processDailyPrayer(prayerId, 'edit');
            }
        });
    } else if (action === 'add') {
        $('#editDailyPrayerForm')[0].reset();
        clearDailyPrayerValidationErrors();
        $('#editDailyPrayerModal .modal-title').text('Add Prayer Schedule');
        $('#editDailyPrayerFormSubmit').text('Add Prayer Schedule');
        $('#editDailyPrayerModal').modal('show');

        $('#editDailyPrayerForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            if (validateDailyPrayerForm()) {
                processDailyPrayer(null, 'add');
            }
        });
    } else if (action === 'delete') {
        $('#archivePrayerId').val(prayerId);
        $('#archiveDailyPrayerModal').modal('show');
    
        $('#confirmArchivePrayer').off('click').on('click', function () {
            const reason = $('#archivePrayerReason').val().trim();
            if (reason === '') {
                $('#archivePrayerReason').addClass('is-invalid');
                $('#archivePrayerReasonIcon').show();
                $('#archivePrayerReasonError').text('Please provide a reason for archiving');
                return;
            }
            $('#archivePrayerReasonError').text('');
            processDailyPrayer(prayerId, 'delete');
        });    
    } else if (action === 'restore') {
        $('#restorePrayerId').val(prayerId);
        $('#restoreDailyPrayerModal').modal('show');

        $('#restoreDailyPrayerForm').off('submit').on('submit', function(e) {
            e.preventDefault();
            processDailyPrayer(prayerId, 'restore');
        });
    }
}

function validateDailyPrayerForm() {
    let isValid = true;
    clearDailyPrayerValidationErrors();

    const prayerType = $('#editPrayerType').val().trim();
    if (prayerType === '') {
        $('#editPrayerType').addClass('is-invalid');
        $('#editPrayerTypeIcon').show();
        $('#editPrayerTypeError').text('Salah is required');
        isValid = false;
    } else {
        $('#editPrayerType').removeClass('is-invalid');
        $('#editPrayerTypeIcon').hide();
        $('#editPrayerTypeError').text('');
    }

    const prayerDate = $('#editPrayerDate').val().trim();
    if (prayerDate === '') {
        $('#editPrayerDate').addClass('is-invalid');
        $('#editPrayerDateIcon').show();
        $('#editPrayerDateError').text('Date is required');
        isValid = false;
    } else {
        $('#editPrayerDate').removeClass('is-invalid');
        $('#editPrayerDateIcon').hide();
        $('#editPrayerDateError').text('');
    }

    const prayerTime = $('#editPrayerTime').val().trim();
    if (prayerTime === '') {
        $('#editPrayerTime').addClass('is-invalid');
        $('#editPrayerTimeIcon').show();
        $('#editPrayerTimeError').text('Adhan is required');
        isValid = false;
    } else {
        $('#editPrayerTime').removeClass('is-invalid');
        $('#editPrayerTimeIcon').hide();
        $('#editPrayerTimeError').text('');
    }

    const prayerIqamah = $('#editPrayerIqamah').val().trim();
    if (prayerIqamah === '') {
        $('#editPrayerIqamah').addClass('is-invalid');
        $('#editPrayerIqamahIcon').show();
        $('#editPrayerIqamahError').text('Iqamah is required');
        isValid = false;
    } else {
        $('#editPrayerIqamah').removeClass('is-invalid');
        $('#editPrayerIqamahIcon').hide();
        $('#editPrayerIqamahError').text('');
    }

    // Location validation
    const location = $('#editLocation').val().trim();
    if (location === '') {
        $('#editLocation').addClass('is-invalid');
        $('#editLocationIcon').show();
        $('#editLocationError').text('Location is required');
        isValid = false;
    } else {
        $('#editLocation').removeClass('is-invalid');
        $('#editLocationIcon').hide();
        $('#editLocationError').text('');
    }

    return isValid;
}

function clearDailyPrayerValidationErrors() {
    $('#editPrayerTypeError').text('');
    $('#editPrayerDateError').text('');
    $('#editPrayerTimeError').text('');
    $('#editPrayerIqamahError').text('');
    $('#editLocationError').text('');
    
    $('#editPrayerType').removeClass('is-invalid');
    $('#editPrayerDate').removeClass('is-invalid');
    $('#editPrayerTime').removeClass('is-invalid');
    $('#editPrayerIqamah').removeClass('is-invalid');
    $('#editLocation').removeClass('is-invalid');
    
    $('#editPrayerTypeIcon').hide();
    $('#editPrayerDateIcon').hide();
    $('#editPrayerTimeIcon').hide();
    $('#editPrayerIqamahIcon').hide();
    $('#editLocationIcon').hide();
}

function processDailyPrayer(prayerId, action) {
    let formData = new FormData();

    if (action === 'add' || action === 'edit') {
        formData = new FormData(document.getElementById('editDailyPrayerForm'));
    } else if (action === 'delete') {
        formData.append('reason', $('#archivePrayerReason').val());
    } else if (action === 'restore') {
        formData.append('prayer_id', $('#restorePrayerId').val());
    }

    if (prayerId) {
        formData.append('prayer_id', prayerId);
    }
    formData.append('action', action);

    $.ajax({
        url: "../../handler/admin/dailyPrayerAction.php",
        type: "POST",
        data: formData,
        processData: false,
        contentType: false,
        success: function(response) {
            if (response.trim() === "success") {
                $(".modal").modal("hide");
                $("body").removeClass("modal-open");
                $(".modal-backdrop").remove();

                if (action === 'restore') {
                    loadArchives(); 
                } else {
                    loadDailyPrayerSection(); 
                }

                showToast('Success', 
                    action === 'delete' ? 'Prayer schedule has been archived.' :
                    action === 'restore' ? 'Prayer schedule has been restored.' :
                    'Prayer schedule has been ' + (action === 'edit' ? 'updated' : 'added') + '.', 
                    'success');
            } else if (response.trim() === "error: missing_required_fields") {
                showToast('Error', 'Please fill in all required fields.', 'error');
            } else if (response.trim() === "error: reason_required") {
                showToast('Error', 'Please provide a reason for archiving.', 'error');
            } else if (response.trim() === "error: prayer_not_found") {
                showToast('Error', 'Prayer schedule not found.', 'error');
            } else if (response.trim() === "error: unauthorized") {
                showToast('Error', 'You are not authorized to perform this action.', 'error');
            } else {
                showToast('Error', 'Failed to process request. Please try again.', 'error');
            }
        },
        error: function() {
            showToast('Error', 'Failed to process request. Please try again.', 'error');
        }
    });
}

function clearValidationErrors() {
    $('.text-danger').text('');
}

$(document).ready(function() {
    initSearchOrgUpdates();
});

$(document).ready(function(){
    $('[data-bs-toggle="tooltip"]').tooltip();
});

$(document).ready(function() {

    $('#studentForm').on('submit', function(e) {
        e.preventDefault();
        
        if (validateStudentForm()) {
            const studentId = $('#enrollmentId').val();
            const action = studentId ? 'edit' : 'add';
            processStudent(studentId, action);
        }
    });

    $('#addEditStudentModal').on('hidden.bs.modal', function () {
        clearValidationErrors();
        $('#studentForm')[0].reset();
        $('#classificationStep').show();
        $('#studentDetailsStep').hide();
        $('#onsiteFields').addClass('d-none');
        $('#onlineFields').addClass('d-none');
        $('#image-preview').hide();
    });

    $('[data-bs-dismiss="modal"]').on('click', function() {
        clearValidationErrors();
        $('#studentForm')[0].reset();
        $('#classificationStep').show();
        $('#studentDetailsStep').hide();
        $('#onsiteFields').addClass('d-none');
        $('#onlineFields').addClass('d-none');
        $('#image-preview').hide();
    });
});

document.getElementById('addEditImage').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const pageType = document.getElementById('addEditPageType').value;
            if (pageType === 'logo') {
                document.getElementById('logo-preview-img').src = e.target.result;
                document.getElementById('logo-image-preview').style.display = 'block';
                document.getElementById('background-image-preview').style.display = 'none';
            } else if (pageType === 'background') {
                document.getElementById('background-preview-img').src = e.target.result;
                document.getElementById('background-image-preview').style.display = 'block';
                document.getElementById('logo-image-preview').style.display = 'none';
            }
        };
        reader.readAsDataURL(file);
    }
});

function loadWacSection() {
    $.ajax({
        url: "../admin/wac.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading WAC section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load WAC section. Please try again.</p>');
        }
    });
}

function loadIlsSection() {
    $.ajax({
        url: "../admin/ils.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading ILS section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load ILS section. Please try again.</p>');
        }
    });
}

function loadMaleSection() {
    $.ajax({
        url: "../admin/officers.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading Male section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Male section. Please try again.</p>');
        }
    });
}


