document.addEventListener('DOMContentLoaded', function () {
    const monthYearElement = document.getElementById('current-month-year');
    const calendarGrid = document.getElementById('calendar-grid');
    const prevMonthButton = document.getElementById('prev-month');
    const nextMonthButton = document.getElementById('next-month');
    
    // Initialize modal with centering options
    const activityModalEl = document.getElementById('activityModal');
    const activityModal = new bootstrap.Modal(activityModalEl, {
        backdrop: true,
        keyboard: true,
        focus: true
    });
    
    // Ensure modal is in the center when shown
    activityModalEl.addEventListener('show.bs.modal', function () {
        setTimeout(function() {
            const modalDialog = activityModalEl.querySelector('.modal-dialog');
            modalDialog.style.display = 'flex';
            modalDialog.style.alignItems = 'center';
        }, 200);
    });

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

            if (dayActivities.length > 0) {
                dayCell.classList.add('has-events');
                
                dayActivities.forEach(activity => {
                    const eventBadge = document.createElement('div');
                    eventBadge.classList.add('event-badge');
                    eventBadge.textContent = activity.title;
                    dayCell.appendChild(eventBadge);
                });
                
                // Add the date string as a data attribute
                dayCell.setAttribute('data-date', currentDateString);
                
                // Add click event listener to show the modal
                dayCell.addEventListener('click', function() {
                    showActivityModal(currentDateString, dayActivities);
                });
            } else {
                // Add click event for dates without activities too
                dayCell.setAttribute('data-date', currentDateString);
                dayCell.addEventListener('click', function() {
                    showActivityModal(currentDateString, []);
                });
            }

            calendarGrid.appendChild(dayCell);
        }
    }
    
    // Function to show the activity modal
    function showActivityModal(dateString, activities) {
        // Format the date for display
        const modalDate = new Date(dateString);
        const formattedDate = modalDate.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        // Set the date in the modal
        document.getElementById('activity-date').textContent = formattedDate;
        
        const detailsContainer = document.getElementById('activity-details-container');
        const noActivitiesMessage = document.getElementById('no-activities-message');
        
        // Clear previous content
        detailsContainer.innerHTML = '';
        
        if (activities.length > 0) {
            // Show activities and hide the "no activities" message
            noActivitiesMessage.classList.add('d-none');
            detailsContainer.classList.remove('d-none');
            
            // Add each activity to the modal
            activities.forEach((activity, index) => {
                const activityElement = document.createElement('div');
                activityElement.classList.add('activity-item', 'mb-3', 'p-3', 'border', 'rounded');
                
                // Show loading indicator
                activityElement.innerHTML = `
                    <div class="text-center py-2">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `;
                detailsContainer.appendChild(activityElement);
                
                // Fetch additional details if needed
                fetch(`../../handler/user/fetchActivityDetails.php?activity_id=${activity.activity_id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const details = data.data;
                            activityElement.innerHTML = `
                                <h5 class="activity-title">${details.title}</h5>
                                <div class="activity-details">
                                    <p class="activity-time mb-1"><strong>Time:</strong> ${details.time || 'N/A'}</p>
                                    <p class="activity-venue mb-1"><strong>Venue:</strong> ${details.venue || 'N/A'}</p>
                                    <p class="activity-description">${details.description || 'No description available.'}</p>
                                </div>
                            `;
                        } else {
                            // Fallback to basic info if fetch fails
                            activityElement.innerHTML = `
                                <h5 class="activity-title">${activity.title}</h5>
                                <div class="activity-details">
                                    <p class="activity-description">${activity.description || 'No description available.'}</p>
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching activity details:', error);
                        // Fallback to basic info if fetch fails
                        activityElement.innerHTML = `
                            <h5 class="activity-title">${activity.title}</h5>
                            <div class="activity-details">
                                <p class="activity-description">${activity.description || 'No description available.'}</p>
                            </div>
                        `;
                    });
            });
        } else {
            // Show the "no activities" message and hide the details container
            noActivitiesMessage.classList.remove('d-none');
            detailsContainer.classList.add('d-none');
        }
        
        // Show the modal
        activityModal.show();
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