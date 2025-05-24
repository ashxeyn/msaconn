<?php
require_once '../../classes/userClass.php';
require_once '../../classes/adminClass.php';
require_once '../../tools/function.php';

$userObj = new User();
$backgroundImage = $userObj->fetchBackgroundImage();
$calendarInfo = $userObj->fetchCalendar();

$adminObj = new Admin();
$calendar = $adminObj->fetchDailyPrayers();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="../../css/calendar.css">
    <link rel="stylesheet" href="../../css/shared-tables.css">
</head>
<body class="calendar-page">
<?php include '../../includes/header.php'; ?>
    <div class="hero">
        <?php foreach ($backgroundImage as $image) : ?>
        <div class="hero-background" style="background-image: url('../../<?= $image['image_path']; ?>');">
        <?php endforeach; ?>
        </div>
        <div class="hero-content">
            <?php foreach ($calendarInfo as $cal) : ?>
                <h2><?php echo $cal['title']; ?></h2>
                <p><?php echo $cal['description']; ?></p> 
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Calendar Section -->
    <div class="calendar-container container my-5">
        <div class="bg-white text-white p-4 rounded shadow">
            <!-- Navigation Controls -->
            <div class="calendar-navigation d-flex justify-content-between align-items-center mb-4">
                <button id="prev-month" class="btn btn-light">← Previous Month</button>
                <h2 id="current-month-year" class="month-year mb-0 fs-3 fw-bold"></h2>
                <button id="next-month" class="btn btn-light">Next Month →</button>
            </div>
            <!-- Calendar Grid -->
            <div id="calendar-grid" class="calendar-grid row row-cols-7 g-2"></div>
        </div>
    </div>

    <!-- 5 Prayers of Islam Table Section -->
    <div style="background-color: #f5f5f5; width: 100%; padding: 40px 0;">
        <div class="container" style="max-width: 1140px; margin: 0 auto;">
            <div class="table-section">
                <h2 style="color:#1a541c; text-align: center; margin-bottom: 15px;">DAILY PRAYER SCHEDULE</h2>
                <div style="color:#333; font-size:32px; margin-bottom:20px; text-align: center;">
                    <?php 
                        $today = date('F d, Y');
                        $dayName = date('l');
                        echo "$today ($dayName)";
                    ?>
                </div>
                <div class="table-container" style="background-color: #ffffff; box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15); border: 1px solid #f0f0f0;">
                    <table class="msa-table">
                        <thead>
                            <tr>
                                <th>Salah</th>
                                <th>Adhan</th>
                                <th>Iqamah</th>
                                <th>MSA Musallah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $todayDate = date('Y-m-d');
                            $hasTodayPrayer = false;
                            if ($calendar):
                                foreach ($calendar as $prayer): 
                                    if ($prayer['date'] !== $todayDate) continue;
                                    $hasTodayPrayer = true;
                                    $prayerTypeDisplay = ucfirst($prayer['prayer_type']);
                                    $isFriday = (date('l', strtotime($prayer['date'])) === 'Friday');
                            ?>
                                <tr>
                                    <td>
                                        <?= $prayerTypeDisplay ?>
                                        <?php if ($isFriday && $prayer['prayer_type'] === 'jumu\'ah'): ?>
                                            <br><small class="text-muted">(Friday Prayer)</small>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo !empty($prayer['time']) ? date('h:i A', strtotime($prayer['time'])) : '<span class="text-danger">No time set</span>'; ?>
                                    </td>
                                    <td>
                                        <?php echo !empty($prayer['iqamah']) ? date('h:i A', strtotime($prayer['iqamah'])) : '<span class="text-danger">No time set</span>'; ?>
                                    </td>
                                    <td><?= clean_input($prayer['location']) ?></td>
                                </tr>
                            <?php endforeach; ?>
                            <?php if (!$hasTodayPrayer): ?>
                                <tr>
                                    <td colspan="4" class="text-center">No prayer schedules for today</td>
                                </tr>
                            <?php endif; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" class="text-center">No prayer schedules available</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Include Footer -->
    <?php include '../../includes/footer.php'; ?>

    <!-- Activity Details Modal - Banner Style -->
    <div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="activityModalLabel">Event Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div id="activity-date" class="mb-2 fw-bold"></div>
                    <div id="activity-details-container" class="activity-details-wrapper">
                        <!-- Activity details will be inserted here dynamically -->
                    </div>
                    <div id="no-activities-message" class="text-center d-none">
                        <p>No activities scheduled for this date.</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Include Calendar JavaScript -->
    <script src="../../js/calendar.js"></script>
    
    <!-- Table Fix Script -->
    <script src="../../js/table-fix.js"></script>
</body>
</html>