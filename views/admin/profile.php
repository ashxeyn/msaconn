<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>User Profile</h4>
                </div>
                <div class="card-body">
                    <!-- Profile update success/error alerts -->
                    <div id="profileAlert" class="alert" style="display: none;"></div>
                    
                    <!-- Profile Information Form -->
                    <form id="profileForm">
                        <input type="hidden" name="action" value="update_profile">
                        
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="phone_number" class="form-label">Phone Number</label>
                            <input type="text" class="form-control" id="phone_number" name="phone_number">
                        </div>
                        
                        <div class="mb-3">
                            <label for="address" class="form-label">Address</label>
                            <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                    
                    <hr class="my-4">
                    
                    <!-- Change Password Form -->
                    <h5>Change Password</h5>
                    <div id="passwordAlert" class="alert" style="display: none;"></div>
                    
                    <form id="passwordForm">
                        <input type="hidden" name="action" value="change_password">
                        
                        <div class="mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" class="form-control" id="current_password" name="current_password" required>
                        </div>
                        
                        <div class="mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                            <small class="form-text text-muted">Password must be at least 8 characters and include letters and numbers.</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm New Password</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                        
                        <button type="submit" class="btn btn-warning">Change Password</button>
                    </form>
                    
                    <hr class="my-4">
                    
                    <!-- Delete Account Section -->
                    <h5 class="text-danger">Delete Account</h5>
                    <p>Warning: This action cannot be undone. All your data will be permanently deleted.</p>
                    <div id="deleteAlert" class="alert" style="display: none;"></div>
                    
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteAccountModal">
                        Delete My Account
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Account Modal -->
<div class="modal fade" id="deleteAccountModal" tabindex="-1" aria-labelledby="deleteAccountModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteAccountModalLabel">Confirm Account Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you absolutely sure you want to delete your account? This action cannot be undone.</p>
                <form id="deleteAccountForm">
                    <input type="hidden" name="action" value="delete_account">
                    <div class="mb-3">
                        <label for="delete_confirm_password" class="form-label">Enter your password to confirm</label>
                        <input type="password" class="form-control" id="delete_confirm_password" name="confirm_password" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete My Account</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Load user profile data
        $.ajax({
            type: "POST",
            url: "../api/profile/update_profile.php",
            data: { action: "get_profile" },
            dataType: "json",
            success: function(data) {
                // Populate form fields with user data
                $("#first_name").val(data.first_name);
                $("#last_name").val(data.last_name);
                $("#email").val(data.email);
                $("#phone_number").val(data.phone_number);
                $("#address").val(data.address);
            },
            error: function(xhr) {
                showAlert("#profileAlert", "Error loading profile data.", "danger");
            }
        });
        
        // Update Profile Form Submit
        $("#profileForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "../api/profile/update_profile.php",
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
        
        // Change Password Form Submit
        $("#passwordForm").submit(function(e) {
            e.preventDefault();
            $.ajax({
                type: "POST",
                url: "../api/profile/update_profile.php",
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
        
        // Delete Account Button
        $("#confirmDeleteBtn").click(function() {
            $.ajax({
                type: "POST",
                url: "../api/profile/update_profile.php",
                data: $("#deleteAccountForm").serialize(),
                success: function(response) {
                    if (response === "success") {
                        // Show success message and redirect to login after short delay
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
        
        // Helper function to show alerts
        function showAlert(selector, message, type) {
            $(selector).removeClass("alert-success alert-danger")
                .addClass("alert-" + type)
                .html(message)
                .fadeIn()
                .delay(5000)
                .fadeOut();
        }
    });
</script>