document.addEventListener('DOMContentLoaded', function () {
    initializeVolunteers();
    initializeAboutContent();
    initializeFAQs();
    initializePrayerSchedules();
    initializeFridayPrayers();
    initializeExecutiveOfficers();
    
    // Initialize toggle for registration type if on the registration form page
    if (document.getElementById('registration_type')) {
        toggleRegistrationTypeFields();
    }
});

// Function to toggle fields based on registration type
function toggleRegistrationTypeFields() {
    const regType = document.getElementById('registration_type').value;
    const onsiteOnlyElements = document.querySelectorAll('.onsite-only');
    const onlineOnlyElements = document.querySelectorAll('.online-only');
    const addressFields = document.querySelector('.form-section.online-only'); // Get the address section
    const optionalIndicator = document.getElementById('optional-indicator');
    
    // Adjust required attributes for college and program fields
    const collegeSelect = document.getElementById('college_id');
    const programSelect = document.getElementById('program_id');
    const yearLevelSelect = document.getElementById('year_level');
    const corFileInput = document.getElementById('cor_file');
    
    if (regType === 'On-site') {
        // Show on-site only elements, hide online only EXCEPT address fields
        onsiteOnlyElements.forEach(el => el.style.display = 'block');
        onlineOnlyElements.forEach(el => {
            if (!el.classList.contains('onsite-only') && el !== addressFields) {
                el.style.display = 'none';
            }
        });
        
        // Always show address fields
        if (addressFields) {
            addressFields.style.display = 'block';
        }
        
        // Make fields required for on-site
        if (collegeSelect) collegeSelect.required = true;
        if (programSelect) programSelect.required = true;
        if (yearLevelSelect) yearLevelSelect.required = true;
        if (corFileInput) corFileInput.required = true;
        
        // Hide optional indicator
        if (optionalIndicator) optionalIndicator.style.display = 'none';
        
    } else if (regType === 'Online') {
        // Show online only elements
        onlineOnlyElements.forEach(el => el.style.display = 'block');
        
        // Make fields optional for online
        if (collegeSelect) collegeSelect.required = false;
        if (programSelect) programSelect.required = false;
        if (yearLevelSelect) yearLevelSelect.required = false;
        if (corFileInput) corFileInput.required = false;
        
        // Show optional indicator
        if (optionalIndicator) optionalIndicator.style.display = 'block';
    }
}

// Function to automatically fill address fields when in on-site mode
function fillAddressFieldsForOnsite() {
    if (document.getElementById('registration_type').value === 'On-site') {
        document.getElementById('region').value = 'Zamboanga Peninsula';
        document.getElementById('province').value = 'Zamboanga City';
        document.getElementById('city').value = 'Zamboanga City';
        document.getElementById('barangay').value = 'Tetuan';
        document.getElementById('street').value = 'MSU Campus';
        document.getElementById('zip_code').value = '7000';
    }
}

// Volunteers Section
function initializeVolunteers() {
    const volunteerGrid = document.getElementById('volunteer-grid');
    const volunteerCount = document.getElementById('volunteer-count');
    if (!volunteerGrid) {
        console.warn('Not on the Volunteer page. Skipping initializeVolunteers.');
        return;
    }

    // Helper function to capitalize each word in a name
    function capitalizeName(name) {
        return name.split(' ')
            .map(word => word.charAt(0).toUpperCase() + word.slice(1).toLowerCase())
            .join(' ');
    }

    async function loadVolunteers() {
        try {
            const response = await fetch('../../handler/user/fetchVolunteers.php');
            const data = await response.json();

            volunteerGrid.innerHTML = '';
            if (data.length > 0) {
                // Update volunteer count
                if (volunteerCount) {
                    volunteerCount.textContent = data.length;
                }
                
                data.forEach(volunteer => {
                    const firstName = capitalizeName(volunteer.first_name);
                    const middleName = volunteer.middle_name ? capitalizeName(volunteer.middle_name) : '';
                    const lastName = capitalizeName(volunteer.last_name);
                    
                    const fullName = middleName ? 
                        `${firstName} ${middleName} ${lastName}` : 
                        `${firstName} ${lastName}`;

                    const volunteerDiv = document.createElement('div');
                    volunteerDiv.classList.add('volunteer');
                    volunteerDiv.innerHTML = `
                        <p class="name">${fullName}</p>
                    `;
                    volunteerGrid.appendChild(volunteerDiv);
                });
            } else {
                if (volunteerCount) {
                    volunteerCount.textContent = 0;
                }
                volunteerGrid.innerHTML = '<p>No volunteers have registered yet.</p>';
            }
        } catch (error) {
            console.error('Error fetching volunteer data:', error);
            if (volunteerCount) {
                volunteerCount.textContent = 0;
            }
            volunteerGrid.innerHTML = '<p>Failed to load volunteer data.</p>';
        }
    }

    // Load volunteers on page load
    loadVolunteers();

    // Poll for updates every 5 seconds
    setInterval(loadVolunteers, 5000);
}

