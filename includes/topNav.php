<?php
require_once "../../tools/function.php";

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];
$firstLetter = strtoupper(substr($username, 0, 1));

function generateColor($username) {
    $colors = ['#FF5733', '#33B5E5', '#9C27B0', '#FF9800', '#4CAF50', '#3F51B5', '#E91E63'];
    return $colors[ord(substr($username, 0, 1)) % count($colors)];
}

$profileColor = generateColor($username);
?>

<head>
    <link rel="stylesheet" href="../../css/topNav.css"> 
    <script src="../../js/topNavResponsive.js"></script>
    <!-- <?php include 'head.php'; ?>  -->
</head>
<div class="admin-topbar">
        <div class="d-flex align-items-center">
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                    <div class="user-avatar" style="background-color: <?= $profileColor ?>;"><?= $firstLetter ?></div>
                    <span><?= clean_input($username) ?></span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end">
                    <li><h6 class="dropdown-header">Signed in as</h6></li>
                    <li><a class="dropdown-item disabled"><strong><?= clean_input($username) ?></strong></a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item" href="#" onclick="loadProfile()"><i class="bi bi-person-circle me-2"></i> Profile </a></li>
                    <li><a class="dropdown-item" href="#" onclick="loadPersonalization()"><i class="bi bi-globe me-2"></i> Manage Site </a></li>
                    <li><a class="dropdown-item" href="#" onclick="loadArchives()"><i class="bi bi-archive me-2"></i> Archives </a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item text-danger" href="../../accounts/logout"><i class="bi bi-box-arrow-right me-2"></i> Logout</a></li>
                </ul>
            </div>
        </div>
    </div>

