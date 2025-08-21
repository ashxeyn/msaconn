document.addEventListener('DOMContentLoaded', function () {
    const monthYearElement = document.getElementById('current-month-year');
    const calendarGrid = document.getElementById('calendar-grid');
    const prevMonthButton = document.getElementById('prev-month');
    const nextMonthButton = document.getElementById('next-month');
    
    const activityModalEl = document.getElementById('activityModal');
    const activityModal = new bootstrap.Modal(activityModalEl, {
        backdrop: 'static', 
        keyboard: true,
        focus: true
    });
    
    activityModalEl.addEventListener('show.bs.modal', function () {
        document.body.style.overflow = 'hidden';
        
        const modalDialog = activityModalEl.querySelector('.modal-dialog');
        
        modalDialog.style.position = 'fixed';
        
        modalDialog.style.top = '60%';
        modalDialog.style.left = '50%';
        modalDialog.style.transform = 'translate(-50%, -50%)';
    });
    
    activityModalEl.addEventListener('hidden.bs.modal', function () {
        document.body.style.overflow = '';
    });

    let currentDate = new Date(); 
    let activities = [];

    async function fetchCalendarActivities() {
        try {
            const month = currentDate.getMonth() + 1; 
            const year = currentDate.getFullYear();

            console.log(`Fetching activities for: ${month}-${year}`); 

            const response = await fetch(`../../handler/user/fetchCalendarActivities.php?month=${month}&year=${year}`);
            const data = await response.json();

            if (data.status === 'success') {
                activities = data.data;
                updateCalendar(); 
            } else {
                console.error('Error fetching calendar activities:', data.message);
            }
        } catch (error) {
            console.error('Error fetching calendar activities:', error);
        }
    }

    
    function updateCalendar() {
        const month = currentDate.toLocaleString('default', { month: 'long' });
        const year = currentDate.getFullYear();
        monthYearElement.textContent = `${month} ${year}`;

        
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

        for (let i = 0; i < firstDay; i++) {
            const emptyCell = document.createElement('div');
            emptyCell.classList.add('col');
            calendarGrid.appendChild(emptyCell);
        }

        for (let day = 1; day <= daysInMonth; day++) {
            const dayCell = document.createElement('div');
            dayCell.classList.add('col', 'calendar-cell');

            const dateText = document.createElement('span');
            dateText.classList.add('date-text');
            dateText.textContent = day;
            dayCell.appendChild(dateText);

            const currentDateString = `${currentDate.getFullYear()}-${String(currentDate.getMonth() + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            
            const dayActivities = [];
            
            activities.forEach(activity => {
                const startDate = new Date(activity.activity_date);
                const endDate = activity.end_date ? new Date(activity.end_date) : startDate;
                const currentCellDate = new Date(currentDateString);
                
                if (currentCellDate >= startDate && currentCellDate <= endDate) {
                    const activityCopy = {...activity};
                    
                    if (activity.end_date && activity.activity_date !== currentDateString) {
                        activityCopy.isMultiDay = true;
                        activityCopy.originalStartDate = activity.activity_date;
                    }
                    
                    dayActivities.push(activityCopy);
                }
            });

            if (dayActivities.length > 0) {
                dayCell.classList.add('has-events');
                
                const displayLimit = 3;
                const displayActivities = dayActivities.slice(0, displayLimit);
                
                displayActivities.forEach(activity => {
                    const eventBadge = document.createElement('div');
                    eventBadge.classList.add('event-badge');
                    eventBadge.textContent = activity.title;
                    
                    if (activity.isMultiDay) {
                        eventBadge.classList.add('continued-event');
                    }
                    
                    dayCell.appendChild(eventBadge);
                });
                
                if (dayActivities.length > displayLimit) {
                    const moreEventsIndicator = document.createElement('div');
                    moreEventsIndicator.classList.add('event-badge', 'more-events-indicator');
                    moreEventsIndicator.textContent = "...";
                    dayCell.appendChild(moreEventsIndicator);
                }
                
                dayCell.setAttribute('data-date', currentDateString);
                
                dayCell.addEventListener('click', function() {
                    showActivityModal(currentDateString, dayActivities);
                });
            } else {
                dayCell.setAttribute('data-date', currentDateString);
                dayCell.addEventListener('click', function() {
                    showActivityModal(currentDateString, []);
                });
            }

            calendarGrid.appendChild(dayCell);
        }
    }
    
    function showActivityModal(dateString, activities) {
        const modalDate = new Date(dateString);
        const formattedDate = modalDate.toLocaleDateString('en-US', {
            weekday: 'long',
            year: 'numeric',
            month: 'long',
            day: 'numeric'
        });
        
        document.getElementById('activity-date').textContent = formattedDate;
        
        const detailsContainer = document.getElementById('activity-details-container');
        const noActivitiesMessage = document.getElementById('no-activities-message');
        
        detailsContainer.innerHTML = '';
        
        if (activities.length > 0) {
            noActivitiesMessage.classList.add('d-none');
            detailsContainer.classList.remove('d-none');
            
            activities.forEach((activity, index) => {
                const activityElement = document.createElement('div');
                activityElement.classList.add('activity-item', 'mb-3', 'p-3', 'border', 'rounded');
                
                activityElement.innerHTML = `
                    <div class="text-center py-2">
                        <div class="spinner-border text-success" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                    </div>
                `;
                detailsContainer.appendChild(activityElement);
                
                fetch(`../../handler/user/fetchActivityDetails.php?activity_id=${activity.activity_id}`)
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            const details = data.data;
                            let multiDayInfo = '';
                            
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
                            let multiDayInfo = '';
                            
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
                        let multiDayInfo = '';
                        
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
            noActivitiesMessage.classList.remove('d-none');
            detailsContainer.classList.add('d-none');
        }
        
        activityModal.show();
    }

    function goToPrevMonth() {
        currentDate.setMonth(currentDate.getMonth() - 1);
        fetchCalendarActivities();
    }

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

    function goToNextMonth() {
        currentDate.setMonth(currentDate.getMonth() + 1);
        fetchCalendarActivities();
    }

    function startPolling() {
        fetchCalendarActivities();
        setInterval(fetchCalendarActivities, 10000); 
    }

    prevMonthButton.addEventListener('click', goToPrevMonth);
    nextMonthButton.addEventListener('click', goToNextMonth);

    startPolling();
});