// Prayer Schedule Section
function initializePrayerSchedules() {
    const prayerScheduleContent = document.getElementById('prayer-schedule-content');
    if (!prayerScheduleContent) {
        console.warn('Not on the Prayer Schedule page. Skipping initializePrayerSchedules.');
        return;
    }

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

function initializeFridayPrayers() {
    const prayerScheduleContent = document.getElementById('prayer-schedule-content');
    if (!prayerScheduleContent) {
        console.warn('Prayer schedule content container not found. Skipping initializeFridayPrayers.');
        return;
    }

    // async function fetchFridayPrayers() {
    //     try {
    //         const response = await fetch('../../handler/user/fetchFridayPrayers.php');
    //         const data = await response.json();

    //         if (data.status === 'success') {
    //             updatePrayerScheduleContent(data.data);
    //         } else {
    //             console.error('Error fetching Friday prayers:', data.message);
    //             prayerScheduleContent.innerHTML = '<p>Failed to load Friday prayers.</p>';
    //         }
    //     } catch (error) {
    //         console.error('Error fetching Friday prayers:', error);
    //         prayerScheduleContent.innerHTML = '<p>Failed to load Friday prayers.</p>';
    //     }
    // }

    function updatePrayerScheduleContent(prayers) {
        prayerScheduleContent.innerHTML = ''; // Clear existing content

        if (prayers.length > 0) {
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

            prayers.forEach(prayer => {
                table += `
                    <tr>
                        <td>${prayer.khutbah_date}</td>
                        <td>${new Date(prayer.khutbah_date).toLocaleDateString('en-US', { weekday: 'long' })}</td>
                        <td>${prayer.speaker}</td>
                        <td>${prayer.topic}</td>
                        <td>${prayer.location}</td>
                    </tr>
                `;
            });

            table += '</tbody></table>';
            prayerScheduleContent.innerHTML = table;
        } else {
            prayerScheduleContent.innerHTML = '<p>No Friday prayers available.</p>';
        }
    }

    // Fetch Friday prayers on page load
    fetchFridayPrayers();

    // Poll for updates every 5 seconds
    setInterval(fetchFridayPrayers, 5000);
}

function initializeFAQs() {
    const faqsContent = document.getElementById('faqs-content');
    if (!faqsContent) {
        console.warn('Not on the FAQs page. Skipping initializeFAQs.');
        return;
    }

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
    const aboutUsHero = document.querySelector('.aboutus-hero');
    if (!aboutUsHero) {
        console.warn('Not on the About Us page. Skipping initializeAboutContent.');
        return;
    }

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
        const heroContent = aboutUsHero.querySelector('.hero-content');
        const missionElement = document.querySelector('.mission p');
        const visionElement = document.querySelector('.vision p');

        if (aboutData) {
            if (heroContent) {
                heroContent.innerHTML = `
                    <h2>About Us</h2>
                    <p>${aboutData.description || 'Default description text.'}</p>
                `;
            }

            if (missionElement) {
                missionElement.textContent = aboutData.mission || 'Default mission text.';
            }

            if (visionElement) {
                visionElement.textContent = aboutData.vision || 'Default vision text.';
            }
        } else {
            console.error('No about data available.');
        }
    }

    // Fetch about content on page load
    fetchAboutContent();

    // Poll for updates every 10 seconds
    setInterval(fetchAboutContent, 3000);
}
// Fetch and display downloadable files
async function fetchDownloadableFiles() {
    const container = document.getElementById('downloads-container');
    if (!container) {
        console.log('Downloads container not found, skipping download fetch');
        return;
    }
    
    try {
        const response = await fetch('../../handler/user/fetchDownloadableFiles.php');
        const result = await response.json();

        if (result.status === 'success') {
            const files = result.data;
            if (files.length > 0) {
                container.innerHTML = '';
                files.forEach(file => {
                    // Format the date correctly
                    const uploadDate = new Date(file.created_at);
                    const formattedDate = uploadDate.toLocaleDateString();
                    
                    const fileDiv = document.createElement('div');
                    fileDiv.classList.add('file-item');
                    fileDiv.innerHTML = `
                        <p>${file.file_name} (Uploaded: ${formattedDate})</p>
                        <button onclick="downloadFile(${file.file_id})">Download</button>
                    `;
                    container.appendChild(fileDiv);
                });
            } else {
                container.innerHTML = '<p>No files available for download.</p>';
            }
        } else {
            container.innerHTML = '<p>Error loading files.</p>';
            console.error('Error from server:', result.message);
        }
    } catch (error) {
        console.error('Error fetching files:', error);
        container.innerHTML = '<p>Error loading files.</p>';
    }
}

