<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
?>

<script src="../../js/profile.js"></script>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Account Settings</h4>
                    <a href="#" class="btn btn-outline-secondary btn-sm" onclick="loadProfile()">Back to Profile</a>
                </div>
                <div class="card-body">
                    <div id="profileAlert" class="alert" style="display: none;"></div>
                    
                    <form id="profileForm">
                        <input type="hidden" name="action" value="update_profile">
                        
                        <div class="row mb-3">
                            <div class="col-md-4">
                                <label for="first_name" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" required>
                            </div>
                            <div class="col-md-4">
                                <label for="middle_name" class="form-label">Middle Name</label>
                                <input type="text" class="form-control" id="middle_name" name="middle_name">
                            </div>
                            <div class="col-md-4">
                                <label for="last_name" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" required>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="email" class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </form>
                    
                    <hr class="my-4">
                    
                    <h5>Update Username</h5>
                    <div id="usernameAlert" class="alert" style="display: none;"></div>
                    
                    <form id="usernameForm">
                        <input type="hidden" name="action" value="update_username">
                        
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                            <small class="form-text text-muted">Username must be at least 3 characters long.</small>
                        </div>
                        
                        <button type="submit" class="btn btn-primary">Update Username</button>
                    </form>
                    
                    <hr class="my-4">
                    
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

