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
    <?php $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/msaconn/'; ?>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Noto+Naskh+Arabic&display=swap" rel="stylesheet">

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/calendar.css">
</head>
<body class="calendar-page">
<?php include '../../includes/header.php'; ?>
    <div class="hero">
        <?php foreach ($backgroundImage as $image) : ?>
        <div class="hero-background" style="background-image: url('<?php echo $base_url . $image['image_path']; ?>');">
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
    <div class="container my-5">
        <div class="bg-white p-4 rounded shadow">
            <h3 class="mb-4" style="color:#1a541c;">Daily Prayers Schedule</h3>
            <div style="color:#333; font-size:32px; margin-bottom:12px;">
                <?php 
                    $today = date('F d, Y');
                    $dayName = date('l');
                    echo "$today ($dayName)";
                ?>
            </div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle prayer-table">
                    <thead class="table-success">
                        <tr>
                            <th>Time</th>
                            <th>Prayer Type</th>
                            <th>Imam</th>
                            <th>Topic</th>
                            <th>Location</th>
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
                                    <?php echo !empty($prayer['time']) ? date('h:i A', strtotime($prayer['time'])) : '<span class="text-danger">No time set</span>'; ?>
                                </td>
                                <td>
                                    <?= $prayerTypeDisplay ?>
                                    <?php if ($isFriday && $prayer['prayer_type'] === 'jumu\'ah'): ?>
                                        <br><small class="text-muted">(Friday Prayer)</small>
                                    <?php endif; ?>
                                </td>
                                <td><?= clean_input($prayer['speaker']) ?></td>
                                <td><?= clean_input($prayer['topic']) ?></td>
                                <td><?= clean_input($prayer['location']) ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <?php if (!$hasTodayPrayer): ?>
                            <tr>
                                <td colspan="5" class="text-center">No prayer schedules for today</td>
                            </tr>
                        <?php endif; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">No prayer schedules available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <!-- Include Footer -->
    <?php include '../../includes/footer.php'; ?>

    <!-- Activity Details Modal -->
    <div class="modal fade" id="activityModal" tabindex="-1" aria-labelledby="activityModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <!-- "Activity Details" text removed as requested -->
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
    <script src="<?php echo $base_url; ?>js/calendar.js"></script>
</body>
</html>