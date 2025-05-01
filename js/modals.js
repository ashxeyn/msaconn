// STUDENT MODAL TOGGLE FUNCTIONS
function toggleClassificationFields() {
    const classification = $('#classification').val();
    
    if (classification === 'On-site') {
        $('#onsiteFields').removeClass('d-none');
        $('#onlineFields').addClass('d-none');
        
        $('#college').prop('required', true);
        $('#program').prop('required', true);
        $('#yearLevel').prop('required', true);
        $('#image').prop('required', !$('#existing_image').val());
    } else if (classification === 'Online') {
        $('#onsiteFields').addClass('d-none');
        $('#onlineFields').removeClass('d-none');
        
        $('#address').prop('required', true);
        $('#onlineCollege').prop('required', false);
        $('#onlineProgram').prop('required', false);
    } else {
        $('#onsiteFields').addClass('d-none');
        $('#onlineFields').addClass('d-none');
    }
}

function prevStep() {
    $('#studentDetailsStep').hide();
    $('#classificationStep').show();
}

function resetStudentModal() {
    // Clear all form fields
    $('#studentForm')[0].reset();
    
    // Reset form state
    $('#classificationStep').show();
    $('#studentDetailsStep').hide();
    
    // Hide fields
    $('#onsiteFields').addClass('d-none');
    $('#onlineFields').addClass('d-none');
    $('#image-preview').hide();
    
    // Clear validation states
    $('.is-invalid').removeClass('is-invalid');
    $('.text-danger').text('');
    $('.form-control').removeClass('is-invalid');
    $('.form-select').removeClass('is-invalid');
}

$(document).ready(function() {
    // Initialize modal state
    if ($('#enrollmentId').val()) {
        const classification = $('#classification').val();
        if (classification === 'On-site') {
            $('#onsiteFields').removeClass('d-none');
            $('#onlineFields').addClass('d-none');
            $('#college, #program, #yearLevel, #image').prop('required', true);
        } else {
            $('#onsiteFields').addClass('d-none');
            $('#onlineFields').removeClass('d-none');
            $('#address').prop('required', true);
        }
    }

    // Image preview handler
    $('#image').on('change', function() {
        if (this.files.length > 0) {
            $('#image-preview').show();
            const reader = new FileReader();
            reader.onload = function (e) {
                $('#preview-img').attr('src', e.target.result);
            };
            reader.readAsDataURL(this.files[0]);
        }
    });

    // College change handler
    $('#college').on('change', function() {
        const collegeId = $(this).val();
        loadPrograms(collegeId);
    });

    // Classification change handler
    $('#classification').on('change', function() {
        toggleClassificationFields();
    });

    // Modal cleanup handlers
    $('#addEditStudentModal').on('hidden.bs.modal', function () {
        resetStudentModal();
    });

    $('[data-bs-dismiss="modal"]').on('click', function() {
        resetStudentModal();
    });
});

// DataTables initialization
$(document).ready(function() {
    $('#table').DataTable();
    $('#schoolYearsTab').DataTable();
    $('#officerPositionsTab').DataTable();
    $('#collegesTab').DataTable();
    $('#programsTab').DataTable();
    $('#cashinTable').DataTable();
    $('#cashoutTable').DataTable();
    $('#moderatorsTab').DataTable();
    $('#eventTab').DataTable();
    $('#prayerTab').DataTable();
    $('#calendarTab').DataTable();
    $('#cashinTab').DataTable();
    $('#cashoutTab').DataTable();
    $('#faqsTab').DataTable();
    $('#filesTab').DataTable();
    $('#aboutTab').DataTable();
    $('#olTab').DataTable();
    $('#osTab').DataTable();
    $('#officersTab').DataTable();
    $('#volunteersTab').DataTable();
    $('#archivedUpdatesTab').DataTable();
});

