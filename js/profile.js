$(document).ready(function() {
    loadProfileData();

    function showToastProfile(title, message, type) {
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

    
    $("#profileForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "../../handler/admin/profileAction.php",
            data: $(this).serialize(),
            success: function(response) {
                if (response === "success") {
                    showToastProfile('Success', 'Profile updated successfully!', 'success');
                } else if (response === "error_email_exists") {
                    showToastProfile('Error', 'Email address is already in use by another account.', 'danger');
                } else if (response === "error_missing_data") {
                    showToastProfile('Error', 'Please fill in all required fields.', 'danger');
                } else if (response === "error_invalid_email") {
                    showToastProfile('Error', 'Please enter a valid email address.', 'danger');
                } else {
                    showToastProfile('Error', 'An error occurred while updating your profile.', 'danger');
                }
            },
            error: function() {
                showToastProfile('Error', 'Server error. Please try again later.', 'danger');
            }
        });
    });
    
    $("#usernameForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "../../handler/admin/profileAction.php",
            data: $(this).serialize(),
            success: function(response) {
                if (response === "success") {
                    showToastProfile('Success', 'Username updated successfully!', 'success');
                } else if (response === "error_username_exists") {
                    showToastProfile('Error', 'Username is already taken by another account.', 'danger');
                } else if (response === "error_invalid_username") {
                    showToastProfile('Error', 'Username must be at least 3 characters long.', 'danger');
                } else {
                    showToastProfile('Error', 'An error occurred while updating your username.', 'danger');
                }
            },
            error: function() {
                showToastProfile('Error', 'Server error. Please try again later.', 'danger');
            }
        });
    });
    
    $("#passwordForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "../../handler/admin/profileAction.php",
            data: $(this).serialize(),
            success: function(response) {
                if (response === "success") {
                    showToastProfile('Success', 'Password changed successfully!', 'success');
                    $("#passwordForm")[0].reset();
                } else if (response === "error_password_mismatch") {
                    showToastProfile('Error', 'New passwords do not match.', 'danger');
                } else if (response === "error_weak_password") {
                    showToastProfile('Error', 'Password must be at least 8 characters and include letters and numbers.', 'danger');
                } else if (response === "error_incorrect_password") {
                    showToastProfile('Error', 'Current password is incorrect.', 'danger');
                } else {
                    showToastProfile('Error', 'An error occurred while changing your password.', 'danger');
                }
            },
            error: function() {
                showToastProfile('Error', 'Server error. Please try again later.', 'danger');
            }
        });
    });
    
    $("#confirmDeleteBtn").click(function() {
        $.ajax({
            type: "POST",
            url: "../../handler/admin/profileAction.php",
            data: $("#deleteAccountForm").serialize(),
            success: function(response) {
                if (response === "success") {
                    $("#deleteAccountModal").modal('hide');
                    showToastProfile('Success', 'Your account has been deleted successfully. Redirecting...', 'success');
                    setTimeout(function() {
                        window.location.href = "../login.php";
                    }, 3000);
                } else if (response === "error_incorrect_password") {
                    showToastProfile('Error', 'Incorrect password. Account deletion failed.', 'danger');
                    $("#deleteAccountModal").modal('hide');
                } else {
                    showToastProfile('Error', 'An error occurred while deleting your account.', 'danger');
                    $("#deleteAccountModal").modal('hide');
                }
            },
            error: function() {
                showToastProfile('Error', 'Server error. Please try again later.', 'danger');
                $("#deleteAccountModal").modal('hide');
            }
        });
    });
    
    function loadProfileData() {
        $.ajax({
            type: "POST",
            url: "../../handler/admin/profileAction.php",
            data: { action: "get_profile" },
            dataType: "json",
            success: function(data) {
                $("#first_name").val(data.first_name);
                $("#middle_name").val(data.middle_name);
                $("#last_name").val(data.last_name);
                $("#email").val(data.email);
                $("#username").val(data.username);
            },
            error: function() {
                showToastProfile('Error', 'Error loading profile data.', 'danger');
            }
        });
    }
});