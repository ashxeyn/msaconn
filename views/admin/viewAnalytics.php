<?php
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$adminObj = new Admin();

$sDate = isset($_GET['start_date']) ? $_GET['start_date'] : '';
$eDate = isset($_GET['end_date']) ? $_GET['end_date'] : '';

$totalVolunteers = $adminObj->getApprovedVolunteers($sDate, $eDate);
$pendingRegistrations = $adminObj->getPedingVolunteers($sDate, $eDate);
$moderators = $adminObj->getModerators(); 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="../../css/analytics.css">
    <script src="../../js/analytics.js"></script>
    <!-- <?php include '../../includes/head.php'; ?>  -->
</head>
<body>

<h2>Dashboard</h2>
<br>
<br>

<div class="row mb-4">
    <div class="col-md-4">
        <label for="sDate" class="form-label">From Date:</label>
        <div class="input-group date">
            <input type="text" class="form-control filter-date" id="sDate" placeholder="From Date" value="<?= $sDate ?>" autocomplete="off">
            <div class="input-group-append">
                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <label for="eDate" class="form-label">To Date:</label>
        <div class="input-group date">
            <input type="text" class="form-control filter-date" id="eDate" placeholder="To Date" value="<?= $eDate ?>" autocomplete="off">
            <div class="input-group-append">
                <span class="input-group-text"><i class="bi bi-calendar"></i></span>
            </div>
        </div>
    </div>

    <div class="col-md-4">
        <label class="form-label">&nbsp;</label>
        <div>
            <button id="clearDate" class="btn btn-secondary">Clear Dates</button>
        </div>
    </div>
</div>

<div id="analyticsContent">
    <div class="stats-container">
        <div class="stat-card">
            <i class="bi bi-people-fill stat-icon"></i>
            <div class="stat-number"><?php echo $totalVolunteers; ?></div>
            <div class="stat-title">Volunteers</div>
        </div>

        <div class="stat-card">
            <i class="bi bi-person-plus-fill stat-icon"></i>
            <div class="stat-number"><?php echo $pendingRegistrations; ?></div>
            <div class="stat-title">Pending Registrations</div>
        </div>

        <div class="stat-card">
            <i class="bi bi-shield-fill stat-icon"></i>
            <div class="stat-number"><?php echo $moderators; ?></div>
            <div class="stat-title">Moderators</div>
        </div>

    </div>

    <div class="chart-container">
        <div class="chart-box">
            <h3>Registered Volunteers</h3>
            <canvas id="volunteersChart"></canvas>
        </div>
        <div class="chart-box">
            <h3>Transparency Report (Cash Flow)</h3>
            <canvas id="transparencyChart"></canvas>
        </div>
    </div>
</div>

</body>
</html>