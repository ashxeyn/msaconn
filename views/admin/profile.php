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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <script src="../../js/admin.js"></script>
    <script src="../../js/modals.js"></script>
    <!-- <?php include '../../includes/head.php'; ?>  -->
    <style>
        :root {
            --palestine-green: #0F8A53;
            --palestine-black: rgb(0, 0, 0);
            --palestine-light: #f8f9fa;
            --palestine-hover: #0a6b3f;
        }

        .container {
            max-width: 1200px;
            padding-top: 3rem;
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

        .card-title {
            font-weight: 600;
            color: var(--palestine-black);
        }

        .table-borderless {
            width: 100%;
        }

        .table-borderless th, 
        .table-borderless td {
            padding: 0.5rem 0;
            border-bottom: 1px solid rgba(15, 138, 83, 0.1);
        }

        .table-borderless th {
            color: var(--palestine-black);
            font-weight: 600;
        }

        .card.bg-light {
            background-color: #f8f9fa !important;
            border: 1px solid rgba(15, 138, 83, 0.1);
            box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        }

        .btn-outline {
            background-color: var(--palestine-black);
            color: white;
            border-color: var(--palestine-black);
            padding: 0.4rem 0.8rem;
            border-radius: 6px;
            transition: all 0.2s ease;
            border-width: 1.5px;
            box-shadow: none;
        }

        .btn-sm {
            padding: 0.25rem 0.5rem;
            font-size: 0.875rem;
        }

        .btn-outline:hover {
            background-color: transparent;
            color: var(--palestine-black);
            border-color: var(--palestine-black);
            transform: translateY(-1px);
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

            .table-borderless td, 
            .table-borderless th {
                font-size: 0.95rem;
            }

            .btn {
                padding: 0.35rem 0.7rem;
                font-size: 0.85rem;
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

            .table-borderless td, 
            .table-borderless th {
                font-size: 0.9rem;
                line-height: 1.4;
            }

            .card-text {
                font-size: 0.9rem;
                line-height: 1.4;
            }

            .btn {
                padding: 0.3rem 0.6rem;
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

            .table-borderless td, 
            .table-borderless th {
                font-size: 0.85rem;
                line-height: 1.3;
            }

            .card-text {
                font-size: 0.85rem;
                line-height: 1.3;
                margin-bottom: 0.5rem;
            }

            .btn {
                padding: 0.25rem 0.5rem;
                font-size: 0.75rem;
            }
        }
    </style>
</head>

<body>

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
                                    <a href="#" class="btn btn-sm btn-outline" onclick="loadSettings()">Update Settings</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>