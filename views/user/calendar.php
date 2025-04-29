<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calendar</title>
    <?php $base_url = 'http://' . $_SERVER['HTTP_HOST'] . '/msaconnect/'; ?>

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

    <!-- Include Footer -->
    <?php include '../../includes/footer.php'; ?>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Include Calendar JavaScript -->
    <script src="<?php echo $base_url; ?>js/calendar.js"></script>
</body>
</html>