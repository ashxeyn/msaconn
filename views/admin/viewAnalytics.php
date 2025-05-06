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
    <meta name="viewport" width="device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <script src="../../js/analytics.js"></script>
    <style>
        :root {
            --palestine-green: #0F8A53;
            --palestine-black: rgb(0, 0, 0);
            --palestine-light: #f8f9fa;
            --palestine-hover: #0a6b3f;
            --table-border: #e0e0e0;
        }

        .admin-container {
            max-width: 1200px;
            padding-top: 3rem;
        }

        .admin-page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid var(--palestine-green);
            padding: 0.5rem 0;
        }

        #clearDate {
            background-color: var(--palestine-black);
            color: #fff;
            border: none;
        }

        .filter-container {
            background: #fff;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border: 1px solid rgba(15, 138, 83, 0.2);
        }

        .filter-row {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            align-items: flex-end;
        }

        .filter-group {
            flex: 1;
            min-width: 200px;
        }

        .filter-group:last-child {
        display: flex;
        justify-content: flex-end; 
        }

        .filter-label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--palestine-black);
        }

        .input-group.date {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group.date input {
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem !important;
            border: 1.5px solid var(--palestine-black) !important;
            border-radius: 8px !important;
            transition: all 0.3s ease !important;
            width: 100%;
        }

        .input-group.date input:focus {
            outline: none !important;
            border-color: var(--palestine-green) !important;
            box-shadow: 0 0 0 2px rgba(15, 138, 83, 0.25) !important;
        }

        .input-group-append {
            position: absolute;
            right: 10px;
            pointer-events: none;
        }

        .input-group-text {
            background: transparent;
            border: none;
            color: var(--palestine-black);
        }

        .btn-secondary {
            padding: 0.5rem 1rem;
            background-color: #6c757d;
            border-color: #6c757d;
            color: white;
            border-radius: 8px;
            transition: all 0.2s ease;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
            transform: translateY(-1px);
        }

        .stats-container {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1rem; 
            margin-bottom: 1.5rem;  
        }

        .stat-card {
            background: #fff;
            border-radius: 10px;
            padding: 1rem;  
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border: 1px solid rgba(15, 138, 83, 0.2);
            transition: transform 0.3s;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            min-width: 0;  
        }

        .stat-card:hover {
            transform: translateY(-5px);
        }

        .stat-icon {
            font-size: 1.5rem;  /* Smaller icon */
            color: var(--palestine-green);
            margin-bottom: 0.5rem;
        }

        .stat-number {
            font-size: 2rem;  /* Smaller number */
            font-weight: 700;
            color: var(--palestine-black);
            margin-bottom: 0.25rem;
        }

        .stat-title {
            font-size: 0.9rem;  /* Smaller title */
            color: #6c757d;
        }

        .chart-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr);  /* Two columns */
            gap: 1.5rem;
        }

        .chart-box {
            background: #fff;
            border-radius: 10px;
            padding: 1rem;  /* Reduced padding */
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            border: 1px solid rgba(15, 138, 83, 0.2);
        }

        .chart-box h3 {
            color: var(--palestine-green);
            font-size: 1.1rem;  /* Smaller heading */
            margin-bottom: 1rem;
            text-align: center;
        }

        canvas {
            width: 100% !important;
            height: 300px !important;  /* Reduced height */
        }

        @media (max-width: 992px) {
            .chart-container {
                grid-template-columns: 1fr;  /* Stack on medium screens */
            }
        }

        @media (max-width: 768px) {
            .stats-container {
                grid-template-columns: repeat(2, 1fr);  /* 2 columns on tablets */
            }
            
            canvas {
                height: 250px !important;
            }
        }

        @media (max-width: 576px) {
            .admin-container {
                padding-top: 1.5rem;
            }
            
            .chart-box {
                padding: 1rem;
            }
            
            .stats-container {
                grid-template-columns: 1fr;  /* 1 column on mobile */
            }
            
            .stat-card {
                padding: 0.75rem;
            }
            
            .stat-number {
                font-size: 1.75rem;
            }
            
            canvas {
                height: 200px !important;
            }
        }
    </style>
</head>

<body>
<div class="admin-container">
    <div class="admin-page-header">
        <h3><strong>Dashboard</strong></h3>
    </div>

    <div class="filter-container">
        <div class="filter-row">
            <div class="filter-group">
                <div class="input-group date">
                    <input type="text" class="form-control filter-date" id="sDate" placeholder="From Date" value="<?= $sDate ?>" autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                    </div>
                </div>
            </div>

            <div class="filter-group">
                <div class="input-group date">
                    <input type="text" class="form-control filter-date" id="eDate" placeholder="To Date" value="<?= $eDate ?>" autocomplete="off">
                    <div class="input-group-append">
                        <span class="input-group-text"><i class="bi bi-calendar"></i></span>
                    </div>
                </div>
            </div>

            <div class="filter-group">
                <button id="clearDate" class="btn btn-secondary" style="width: 50%;">Clear Dates</button>
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
</div>

</body>
</html>