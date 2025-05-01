<?php
session_start();
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ../login.php");
    exit;
}

$profileObj = new Admin();
$userId = $_SESSION['user_id'];
$userProfile = $profileObj->getUserProfile($userId);

if (!$userProfile) {
    header("Location: ../login.php");
    exit;
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>User Profile</h4>
                </div>
                <div class="card-body">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Personal Information</h5>
                            <table class="table table-borderless">
                                <tr>
                                    <th width="150">Name:</th>
                                    <td>
                                        <?= clean_input($userProfile['first_name'] . ' ' . 
                                            ($userProfile['middle_name'] ? $userProfile['middle_name'] . ' ' : '') . 
                                            $userProfile['last_name']) ?>
                                    </td>
                                </tr>
                                <tr>
                                    <th>Username:</th>
                                    <td><?= clean_input($userProfile['username']) ?></td>
                                </tr>
                                <tr>
                                    <th>Email:</th>
                                    <td><?= clean_input($userProfile['email']) ?></td>
                                </tr>
                                <tr>
                                    <th>Role:</th>
                                    <td><?= clean_input(ucfirst($userProfile['role'])) ?></td>
                                </tr>
                                <tr>
                                    <th>Member Since:</th>
                                    <td><?= date('F j, Y', strtotime($userProfile['created_at'])) ?></td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6">
                            <h5>Account Information</h5>
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="card-title">Security Settings</h6>
                                    <p class="card-text">
                                        Manage your account security by updating your password regularly.
                                        You can change your password in the profile settings.
                                    </p>
                                    <a href="#" class="btn btn-sm btn-outline-primary" onclick="loadSettings()">Update Settings</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>