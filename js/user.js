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
            question.addEventListener('click', (e) => {
                // Get the answer element
                const answer = question.nextElementSibling;
                
                // Toggle the current question/answer pair
                question.classList.toggle('open');
                answer.classList.toggle('open');
                
                // Stop event propagation to prevent issues
                e.stopPropagation();
            });
        });
    }

    // Fetch FAQs on page load only, don't poll
    fetchFaqs();
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

document.addEventListener('DOMContentLoaded', function() {
    // Run other initialization functions
    fetchDownloadableFiles();
    fetchTransparencyData();
    // ... rest of the DOMContentLoaded functions
});


function downloadFile(fileId) {
    window.location.href = `../../handler/user/download.php?file_id=${fileId}`;
}

document.addEventListener('DOMContentLoaded', function () {
    fetchTransparencyData();
});

function fetchTransparencyData() {
    const cashInTbody = document.getElementById('cash-in-tbody');
    const cashOutTbody = document.getElementById('cash-out-tbody');
    
    // Return early if elements don't exist on this page
    if (!cashInTbody || !cashOutTbody) {
        console.log('Transparency tables not found on this page');
        return;
    }
    
    fetch('../../handler/user/fetchTransaction.php')
        .then(response => response.json())
        .then(data => {
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
        'Zamboanga del Norte': [
            'Dapitan City',
            'Dipolog City',
            'Katipunan',
            'La Libertad',
            'Labason',
            'Liloy',
            'Manukan',
            'Polanco',
            'Rizal',
            'Roxas',
            'Sergio Osmeña Sr.',
            'Siayan',
            'Sindangan',
            'Siocon',
            'Tampilisan'
        ],
        'Zamboanga del Sur': [
            'Aurora',
            'Bayog',
            'Dimataling',
            'Dinas',
            'Dumalinao',
            'Dumingag',
            'Guipos',
            'Josefina',
            'Kumalarang',
            'Labangan',
            'Lakewood',
            'Lapuyan',
            'Mahayag',
            'Margosatubig',
            'Midsalip',
            'Molave',
            'Pagadian City',
            'Pitogo',
            'Ramon Magsaysay',
            'San Miguel',
            'San Pablo',
            'Sominot',
            'Tabina',
            'Tambulig',
            'Tigbao',
            'Tukuran',
            'Vincenzo A. Sagun'
        ],
        'Zamboanga Sibugay': [
            'Alicia',
            'Buug',
            'Diplahan',
            'Imelda',
            'Ipil',
            'Kabasalan',
            'Mabuhay',
            'Malangas',
            'Naga',
            'Olutanga',
            'Payao',
            'Roseller Lim',
            'Siay',
            'Talusan',
            'Titay',
            'Tungawan'
        ],
        'Zamboanga City': ['Zamboanga City'],
        'Isabela City': ['Isabela City']
    },
    barangays: {
        'Zamboanga City': [
            'Arena Blanco',
            'Ayala',
            'Baluno',
            'Boalan',
            'Bolong',
            'Buenavista',
            'Bunguiao',
            'Busay',
            'Cabaluay',
            'Cabatangan',
            'Calarian',
            'Canelar',
            'Divisoria',
            'Guiwan',
            'Lunzuran',
            'Putik',
            'Recodo',
            'San Jose Gusu',
            'Sta. Maria',
            'Tetuan'
        ],
        'Dipolog City': [
            'Barra',
            'Biasong',
            'Central',
            'Cogon',
            'Dicayas',
            'Diwan',
            'Estaka',
            'Galas',
            'Gulayon',
            'Lugdungan',
            'Magsaysay',
            'Olingan',
            'Sicayab',
            'Sta. Isabel',
            'Turno'
        ],
        'Pagadian City': [
            'Balangasan',
            'Balintawak',
            'Baliwasan',
            'Baloyboan',
            'Banale',
            'Bogo Capalaran',
            'Buenavista',
            'Bulatok',
            'Bulatin',
            'Dampalan',
            'Dao',
            'Gatas',
            'Kahayagan',
            'Lumbia',
            'Muricay',
            'Napolan',
            'Pulangbato',
            'San Jose',
            'San Pedro',
            'Tiguma'
        ],
        'Dapitan City': [
            'Bagting',
            'Baylimango',
            'Burgos',
            'Cogon',
            'Ilihan',
            'Kalipunan',
            'La Libertad',
            'Linguisan',
            'Masidlakon',
            'Sulangon'
        ],
        'Isabela City': [
            'Aguada',
            'Balatanay',
            'Binuangan',
            'Busay',
            'Cabunbata',
            'Candiis',
            'Cauitan',
            'Lanote',
            'Malamawi',
            'Tabuk'
        ],
        'Ipil': [
            'Bacalan',
            'Baluran',
            'Bunguiao',
            'Don Andres',
            'Guintolan',
            'Labrador',
            'Sanito',
            'Sibugay',
            'Taway',
            'Tiayon'
        ]
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
    
    // Return early if the container doesn't exist on this page
    if (!updatesContainer) {
        console.log('Updates container not found on this page');
        return;
    }

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

// Create text-only officer card (no image)
function createTextOnlyOfficerCard(officer, branchName) {
    const officerCard = document.createElement('div');
    officerCard.classList.add('officer-card', 'text-only-card');
    
    // Create officer name (with middle initial if available)
    let fullName = `${officer.first_name} `;
    if (officer.middle_name) {
        fullName += `${officer.middle_name.charAt(0)}. `;
    }
    fullName += officer.last_name;
    
    // Convert name to uppercase
    fullName = fullName.toUpperCase();
    
    // Create card HTML (without image)
    officerCard.innerHTML = `
        <div class="blur-bg"></div>
        <h3 class="officer-name">${fullName}</h3>
        <p class="officer-position">${officer.position}</p>
        <p class="officer-bio">Dedicated member of the ${branchName} serving as ${officer.position}.</p>
    `;
    
    return officerCard;
}

// Create officer card with picture
function createOfficerCard(officer, baseUrl) {
    const officerCard = document.createElement('div');
    officerCard.classList.add('officer-card');
    
    // Create officer name (with middle initial if available)
    let fullName = `${officer.first_name} `;
    if (officer.middle_name) {
        fullName += `${officer.middle_name.charAt(0)}. `;
    }
    fullName += officer.last_name;
    
    // Convert name to uppercase
    fullName = fullName.toUpperCase();
    
    // Determine if mobile for image size
    const isMobile = window.innerWidth < 576;
    const imgSrc = isMobile && officer.picture_small ? 
        officer.picture_small : officer.picture;
    
    // Create card HTML
    officerCard.innerHTML = `
        <div class="blur-bg"></div>
        <img src="${imgSrc}" alt="${fullName}" class="officer-image" loading="lazy">
        <h3 class="officer-name">${fullName}</h3>
        <p class="officer-position">${officer.position}</p>
        <p class="officer-bio">Dedicated member of the MSA leadership team serving as ${officer.position}.</p>
    `;
    
    return officerCard;
}

// Executive Officers Section
function initializeExecutiveOfficers() {
    // Check if we're on the right page
    if (!document.querySelector('.executive-officers')) {
        console.warn('Executive officers section not found. Skipping initializeExecutiveOfficers.');
        return;
    }
    // Set loading state
    const adviserContainer = document.getElementById('adviser-container');
    const maleGrid = document.getElementById('male-officers-grid');
    const wacGrid = document.getElementById('wac-officers-grid');
    const ilsGrid = document.getElementById('ils-officers-grid');
    
    if (maleGrid) maleGrid.setAttribute('data-loading', 'true');
    if (wacGrid) wacGrid.setAttribute('data-loading', 'true');
    if (ilsGrid) ilsGrid.setAttribute('data-loading', 'true');
    
    // Use variables to track fetch state
    let isFetching = false;
    let debounceTimer = null;
    async function fetchOfficers() {
        // Prevent duplicate fetches
        if (isFetching) return;
        
        isFetching = true;
        try {
            // Fetch with priority hint and cache control
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
                if (maleGrid) maleGrid.setAttribute('data-loading', 'false');
                if (wacGrid) wacGrid.setAttribute('data-loading', 'false');
                if (ilsGrid) ilsGrid.setAttribute('data-loading', 'false');
            } else {
                console.error('Error fetching officers:', result.message);
                showErrorState();
            }
        } catch (error) {
            console.error('Error fetching officers:', error);
            showErrorState();
        } finally {
            isFetching = false;
        }
    }
    function showErrorState() {
        const errorCard = `
            <div class="officer-card">
                <div class="blur-bg"></div>
                <img src="assets/images/officer.jpg" alt="Officer" class="officer-image">
                <h3 class="officer-name">UNABLE TO LOAD OFFICERS</h3>
                <p class="officer-position">Please try again later</p>
                <p class="officer-bio">There was a problem retrieving officer information.</p>
            </div>
        `;
        if (adviserContainer) adviserContainer.innerHTML = errorCard;
        if (maleGrid) maleGrid.innerHTML = errorCard;
        if (wacGrid) wacGrid.innerHTML = errorCard;
        if (ilsGrid) ilsGrid.innerHTML = errorCard;
        
        if (maleGrid) maleGrid.setAttribute('data-loading', 'false');
        if (wacGrid) wacGrid.setAttribute('data-loading', 'false');
        if (ilsGrid) ilsGrid.setAttribute('data-loading', 'false');
    }
    function updateOfficersContent(officersByBranch) {
        // Get base URL from a meta tag or elsewhere in the page
        const baseUrl = document.querySelector('base')?.href || window.location.origin + '/msaconnect/';
        
        // Process advisers and consultants
        if (adviserContainer && officersByBranch.adviser && officersByBranch.adviser.length > 0) {
            const adviserFragment = document.createDocumentFragment();
            
            // Sort advisers by position_id (primary) and then by role (secondary)
            const sortedAdvisers = officersByBranch.adviser.sort((a, b) => {
                // First try to sort by position_id
                const posA = parseInt(a.position_id) || 999;
                const posB = parseInt(b.position_id) || 999;
                if (posA !== posB) {
                    return posA - posB; // Sort by position_id first
                }
                
                // If position_ids are the same, sort by role (Advisers before Consultants)
                if (a.position === 'Adviser' && b.position === 'Consultant') return -1;
                if (a.position === 'Consultant' && b.position === 'Adviser') return 1;
                return 0;
            });
            
            sortedAdvisers.forEach(officer => {
                const officerCard = createOfficerCard(officer, baseUrl);
                adviserFragment.appendChild(officerCard);
            });
            
            // Clear and update adviser container
            while (adviserContainer.firstChild) {
                adviserContainer.removeChild(adviserContainer.firstChild);
            }
            
            adviserContainer.appendChild(adviserFragment);
            adviserContainer.style.display = 'flex'; // Ensure it's visible
        } else if (adviserContainer) {
            adviserContainer.style.display = 'none';
        }
        
        // Process male officers
        if (maleGrid) {
            updateBranchOfficers(maleGrid, officersByBranch.male || [], baseUrl);
        }
        
        // Process WAC officers
        if (wacGrid) {
            updateBranchOfficers(wacGrid, officersByBranch.wac || [], baseUrl);
        }
        
        // Process ILS officers
        if (ilsGrid) {
            updateBranchOfficers(ilsGrid, officersByBranch.ils || [], baseUrl);
        }
        
        // Trigger a custom event to notify that officers content has been updated
        const event = new CustomEvent('officersUpdated');
        document.dispatchEvent(event);
    }
    
    function updateBranchOfficers(gridContainer, officers, baseUrl) {
        const fragment = document.createDocumentFragment();
        const isWAC = gridContainer.id === 'wac-officers-grid';
        const branchType = gridContainer.id.split('-')[0]; // 'male', 'wac', or 'ils'
        
        if (officers && officers.length > 0) {
            // Sort officers by position_id (where lower numbers come first)
            officers.sort((a, b) => {
                // Use parseInt to ensure numeric comparison
                const posA = parseInt(a.position_id) || 999; // Default to a high number if not available
                const posB = parseInt(b.position_id) || 999;
                return posA - posB; // Lower numbers first
            });
            
            // Determine layout based on viewport width
            const isMobile = window.innerWidth < 576;
            
            // Check if we're already showing all officers
            const isShowingAll = gridContainer.dataset.showingAll === 'true';
            
            // For mobile, limit the number of officers shown initially UNLESS we're showing all
            const displayOfficers = (isMobile && !isShowingAll) ? officers.slice(0, 4) : officers;
            
            displayOfficers.forEach(officer => {
                let officerCard;
                
                // Always use text-only cards for WAC
                if (isWAC) {
                    officerCard = createTextOnlyOfficerCard(officer, "Women's Affairs Committee");
                } else {
                    // For other sections, check if there's a real image
                    const hasDefaultImage = officer.picture && officer.picture.includes('default-profile.png');
                    
                    if (hasDefaultImage) {
                        // Use text-only card for officers without images
                        const branchName = gridContainer.id === 'male-officers-grid' ? 
                            'Executive Officers' : 'ILS';
                        officerCard = createTextOnlyOfficerCard(officer, branchName);
                    } else {
                        // Use card with image
                        officerCard = createOfficerCard(officer, baseUrl);
                    }
                }
                    
                fragment.appendChild(officerCard);
            });
            
            // Show or hide the View More button based on mobile and officer count
            const viewMoreContainer = document.querySelector(`#${branchType}-container .view-more-container`);
            const viewMoreButton = viewMoreContainer ? viewMoreContainer.querySelector('.view-more-btn') : null;
            
            if (viewMoreContainer) {
                if (isMobile && officers.length > 4) {
                    viewMoreContainer.style.display = 'block';
                    
                    // Update button text based on current state
                    if (viewMoreButton) {
                        viewMoreButton.textContent = isShowingAll ? 'Show Less' : 'View All Officers';
                    }
                    
                    // Initialize data attribute if not set
                    if (!gridContainer.hasAttribute('data-showing-all')) {
                        gridContainer.dataset.showingAll = 'false';
                    }
                } else {
                    viewMoreContainer.style.display = 'none';
                }
            }
        } else {
            const placeholderCard = document.createElement('div');
            placeholderCard.classList.add('officer-card');
            
            // Always use text-only placeholder
            placeholderCard.innerHTML = `
                <div class="blur-bg"></div>
                <h3 class="officer-name">NO OFFICERS FOUND</h3>
                <p class="officer-position">Please check back later</p>
                <p class="officer-bio">Officer information will be updated soon.</p>
            `;
            
            fragment.appendChild(placeholderCard);
            
            // Hide view more button when no officers
            const viewMoreContainer = document.querySelector(`#${branchType}-container .view-more-container`);
            if (viewMoreContainer) {
                viewMoreContainer.style.display = 'none';
            }
        }
        
        // Clear existing content
        while (gridContainer.firstChild) {
            gridContainer.removeChild(gridContainer.firstChild);
        }
        
        // Add new content
        gridContainer.appendChild(fragment);
    }
    
    // Function to fetch data with debounce
    function debouncedFetch() {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            fetchOfficers();
        }, 100);
    }
    
    // Add event listeners
    window.addEventListener('orientationchange', debouncedFetch);

    // Start fetch
    fetchOfficers();
    
    // Poll for updates less frequently
    setInterval(fetchOfficers, 5000); // Every 5 seconds
}