// Add a specific fix for the about us page header
function fixAboutUsHeader() {
    // Check if we're on the about us page
    const isAboutPage = window.location.href.includes('aboutus');
    if (!isAboutPage) {
        return; // Not on about us page, skip fix
    }
    
    // Force the header to be sticky
    const header = document.querySelector('header');
    if (header) {
        header.style.position = 'sticky';
        header.style.top = '0';
        header.style.zIndex = '99999';
        
        // Add a class that we can target with CSS
        header.classList.add('force-sticky');
        
        console.log('About us page detected: applying sticky header fix');
    }
}

// Run the header fix on page load
document.addEventListener('DOMContentLoaded', function() {
    fixAboutUsHeader();
    // Run other initialization functions
    fetchDownloadableFiles();
    fetchTransparencyData();
    // ... rest of the DOMContentLoaded functions
});

// For good measure, also run it after a small delay to ensure DOM is fully processed
setTimeout(fixAboutUsHeader, 500);

// Trigger file download
function downloadFile(fileId) {
    window.location.href = `../../handler/user/download.php?file_id=${fileId}`;
}

document.addEventListener('DOMContentLoaded', function () {
    fetchTransparencyData();
});

function fetchTransparencyData() {
    fetch('../../handler/user/fetchTransaction.php')
        .then(response => response.json())
        .then(data => {
            const cashInTbody = document.getElementById('cash-in-tbody');
            const cashOutTbody = document.getElementById('cash-out-tbody');

            cashInTbody.innerHTML = '';
            cashOutTbody.innerHTML = '';

            data.forEach(transaction => {
                const row = `
                    <tr>
                        <td>${transaction.report_date}</td>
                        <td>${transaction.expense_detail}</td>
                        <td>${transaction.expense_category}</td>
                        <td>${transaction.amount}</td>
                    </tr>
                `;

                if (transaction.transaction_type === 'Cash In') {
                    cashInTbody.innerHTML += row;
                } else if (transaction.transaction_type === 'Cash Out') {
                    cashOutTbody.innerHTML += row;
                }
            });
        })
        .catch(error => console.error('Error fetching transparency data:', error));
}

