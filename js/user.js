document.addEventListener('DOMContentLoaded', function () {
    console.log(document.getElementById('prayer-schedule-content')); // Should not be null
    console.log(document.getElementById('faqs-content')); // Should not be null
    console.log(document.getElementById('volunteer-grid')); // Should not be null

    initializeVolunteers();
    initializePrayerSchedules();
    initializeFAQs();
    initializeAboutContent(); // Initialize the about content dynamically
});

// Volunteers Section
function initializeVolunteers() {
    const volunteerGrid = document.getElementById('volunteer-grid');

    async function loadVolunteers() {
        try {
            const response = await fetch('../../handler/user/fetchVolunteers.php');
            const data = await response.json();

            volunteerGrid.innerHTML = '';

            if (data.length > 0) {
                data.forEach(volunteer => {
                    const volunteerDiv = document.createElement('div');
                    volunteerDiv.classList.add('volunteer');
                    volunteerDiv.innerHTML = `
                        <p class="name">${volunteer.first_name} ${volunteer.last_name}</p>
                    `;
                    volunteerGrid.appendChild(volunteerDiv);
                });
            } else {
                volunteerGrid.innerHTML = '<p>No volunteers have registered yet.</p>';
            }
        } catch (error) {
            console.error('Error fetching volunteer data:', error);
            volunteerGrid.innerHTML = '<p>Failed to load volunteer data.</p>';
        }
    }

    // Load volunteers on page load
    loadVolunteers();

    // Poll for updates every 5 seconds
    setInterval(loadVolunteers, 3000);
}

// Prayer Schedule Section
function initializePrayerSchedules() {
    const prayerScheduleContent = document.getElementById('prayer-schedule-content');

    async function fetchPrayerSchedules() {
        try {
            const response = await fetch('../../handler/user/fetchPrayerSchedule.php');
            const data = await response.json();

            if (data.status === 'success') {
                updatePrayerScheduleContent(data.data);
            } else {
                console.error('Error fetching prayer schedules:', data.message);
                prayerScheduleContent.innerHTML = '<p>Failed to load prayer schedules.</p>';
            }
        } catch (error) {
            console.error('Error fetching prayer schedules:', error);
            prayerScheduleContent.innerHTML = '<p>Failed to load prayer schedules.</p>';
        }
    }

    function updatePrayerScheduleContent(schedules) {
        prayerScheduleContent.innerHTML = ''; // Clear existing content

        if (schedules.length > 0) {
            let table = `
                <table>
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Day</th>
                            <th>Khateeb</th>
                            <th>Topic</th>
                            <th>Location</th>
                        </tr>
                    </thead>
                    <tbody>
            `;

            schedules.forEach(schedule => {
                table += `
                    <tr>
                        <td>${schedule.khutbah_date}</td>
                        <td>${new Date(schedule.khutbah_date).toLocaleDateString('en-US', { weekday: 'long' })}</td>
                        <td>${schedule.speaker}</td>
                        <td>${schedule.topic}</td>
                        <td>${schedule.location}</td>
                    </tr>
                `;
            });

            table += '</tbody></table>';
            prayerScheduleContent.innerHTML = table;
        } else {
            prayerScheduleContent.innerHTML = '<p>No prayer schedules available.</p>';
        }
    }

    // Fetch prayer schedules on page load
    fetchPrayerSchedules();

    // Poll for updates every 5 seconds
    setInterval(fetchPrayerSchedules, 3000);
}