// Function to switch between officer tabs
function switchOfficerTab(branchType) {
    // Hide all branch containers
    const containers = document.querySelectorAll('.officer-branch-container');
    containers.forEach(container => {
        container.classList.remove('active');
    });
    
    // Show selected branch container
    const selectedContainer = document.getElementById(`${branchType}-container`);
    if (selectedContainer) {
        selectedContainer.classList.add('active');
    }
    
    // Update tab buttons
    const tabButtons = document.querySelectorAll('.tab-button');
    tabButtons.forEach(button => {
        button.classList.remove('active');
    });
    
    const selectedTab = document.getElementById(`tab-${branchType}`);
    if (selectedTab) {
        selectedTab.classList.add('active');
    }
}

// Function to show all officers in a branch tab when view all button is clicked
function viewAllOfficers(branchType) {
    // Get the container for this branch
    const gridContainer = document.getElementById(`${branchType}-officers-grid`);
    const viewMoreContainer = document.querySelector(`#${branchType}-container .view-more-container`);
    const viewMoreButton = viewMoreContainer ? viewMoreContainer.querySelector('.view-more-btn') : null;
    
    if (!gridContainer || !viewMoreContainer || !viewMoreButton) {
        console.error('Required elements not found for viewAllOfficers');
        return;
    }

    // Check if we're currently showing all officers or not
    const isShowingAll = gridContainer.dataset.showingAll === 'true';
    
    // Add loading indicator
    gridContainer.setAttribute('data-loading', 'true');
    
    // If we're already showing all, collapse back to showing just 4
    if (isShowingAll) {
        // Fetch the data again to get original view
        fetch('../../handler/user/fetchExecutiveOfficers.php', {
            method: 'GET',
            headers: {
                'Cache-Control': 'no-cache',
                'Pragma': 'no-cache'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error(`Server responded with ${response.status}`);
            return response.json();
        })
        .then(result => {
            if (result.status === 'success') {
                // Get officers for this branch
                const officers = result.data[branchType] || [];
                const baseUrl = document.querySelector('base')?.href || window.location.origin + '/msaconnect/';
                
                // Sort officers by position_id
                officers.sort((a, b) => {
                    const posA = parseInt(a.position_id) || 999;
                    const posB = parseInt(b.position_id) || 999;
                    return posA - posB; // Lower numbers first
                });
                
                // Only show first 4 officers
                const displayOfficers = officers.slice(0, 4);
                
                // Clear grid
                while (gridContainer.firstChild) {
                    gridContainer.removeChild(gridContainer.firstChild);
                }
                
                // Create and append cards for display officers
                displayOfficers.forEach(officer => {
                    let officerCard;
                    const isWAC = branchType === 'wac';
                    
                    if (isWAC) {
                        officerCard = createTextOnlyOfficerCard(officer, "Women's Affairs Committee");
                    } else {
                        const hasDefaultImage = officer.picture && officer.picture.includes('default-profile.png');
                        if (hasDefaultImage) {
                            const branchName = branchType === 'male' ? 'Executive Officers' : 'ILS';
                            officerCard = createTextOnlyOfficerCard(officer, branchName);
                        } else {
                            officerCard = createOfficerCard(officer, baseUrl);
                        }
                    }
                    gridContainer.appendChild(officerCard);
                });
                
                // Update button text and data attribute
                viewMoreButton.textContent = 'View All Officers';
                gridContainer.dataset.showingAll = 'false';
            }
        })
        .catch(error => console.error('Error fetching officers:', error))
        .finally(() => {
            gridContainer.setAttribute('data-loading', 'false');
        });
    } else {
        // Show all officers
        fetch('../../handler/user/fetchExecutiveOfficers.php', {
            method: 'GET',
            headers: {
                'Cache-Control': 'no-cache',
                'Pragma': 'no-cache'
            }
        })
        .then(response => {
            if (!response.ok) throw new Error(`Server responded with ${response.status}`);
            return response.json();
        })
        .then(result => {
            if (result.status === 'success') {
                // Get all officers for this branch
                const allOfficers = result.data[branchType] || [];
                const baseUrl = document.querySelector('base')?.href || window.location.origin + '/msaconnect/';
                
                // Sort officers by position_id
                allOfficers.sort((a, b) => {
                    const posA = parseInt(a.position_id) || 999;
                    const posB = parseInt(b.position_id) || 999;
                    return posA - posB; // Lower numbers first
                });
                
                // Clear grid
                while (gridContainer.firstChild) {
                    gridContainer.removeChild(gridContainer.firstChild);
                }
                
                // Create and append cards for all officers
                allOfficers.forEach(officer => {
                    let officerCard;
                    const isWAC = branchType === 'wac';
                    
                    if (isWAC) {
                        officerCard = createTextOnlyOfficerCard(officer, "Women's Affairs Committee");
                    } else {
                        const hasDefaultImage = officer.picture && officer.picture.includes('default-profile.png');
                        if (hasDefaultImage) {
                            const branchName = branchType === 'male' ? 'Executive Officers' : 'ILS';
                            officerCard = createTextOnlyOfficerCard(officer, branchName);
                        } else {
                            officerCard = createOfficerCard(officer, baseUrl);
                        }
                    }
                    gridContainer.appendChild(officerCard);
                });
                
                // Update button text and data attribute
                viewMoreButton.textContent = 'Show Less';
                gridContainer.dataset.showingAll = 'true';
            }
        })
        .catch(error => console.error('Error fetching officers:', error))
        .finally(() => {
            gridContainer.setAttribute('data-loading', 'false');
        });
    }
}