// Define region data
const regionData = {
    regions: ['Zamboanga Peninsula'],
    provinces: [
        'Zamboanga del Norte',
        'Zamboanga del Sur',
        'Zamboanga Sibugay',
        'Zamboanga City',
        'Isabela City'
    ],
    cities: {
        'Zamboanga del Norte': ['Dapitan City', 'Dipolog City', 'Katipunan', 'La Libertad', 'Labason', 'Liloy', 'Manukan', 'Polanco', 'Rizal', 'Roxas', 'Sergio Osmeña Sr.', 'Siayan', 'Sindangan', 'Siocon', 'Tampilisan'],
        'Zamboanga del Sur': ['Aurora', 'Bayog', 'Dimataling', 'Dinas', 'Dumalinao', 'Dumingag', 'Guipos', 'Josefina', 'Kumalarang', 'Labangan', 'Lakewood', 'Lapuyan', 'Mahayag', 'Margosatubig', 'Midsalip', 'Molave', 'Pagadian City', 'Pitogo', 'Ramon Magsaysay', 'San Miguel', 'San Pablo', 'Sominot', 'Tabina', 'Tambulig', 'Tigbao', 'Tukuran', 'Vincenzo A. Sagun'],
        'Zamboanga Sibugay': ['Alicia', 'Buug', 'Diplahan', 'Imelda', 'Ipil', 'Kabasalan', 'Mabuhay', 'Malangas', 'Naga', 'Olutanga', 'Payao', 'Roseller Lim', 'Siay', 'Talusan', 'Titay', 'Tungawan'],
        'Zamboanga City': ['Zamboanga City'],
        'Isabela City': ['Isabela City']
    },
    barangays: {
        'Zamboanga City': ['Arena Blanco', 'Ayala', 'Baluno', 'Boalan', 'Bolong', 'Buenavista', 'Bunguiao', 'Busay', 'Cabaluay', 'Cabatangan', 'Calarian', 'Canelar', 'Divisoria', 'Guiwan', 'Lunzuran', 'Putik', 'Recodo', 'San Jose Gusu', 'Sta. Maria', 'Tetuan'],
        'Dipolog City': ['Barra', 'Biasong', 'Central', 'Cogon', 'Dicayas', 'Diwan', 'Estaka', 'Galas', 'Gulayon', 'Lugdungan', 'Magsaysay', 'Olingan', 'Sicayab', 'Sta. Isabel', 'Turno']
    }
};

// Initialize dropdowns
function initializeAddressDropdowns() {
    const regionSelect = document.getElementById('region');
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const barangaySelect = document.getElementById('barangay');

    // Populate Regions
    regionData.regions.forEach(region => {
        const option = document.createElement('option');
        option.value = region;
        option.textContent = region;
        regionSelect.appendChild(option);
    });

    // Handle Region Change
    regionSelect.addEventListener('change', function () {
        const selectedRegion = regionSelect.value;
        provinceSelect.innerHTML = '<option value="">Select Province</option>';
        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

        if (selectedRegion === 'Zamboanga Peninsula') {
            regionData.provinces.forEach(province => {
                const option = document.createElement('option');
                option.value = province;
                option.textContent = province;
                provinceSelect.appendChild(option);
            });
        }
    });

    // Handle Province Change
    provinceSelect.addEventListener('change', function () {
        const selectedProvince = provinceSelect.value;
        citySelect.innerHTML = '<option value="">Select City/Municipality</option>';
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

        if (regionData.cities[selectedProvince]) {
            regionData.cities[selectedProvince].forEach(city => {
                const option = document.createElement('option');
                option.value = city;
                option.textContent = city;
                citySelect.appendChild(option);
            });
        }
    });

    // Handle City Change
    citySelect.addEventListener('change', function () {
        const selectedCity = citySelect.value;
        barangaySelect.innerHTML = '<option value="">Select Barangay</option>';

        if (regionData.barangays[selectedCity]) {
            regionData.barangays[selectedCity].forEach(barangay => {
                const option = document.createElement('option');
                option.value = barangay;
                option.textContent = barangay;
                barangaySelect.appendChild(option);
            });
        }
    });
}

// Initialize the dropdowns on page load
document.addEventListener('DOMContentLoaded', initializeAddressDropdowns);

document.addEventListener('DOMContentLoaded', function () {
    fetchLatestUpdates();
});

