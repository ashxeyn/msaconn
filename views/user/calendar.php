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

    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo $base_url; ?>css/calendar.css">
</head>
<body class="calendar-page">
<?php include '../../includes/header.php'; ?>
    <!-- Hero Section -->
    <div class="hero">
        <div class="hero-background"></div> <!-- Background image container -->
        <div class="hero-content">
            <h2>MSA Calendar</h2>
            <p>
                Stay up-to-date with MSA events and activities by checking our calendar regularly. 
                From community service projects to social gatherings, there's something for everyone to enjoy and participate in.
            </p>
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
            <h3 class="mb-4" style="color:#1a541c;"> Daily Prayers Schedule</h3>
            <div style="color:#333; font-size:32px; margin-bottom:12px;">May 5, 2025</div>
            <div class="table-responsive">
                <table class="table table-bordered align-middle prayer-table">
                    <thead class="table-success">
                        <tr>
                            <th>Time</th>
                            <th>Prayer</th>
                            <th>Imam</th>
                            <th>Topic</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Example static rows, replace with dynamic PHP if needed -->
                        <tr>
                            <td>04:30 AM</td>
                            <td>Fajr</td>
                            <td>Imam Ahmad</td>
                            <td>The Importance of Fajr</td>
                            <td>MSA Prayer Hall</td>
                        </tr>
                        <tr>
                            <td>12:15 PM</td>
                            <td>Dhuhr</td>
                            <td>Imam Bilal</td>
                            <td>Unity in Dhuhr</td>
                            <td>MSA Prayer Hall</td>
                        </tr>
                        <tr>
                            <td>03:45 PM</td>
                            <td>Asr</td>
                            <td>Imam Kareem</td>
                            <td>Virtues of Asr</td>
                            <td>MSA Prayer Hall</td>
                        </tr>
                        <tr>
                            <td>06:20 PM</td>
                            <td>Maghrib</td>
                            <td>Imam Yusuf</td>
                            <td>Maghrib Reflections</td>
                            <td>MSA Prayer Hall</td>
                        </tr>
                        <tr>
                            <td>07:45 PM</td>
                            <td>Isha</td>
                            <td>Imam Zayd</td>
                            <td>Isha: Night Prayers</td>
                            <td>MSA Prayer Hall</td>
                        </tr>
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