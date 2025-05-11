<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Settings</title>
    <script src="../../js/profile.js"></script>
    <style>
        :root {
            --palestine-green: #0F8A53;
            --palestine-black: rgb(0, 0, 0);
            --palestine-light: #f8f9fa;
            --palestine-hover: #0a6b3f;
        }

        .container {
            max-width: 1200px;
            padding-top: 0.5rem;
        }

        .card {
            border-radius: 10px;
            margin-bottom: 20px;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            background: #fff;
            padding: 1.25rem;
            border: 1px solid rgba(15, 138, 83, 0.2);
            transition: transform 0.2s ease;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1rem;
            border-bottom: 2px solid var(--palestine-green);
            padding: 0.5rem 0;
            background-color: transparent;
        }

        .card-header h4 {
            margin-bottom: 0;
            font-weight: 600;
            color: var(--palestine-black);
        }

        h5 {
            color: var(--palestine-green);
            font-weight: 600;
            margin-bottom: 0.75rem;
        }

        .text-danger {
            color: #dc3545 !important;
        }

        .form-label {
            font-weight: 500;
            color: var(--palestine-black);
            margin-bottom: 0.5rem;
        }

        .form-control {
            border-radius: 6px;
            border: 1px solid rgba(15, 138, 83, 0.2);
            padding: 0.5rem;
            transition: border-color 0.2s ease;
        }

        .form-control:focus {
            border-color: var(--palestine-green);
            box-shadow: 0 0 0 0.2rem rgba(15, 138, 83, 0.25);
        }

        .form-text {
            color: #6c757d;
            font-size: 0.875rem;
        }

        .btn {
            border-radius: 6px;
            transition: all 0.2s ease;
            border-width: 1.5px;
            box-shadow: none;
            font-weight: 500;
        }

        .btn-outline-secondary {
            color: #6c757d;
            border-color: #6c757d;
        }

        .btn-outline-secondary:hover {
            background-color: #6c757d;
            color: #fff;
            transform: translateY(-1px);
        }

        .btn-primary {
            background-color: var(--palestine-green);
            border-color: var(--palestine-green);
            color: #fff;
        }

        .btn-primary:hover {
            background-color: var(--palestine-hover);
            border-color: var(--palestine-hover);
            transform: translateY(-1px);
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
            transform: translateY(-1px);
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
            color: #fff;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
            transform: translateY(-1px);
        }

        .modal-content {
            border-radius: 10px;
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .modal-header {
            border-bottom: 2px solid var(--palestine-green);
            padding: 1rem 1.5rem;
        }

        .modal-header .modal-title {
            font-weight: 600;
            color: var(--palestine-black);
        }

        .modal-body {
            padding: 1.5rem;
        }

        .modal-footer {
            border-top: 1px solid rgba(15, 138, 83, 0.1);
            padding: 1rem 1.5rem;
        }

        .section-divider {
            margin: 2rem 0;
            border-top: 1px solid rgba(15, 138, 83, 0.1);
        }

        .alert {
            border-radius: 6px;
            padding: 0.75rem 1.25rem;
            margin-bottom: 1rem;
            border: 1px solid transparent;
        }

        @media screen and (max-width: 768px) {
            .container {
                padding: 0.5rem;
            }

            .card-header h4 {
                font-size: 1.3rem;
            }

            h5 {
                font-size: 1rem;
            }

            .card {
                padding: 1rem;
            }

            .form-label,
            .form-control,
            .btn {
                font-size: 0.95rem;
            }
        }

        @media screen and (max-width: 576px) {
            .card-header h4 {
                font-size: 1.2rem;
            }

            h5 {
                font-size: 0.95rem;
            }

            .card {
                padding: 0.875rem;
                margin-bottom: 15px;
            }

            .form-label,
            .form-control,
            .btn {
                font-size: 0.9rem;
            }

            .form-text {
                font-size: 0.8rem;
            }
        }

        @media screen and (max-width: 375px) {
            .container {
                padding: 0.25rem;
            }

            .card-header h4 {
                font-size: 1.1rem;
            }

            h5 {
                font-size: 0.9rem;
                margin-bottom: 0.5rem;
            }

            .card {
                padding: 0.75rem;
                margin-bottom: 12px;
            }

            .form-label,
            .form-control,
            .btn {
                font-size: 0.85rem;
            }

            .form-text {
                font-size: 0.75rem;
            }
        }

        .back-link {
            color: var(--palestine-green);
            font-weight: 500;
            font-size: 1rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            text-decoration: none;
            transition: all 0.3s ease;
            padding: 0.5rem 0;
        }
        .back-link:hover {
            color: var(--palestine-hover);
            transform: translateX(-5px);
            text-decoration: none;
        }
        .back-link i {
            font-size: 0.875rem;
            transition: transform 0.3s ease;
        }
        .back-link:hover i {
            transform: translateX(-3px);
        }
    </style>
</head>

<body>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>Account Settings</h4>
                    <a href="#" class="back-link" onclick="loadProfile(); return false;">
                        <i class="fas fa-arrow-left"></i>
                        <span>Back to Profile</span>
                    </a>
                </div>
                <div class="card-body">
                    <div id="profileAlert" class="alert" style="display: none;"></div>
                    
                    <div class="settings-section">
                        <h5>Personal Information</h5>
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
                            
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="section-divider"></div>
                    
                    <div class="settings-section">
                        <h5>Update Username</h5>
                        <div id="usernameAlert" class="alert" style="display: none;"></div>
                        
                        <form id="usernameForm">
                            <input type="hidden" name="action" value="update_username">
                            
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required>
                                <small class="form-text text-muted">Username must be at least 3 characters long.</small>
                            </div>
                            
                            <div class="text-end">
                                <button type="submit" class="btn btn-primary">Update Username</button>
                            </div>
                        </form>
                    </div>
                    
                    <div class="section-divider"></div>
                    
                    <div class="settings-section">
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
                            
                            <div class="text-end">
                                <button type="submit" class="btn btn-warning">Change Password</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>