function fetchLatestUpdates() {
    const updatesContainer = document.getElementById('updates-container');

    async function loadUpdates() {
        try {
            const response = await fetch('../../handler/user/fetchOrgUpdates.php');
            const result = await response.json();

            if (result.status === 'success') {
                updatesContainer.innerHTML = ''; // Clear existing content
                const updates = result.data;

                if (updates.length > 0) {
                    updates.forEach(update => {
                        const updateItem = document.createElement('div');
                        updateItem.classList.add('update-item');
                        updateItem.innerHTML = `
                            <div class="update-details">
                                <img src="${update.image_path || '../../assets/updates/681333d810dee_eid.jpg'}" alt="${update.title}" class="update-image">
                                <p class="update-date">${new Date(update.created_at).toLocaleDateString()}</p>
                                <h3 class="update-title">${update.title}</h3>
                                <p class="update-content">${update.content}</p>
                            </div>
                        `;
                        updatesContainer.appendChild(updateItem);
                    });
                } else {
                    updatesContainer.innerHTML = '<p>No updates available at the moment.</p>';
                }
            } else {
                updatesContainer.innerHTML = '<p>Failed to load updates.</p>';
            }
        } catch (error) {
            console.error('Error fetching updates:', error);
            updatesContainer.innerHTML = '<p>Error loading updates.</p>';
        }
    }

    // Fetch updates on page load
    loadUpdates();

    // Optionally, poll for updates every 10 seconds
    setInterval(loadUpdates, 5000);
}

function scrollOfficers(direction) {
    // This function is now superseded by the event handlers in designuser.js
    // Prevent default behavior to avoid double-handling
    event.preventDefault();
    return false;
}

