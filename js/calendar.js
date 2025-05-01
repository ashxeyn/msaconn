document.addEventListener('DOMContentLoaded', function () {
    const monthYearElement = document.getElementById('current-month-year');
    const calendarGrid = document.getElementById('calendar-grid');
    const prevMonthButton = document.getElementById('prev-month');
    const nextMonthButton = document.getElementById('next-month');

    let currentDate = new Date(); // Initialize with today's date
    let activities = [];

    // Fetch calendar activities from the server
    async function fetchCalendarActivities() {
        try {
            const month = currentDate.getMonth() + 1; // Months are 0-based
            const year = currentDate.getFullYear();

            console.log(`Fetching activities for: ${month}-${year}`); // Debugging log

            const response = await fetch(`../../handler/user/fetchCalendarActivities.php?month=${month}&year=${year}`);
            const data = await response.json();

            if (data.status === 'success') {
                activities = data.data;
                updateCalendar(); // Update the calendar after fetching activities
            } else {
                console.error('Error fetching calendar activities:', data.message);
            }
        } catch (error) {
            console.error('Error fetching calendar activities:', error);
        }
    }

    // Update the calendar header and grid
    function updateCalendar() {
        const month = currentDate.toLocaleString('default', { month: 'long' });
        const year = currentDate.getFullYear();
        monthYearElement.textContent = `${month} ${year}`;

        // Clear the calendar grid
        calendarGrid.innerHTML = `
            <div class="col text-center fw-medium">Sun</div>
            <div class="col text-center fw-medium">Mon</div>
            <div class="col text-center fw-medium">Tue</div>
            <div class="col text-center fw-medium">Wed</div>
            <div class="col text-center fw-medium">Thu</div>
            <div class="col text-center fw-medium">Fri</div>
            <div class="col text-center fw-medium">Sat</div>
        `;

        const firstDay = new Date(currentDate.getFullYear(), currentDate.getMonth(), 1).getDay();
        const daysInMonth = new Date(currentDate.getFullYear(), currentDate.getMonth() + 1, 0).getDate();

        // Add empty cells for days before the first day of the month
        for (let i = 0; i < firstDay; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.classList.add('col');
            calendarGrid.appendChild(emptyCell);
        }

        // Add cells for each day of the month
        for (let day = 1; day <= daysInMonth; day++) {
            const dayCell = document.createElement('div');
            dayCell.classList.add('col', 'calendar-cell');

            const dateText = document.createElement('span');
            dateText.classList.add('date-text');
            dateText.textContent = day;
            dayCell.appendChild(dateText);

            const currentDateString = `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const dayActivities = activities.filter(activity => activity.activity_date === currentDateString);

            dayActivities.forEach(activity => {
                const eventBadge = document.createElement('div');
                eventBadge.classList.add('event-badge');
                eventBadge.textContent = activity.title;
                dayCell.appendChild(eventBadge);
            });

            calendarGrid.appendChild(dayCell);
        }
    }

    // Go to the previous month
    function goToPrevMonth() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        fetchCalendarActivities();
    }

    // Go to the next month
    function goToNextMonth() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        fetchCalendarActivities();
    }

    // Poll for updates every 10 seconds
    function startPolling() {
        fetchCalendarActivities(); // Fetch activities initially
        setInterval(fetchCalendarActivities, 10000); // Poll every 10 seconds
    }

    // Add event listeners for navigation buttons
    prevMonthButton.addEventListener('click', goToPrevMonth);
    nextMonthButton.addEventListener('click', goToNextMonth);

    // Initialize the calendar and start polling
    startPolling();
});