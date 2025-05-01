$(document).ready(function() {
    loadProfileData();
    
    $("#profileForm").submit(function(e) {
        e.preventDefault();
        $.ajax({
            type: "POST",
            url: "../../handler/admin/profileAction.php",
            data: $(this).serialize(),
            success: function(response) {
                if (response === "success") {
                    showAlert("#profileAlert", "Profile updated successfully!", "success");
                } else if (response === "error_email_exists") {
                    showAlert("#profileAlert", "Email address is already in use by another account.", "danger");
                } else if (response === "error_missing_data") {
                    showAlert("#profileAlert", "Please fill in all required fields.", "danger");
                } else if (response === "error_invalid_email") {
                    showAlert("#profileAlert", "Please enter a valid email address.", "danger");
                } else {
                    showAlert("#profileAlert", "An error occurred while updating your profile.", "danger");
                }
            },
            error: function() {
                showAlert("#profileAlert", "Server error. Please try again later.", "danger");
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
                    showAlert("#usernameAlert", "Username updated successfully!", "success");
                } else if (response === "error_username_exists") {
                    showAlert("#usernameAlert", "Username is already taken by another account.", "danger");
                } else if (response === "error_invalid_username") {
                    showAlert("#usernameAlert", "Username must be at least 3 characters long.", "danger");
                } else {
                    showAlert("#usernameAlert", "An error occurred while updating your username.", "danger");
                }
            },
            error: function() {
                showAlert("#usernameAlert", "Server error. Please try again later.", "danger");
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
                    showAlert("#passwordAlert", "Password changed successfully!", "success");
                    $("#passwordForm")[0].reset();
                } else if (response === "error_password_mismatch") {
                    showAlert("#passwordAlert", "New passwords do not match.", "danger");
                } else if (response === "error_weak_password") {
                    showAlert("#passwordAlert", "Password must be at least 8 characters and include letters and numbers.", "danger");
                } else if (response === "error_incorrect_password") {
                    showAlert("#passwordAlert", "Current password is incorrect.", "danger");
                } else {
                    showAlert("#passwordAlert", "An error occurred while changing your password.", "danger");
                }
            },
            error: function() {
                showAlert("#passwordAlert", "Server error. Please try again later.", "danger");
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
                    showAlert("#deleteAlert", "Your account has been deleted successfully. Redirecting...", "success");
                    setTimeout(function() {
                        window.location.href = "../login.php";
                    }, 3000);
                } else if (response === "error_incorrect_password") {
                    showAlert("#deleteAlert", "Incorrect password. Account deletion failed.", "danger");
                    $("#deleteAccountModal").modal('hide');
                } else {
                    showAlert("#deleteAlert", "An error occurred while deleting your account.", "danger");
                    $("#deleteAccountModal").modal('hide');
                }
            },
            error: function() {
                showAlert("#deleteAlert", "Server error. Please try again later.", "danger");
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
                showAlert("#profileAlert", "Error loading profile data.", "danger");
            }
        });
    }
    
    function showAlert(selector, message, type) {
        $(selector).removeClass("alert-success alert-danger")
            .addClass("alert-" + type)
            .html(message)
            .fadeIn()
            .delay(5000)
            .fadeOut();
    }
});