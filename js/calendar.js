document.addEventListener('DOMContentLoaded', function () {
    const monthYearElement = document.getElementById('current-month-year');
    const calendarGrid = document.getElementById('calendar-grid');
    const prevMonthButton = document.getElementById('prev-month');
    const nextMonthButton = document.getElementById('next-month');
    
    // Initialize modal with centered position
    const activityModalEl = document.getElementById('activityModal');
    const activityModal = new bootstrap.Modal(activityModalEl, {
        backdrop: 'static', // Prevent closing on backdrop click for better UX
        keyboard: true,
        focus: true
    });
    
    // Configure modal to be fixed in the center of the screen
    activityModalEl.addEventListener('show.bs.modal', function () {
        // Prevent background scrolling
        document.body.style.overflow = 'hidden';
        
        // Position modal in center (CSS handles most of this now)
        const modalDialog = activityModalEl.querySelector('.modal-dialog');
        
        // Apply any additional positioning if needed at runtime
        modalDialog.style.position = 'fixed';
        
        // Reset any previous inline styles that might interfere
        modalDialog.style.top = '60%';
        modalDialog.style.left = '50%';
        modalDialog.style.transform = 'translate(-50%, -50%)';
    });
    
    // Restore scrolling when modal is hidden
    activityModalEl.addEventListener('hidden.bs.modal', function () {
        document.body.style.overflow = '';
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
            
            // Get activities for this day (including multi-day events)
            const dayActivities = [];
            
            activities.forEach(activity => {
                const startDate = new Date(activity.activity_date);
                const endDate = activity.end_date ? new Date(activity.end_date) : startDate;
                const currentCellDate = new Date(currentDateString);
                
                // Check if this day falls within the activity's date range
                if (currentCellDate >= startDate && currentCellDate <= endDate) {
                    // Create a copy of the activity for this day
                    const activityCopy = {...activity};
                    
                    // Add an indicator if this is a multi-day event
                    if (activity.end_date && activity.activity_date !== currentDateString) {
                        activityCopy.isMultiDay = true;
                        activityCopy.originalStartDate = activity.activity_date;
                    }
                    
                    dayActivities.push(activityCopy);
                }
            });

            if (dayActivities.length > 0) {
                dayCell.classList.add('has-events');
                
                // Limit displayed events to 3 and add "..." for more
                const displayLimit = 3;
                const displayActivities = dayActivities.slice(0, displayLimit);
                
                displayActivities.forEach(activity => {
                    const eventBadge = document.createElement('div');
                    eventBadge.classList.add('event-badge');
                    eventBadge.textContent = activity.title;
                    
                    // Add a class for multi-day events that are not on their start date
                    if (activity.isMultiDay) {
                        eventBadge.classList.add('continued-event');
                    }
                    
                    dayCell.appendChild(eventBadge);
                });
                
                // Add "..." indicator if there are more than 3 events
                if (dayActivities.length > displayLimit) {
                    const moreEventsIndicator = document.createElement('div');
                    moreEventsIndicator.classList.add('event-badge', 'more-events-indicator');
                    moreEventsIndicator.textContent = "...";
                    dayCell.appendChild(moreEventsIndicator);
                }
                
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
                            let multiDayInfo = '';
                            
                            // Add info for multi-day events showing the start date
                            if (activity.isMultiDay) {
                                const startDate = formatDate(activity.originalStartDate);
                                multiDayInfo = `<p class="activity-start-date mb-1 text-event-start"><strong>Started on:</strong> ${startDate}</p>`;
                            }
                            
                            activityElement.innerHTML = `
                                <h5 class="activity-title">${details.title}</h5>
                                <div class="activity-details">
                                    <p class="activity-time mb-1"><strong>Time:</strong> ${details.time || 'N/A'}</p>
                                    <p class="activity-venue mb-1"><strong>Venue:</strong> ${details.venue || 'N/A'}</p>
                                    ${multiDayInfo}
                                    ${details.end_date ? `<p class="activity-end-date mb-1"><strong>Until:</strong> ${formatDate(details.end_date)}</p>` : ''}
                                    <p class="activity-description">${details.description || 'No description available.'}</p>
                                </div>
                            `;
                        } else {
                            // Fallback to basic info if fetch fails
                            let multiDayInfo = '';
                            
                            // Add info for multi-day events showing the start date
                            if (activity.isMultiDay) {
                                const startDate = formatDate(activity.originalStartDate);
                                multiDayInfo = `<p class="activity-start-date mb-1 text-event-start"><strong>Started on:</strong> ${startDate}</p>`;
                            }
                            
                            activityElement.innerHTML = `
                                <h5 class="activity-title">${activity.title}</h5>
                                <div class="activity-details">
                                    ${multiDayInfo}
                                    ${activity.end_date ? `<p class="activity-end-date mb-1"><strong>Until:</strong> ${formatDate(activity.end_date)}</p>` : ''}
                                    <p class="activity-description">${activity.description || 'No description available.'}</p>
                                </div>
                            `;
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching activity details:', error);
                        // Fallback to basic info if fetch fails
                        let multiDayInfo = '';
                        
                        // Add info for multi-day events showing the start date
                        if (activity.isMultiDay) {
                            const startDate = formatDate(activity.originalStartDate);
                            multiDayInfo = `<p class="activity-start-date mb-1 text-event-start"><strong>Started on:</strong> ${startDate}</p>`;
                        }
                        
                        activityElement.innerHTML = `
                            <h5 class="activity-title">${activity.title}</h5>
                            <div class="activity-details">
                                ${multiDayInfo}
                                ${activity.end_date ? `<p class="activity-end-date mb-1"><strong>Until:</strong> ${formatDate(activity.end_date)}</p>` : ''}
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

    // Format date for display
    function formatDate(dateString) {
        if (!dateString) return 'N/A';
        const date = new Date(dateString);
        return date.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
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