function initializeFAQs() {
    const faqsContent = document.getElementById('faqs-content');

    async function fetchFaqs() {
        try {
            const response = await fetch('../../handler/user/fetchFaqs.php');
            const data = await response.json();
            if (data.status === 'success') {
                updateFaqs(data.data);
            } else {
                console.error('Error fetching FAQs:', data.message);
            }
        } catch (error) {
            console.error('Error fetching FAQs:', error);
        }
    }

    function updateFaqs(faqs) {
        let currentCategory = null;
        let html = '';
        faqs.forEach(faq => {
            if (currentCategory !== faq.category) {
                if (currentCategory !== null) {
                    html += '</div>'; // Close previous category section
                }
                currentCategory = faq.category;
                html += `<h3>${faq.category}</h3>`;
                html += '<div class="faq-category">';
            }
            html += `
                <div class="faq-item">
                    <div class="faq-question">
                        ${faq.question}
                        <span class="arrow">▼</span>
                    </div>
                    <div class="faq-answer">
                        ${faq.answer.replace(/\n/g, '<br>')}
                    </div>
                </div>
            `;
        });
        if (currentCategory !== null) {
            html += '</div>'; // Close the last category section
        }
        faqsContent.innerHTML = html;
        // Reattach event listeners for toggling FAQ answers
        attachFaqListeners();
    }

    function attachFaqListeners() {
        const faqQuestions = document.querySelectorAll('.faq-question');
        faqQuestions.forEach(question => {
            question.addEventListener('click', () => {
                const answer = question.nextElementSibling;
                question.classList.toggle('open');
                answer.classList.toggle('open');
            });
        });
    }

    // Fetch FAQs on page load
    fetchFaqs();

    // Poll for updates every 5 seconds
    setInterval(fetchFaqs, 3000);
}
function initializeAboutContent() {
    const heroContent = document.querySelector('.hero-content');
    const missionElement = document.querySelector('.mission p');
    const visionElement = document.querySelector('.vision p');

    async function fetchAboutContent() {
        try {
            const response = await fetch('../../handler/user/fetchMissionAndVision.php');
            const data = await response.json();

            if (data.status === 'success') {
                updateAboutContent(data.data);
            } else {
                console.error('Error fetching about content:', data.message);
            }
        } catch (error) {
            console.error('Error fetching about content:', error);
        }
    }

    function updateAboutContent(aboutData) {
        if (aboutData) {
            heroContent.innerHTML = `
                <h2>About Us</h2>
                <p>${aboutData.description || 'Default description text.'}</p>
            `;
            missionElement.textContent = aboutData.mission || 'Default mission text.';
            visionElement.textContent = aboutData.vision || 'Default vision text.';
        } else {
            console.error('No about data available.');
        }
    }

    // Fetch about content on page load
    fetchAboutContent();

    // Poll for updates every 10 seconds
    setInterval(fetchAboutContent, 3000);
}
function initializeDownloadableFiles() {
    const downloadsList = document.getElementById('downloads-list');

    async function fetchDownloadableFiles() {
        try {
            const response = await fetch('../../handler/user/fetchDownloadableFiles.php');
            const data = await response.json();

            if (data.status === 'success') {
                updateDownloadsList(data.data);
            } else {
                console.error('Error fetching downloadable files:', data.message);
                downloadsList.innerHTML = '<p>Failed to load downloadable files.</p>';
            }
        } catch (error) {
            console.error('Error fetching downloadable files:', error);
            downloadsList.innerHTML = '<p>Failed to load downloadable files.</p>';
        }
    }

    function updateDownloadsList(files) {
        downloadsList.innerHTML = ''; // Clear existing content

        if (files.length > 0) {
            files.forEach(file => {
                const fileItem = document.createElement('div');
                fileItem.classList.add('download-item');
                fileItem.innerHTML = `
                    <p class="file-name">${file.file_name}</p>
                    <a href="../../handler/user/download.php?file_id=${file.file_id}" class="download-link" download>
                        Download
                    </a>
                `;
                downloadsList.appendChild(fileItem);
            });
        } else {
            downloadsList.innerHTML = '<p>No downloadable files available.</p>';
        }
    }

    // Fetch downloadable files on page load
    fetchDownloadableFiles();

    // Poll for updates every 10 seconds
    setInterval(fetchDownloadableFiles, 5000);
}