// Function to preview image before upload
function previewImage(event) {
    const input = event.target;
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        
        reader.onload = function(e) {
            const previewImg = document.getElementById('preview-img');
            const previewDiv = document.getElementById('image-preview');
            const placeholder = document.getElementById('upload-placeholder');
            
            previewImg.src = e.target.result;
            previewDiv.style.display = 'block';
            placeholder.style.display = 'none';
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

// Function to remove the image preview
function removeImage() {
    const fileInput = document.getElementById('cor_file');
    const previewDiv = document.getElementById('image-preview');
    const placeholder = document.getElementById('upload-placeholder');
    
    fileInput.value = '';
    previewDiv.style.display = 'none';
    placeholder.style.display = 'flex';
}

// Function to load programs based on selected college
function loadProgramsByCollege(collegeId) {
    const programSelect = document.getElementById('program_id');
    
    // Reset program select
    programSelect.innerHTML = '<option value="">Loading programs...</option>';
    
    if (!collegeId) {
        programSelect.innerHTML = '<option value="">Select College First</option>';
        return;
    }
    
    // Fetch programs from server
    fetch(`../../handler/user/fetchProgramsByCollege.php?college_id=${collegeId}`)
        .then(response => response.json())
        .then(data => {
            programSelect.innerHTML = '<option value="">Select Program</option>';
            
            if (data.success && data.data && data.data.length > 0) {
                data.data.forEach(program => {
                    const option = document.createElement('option');
                    option.value = program.program_id;
                    option.textContent = program.program_name;
                    programSelect.appendChild(option);
                });
            } else {
                programSelect.innerHTML = '<option value="">No programs available</option>';
            }
        })
        .catch(error => {
            console.error('Error fetching programs:', error);
            programSelect.innerHTML = '<option value="">Error loading programs</option>';
        });
}

// Executive Officers Section
function initializeExecutiveOfficers() {
    const officersContainer = document.getElementById('executive-officers-container');
    if (!officersContainer) {
        console.warn('Executive officers container not found. Skipping initializeExecutiveOfficers.');
        return;
    }

    // Show loading state immediately
    officersContainer.setAttribute('data-loading', 'true');
    
    // Use a variable to track the fetch state to prevent duplicate requests
    let isFetching = false;
    // Use debounce to prevent multiple fetches during rapid viewport changes
    let debounceTimer = null;

    async function fetchOfficers() {
        // Prevent duplicate fetches
        if (isFetching) return;
        
        isFetching = true;
        
        try {
            // Use fetch with priority hint and cache control
            const controller = new AbortController();
            const timeoutId = setTimeout(() => controller.abort(), 5000); // 5-second timeout
            
            const response = await fetch('../../handler/user/fetchExecutiveOfficers.php', {
                method: 'GET',
                priority: 'high',
                signal: controller.signal,
                headers: {
                    'Cache-Control': 'no-cache',
                    'Pragma': 'no-cache'
                }
            });
            
            clearTimeout(timeoutId);
            
            if (!response.ok) {
                throw new Error(`Server responded with ${response.status}`);
            }
            
            const result = await response.json();

            if (result.status === 'success') {
                updateOfficersContent(result.data);
                officersContainer.setAttribute('data-loading', 'false');
            } else {
                console.error('Error fetching officers:', result.message);
                officersContainer.innerHTML = '<div class="officer-card"><h3>Unable to load officers</h3><p>Please try again later.</p></div>';
                officersContainer.setAttribute('data-loading', 'false');
            }
        } catch (error) {
            console.error('Error fetching officers:', error);
            officersContainer.innerHTML = '<div class="officer-card"><h3>Unable to load officers</h3><p>Please try again later.</p></div>';
            officersContainer.setAttribute('data-loading', 'false');
        } finally {
            isFetching = false;
        }
    }

    function updateOfficersContent(officers) {
        // Performance optimization: prepare content off DOM
        const fragment = document.createDocumentFragment();
        
        if (officers && officers.length > 0) {
            // Get base URL from a meta tag or elsewhere in the page
            const baseUrl = document.querySelector('base')?.href || window.location.origin + '/msaconnect/';
            
            // Determine layout based on viewport width
            const isMobile = window.innerWidth < 576;
            
            // For mobile, limit the number of officers shown initially
            const displayOfficers = isMobile ? officers.slice(0, 4) : officers;
            
            displayOfficers.forEach(officer => {
                const officerCard = document.createElement('div');
                officerCard.classList.add('officer-card');
                
                // Create officer name (with middle initial if available)
                let fullName = `${officer.first_name} `;
                if (officer.middle_name) {
                    fullName += `${officer.middle_name.charAt(0)}. `;
                }
                fullName += officer.last_name;
                
                // Use smaller image paths for mobile to save bandwidth
                const imgSrc = isMobile && officer.picture_small ? 
                    officer.picture_small : officer.picture;
                
                // Create glassmorphism card structure
                officerCard.innerHTML = `
                    <div class="blur-bg"></div>
                    <img src="${imgSrc}" alt="${fullName}" class="officer-image" loading="lazy">
                    <h3 class="officer-name">${fullName}</h3>
                    <p class="officer-position">${officer.position}</p>
                    <p class="officer-bio">Dedicated member of the MSA leadership team serving as ${officer.position}.</p>
                `;
                
                fragment.appendChild(officerCard);
            });
            
            // If on mobile and more officers exist, add a "View More" button
            if (isMobile && officers.length > 4) {
                const viewMoreBtn = document.createElement('button');
                viewMoreBtn.className = 'view-more-btn';
                viewMoreBtn.textContent = 'View All Officers';
                viewMoreBtn.addEventListener('click', () => {
                    // Replace with full officer list
                    updateOfficersContent(officers);
                });
                
                const btnContainer = document.createElement('div');
                btnContainer.className = 'view-more-container';
                btnContainer.appendChild(viewMoreBtn);
                fragment.appendChild(btnContainer);
            }
        } else {
            const placeholderCard = document.createElement('div');
            placeholderCard.classList.add('officer-card');
            placeholderCard.innerHTML = `
                <div class="blur-bg"></div>
                <img src="assets/images/officer.jpg" alt="Officer" class="officer-image">
                <h3 class="officer-name">No Officers Found</h3>
                <p class="officer-position">Please check back later</p>
                <p class="officer-bio">Executive officer information will be updated soon.</p>
            `;
            fragment.appendChild(placeholderCard);
        }
        
        // Clear existing content
        while (officersContainer.firstChild) {
            officersContainer.removeChild(officersContainer.firstChild);
        }
        
        // Add new content in one DOM operation
        officersContainer.appendChild(fragment);
        
        // Trigger a custom event to notify that officers content has been updated
        const event = new CustomEvent('officersUpdated');
        document.dispatchEvent(event);
    }
    
    // Function to fetch data with debounce
    function debouncedFetch() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            fetchOfficers();
        }, 100);
    }
    
    // Listen to orientation change for mobile devices
    window.addEventListener('orientationchange', debouncedFetch);

    // Start fetch after a 10-second delay
    setTimeout(() => {
        fetchOfficers();
    }, 10000);
        
    // Poll for updates - less frequently to avoid animation disruption
    setInterval(fetchOfficers, 10000); // Reduced to once per minute
}