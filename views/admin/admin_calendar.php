<?php
date_default_timezone_set('UTC');

$month = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
$year = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

$firstDayOfMonth = strtotime("$year-$month-01");
$daysInMonth = date('t', $firstDayOfMonth);
$startDay = date('w', $firstDayOfMonth);

// Weekday headers
$daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
foreach ($daysOfWeek as $day) {
    echo "<div style='font-weight:bold;'>$day</div>";
}

// Empty cells before the first day
for ($i = 0; $i < $startDay; $i++) {
    echo "<div></div>";
}

// Days of the month
for ($day = 1; $day <= $daysInMonth; $day++) {
    echo "<div class='calendar-day' data-date='$year-$month-$day'>$day</div>";
}
?>
