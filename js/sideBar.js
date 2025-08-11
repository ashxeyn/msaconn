// SIDEBAR FUNCTIONS
function loadProgramSection() {
    $.ajax({
        url: "../admin/schoolConfig2.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading Program section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Program section. Please try again.</p>');
        }
    });
}

function loadDashboardSection() {
    $.ajax({
        url: "../admin/viewAnalytics.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading dashboard section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Dashboard section. Please try again.</p>');
        }
    });
}

function loadSchoolConfigSection() {
    $.ajax({
        url: "../admin/schoolConfig.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading school configuration section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load School Configuration section. Please try again.</p>');
        }
    });
}

function loadSchoolConfigSection2() {
    $.ajax({
        url: "../admin/schoolConfig2.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading school configuration section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load School Configuration section. Please try again.</p>');
        }
    });
}

function loadExecutivePositionsSection() {
    $.ajax({
        url: "../admin/executivePositions.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading executive positions section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Executive Positions section. Please try again.</p>');
        }
    });
}

function loadOthersSection() {
    $.ajax({
        url: "../admin/others.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading others section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Others section. Please try again.</p>');
        }
    });
}

function loadEventsSection() {
    $.ajax({
        url: "../admin/events.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading events section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Events section. Please try again.</p>');
        }
    });
}

function loadCalendarSection() {
    $.ajax({
        url: "../admin/calendar.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading calendar section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Calendar section. Please try again.</p>');
        }
    });
}

function loadTransparencySection() {
    const schoolYearId = $('#schoolYearSelect').val();
    const semester = $('#semesterSelect').val();
    const startDate = $('#startDate').val();
    const endDate = $('#endDate').val();
    
    const params = {};
    if (schoolYearId) params.school_year_id = schoolYearId;
    if (semester) params.semester = semester;
    if (startDate) params.start_date = startDate;
    if (endDate) params.end_date = endDate;
    
    $.ajax({
        url: "../admin/transparency.php",
        method: 'GET',
        data: params,
        success: function (response) {
            $('#contentArea').html(response);
            initDatepickers(); 
        },
        error: function (xhr, status, error) {
            console.error('Error loading transparency section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Transparency section. Please try again.</p>');
        }
    });
}

function loadAboutsSection() {
    $.ajax({
        url: "../admin/abouts.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading abouts section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Abouts section. Please try again.</p>');
        }
    });
}

function loadFaqsSection() {
    $.ajax({
        url: "../admin/faqs.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading FAQs section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load FAQs section. Please try again.</p>');
        }
    });
}

function loadOfficersSection() {
    $.ajax({
        url: "../admin/officers.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading officers section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Officers section. Please try again.</p>');
        }
    });
}

function loadVolunteersSection() {
    $.ajax({
        url: "../admin/volunteers.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading volunteers section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Volunteers section. Please try again.</p>');
        }
    });
}

function loadModeratorsSection() {
    $.ajax({
        url: "../admin/moderators.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading moderators section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Moderators section. Please try again.</p>');
        }
    });
}

function loadRegistrationsSection() {
    $.ajax({
        url: "../admin/registrations.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading registration section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Registration section. Please try again.</p>');
        }
    });
}

function loadPrayerSchedSection() {
    $.ajax({
        url: "../admin/prayer.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading prayer schedule section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Prayer Schedule section. Please try again.</p>');
        }
    });
}

function loadDailyPrayerSection() {
    $.ajax({
        url: "../admin/dailyPrayer.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading prayer schedule section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Prayer Schedule section. Please try again.</p>');
        }
    });
}

function loadDownloadablesSection() {
    $.ajax({
        url: "../admin/downloadables.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading bylaws section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Bylaws section. Please try again.</p>');
        }
    });
}

function loadEnrollmentSection() {
    $.ajax({
        url: "../admin/enrollment.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading enrollment section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Enrollment section. Please try again.</p>');
        }
    });
}

function loadDonationSection() {
    $.ajax({
        url: "../admin/donations.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading donations section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Donations section. Please try again.</p>');
        }
    });
}

function loadStudentsSection() {
    $.ajax({
        url: "../admin/students.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading students section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Students section. Please try again.</p>');
        }
    });
}

function loadOnsiteSection () {
    $.ajax({
        url: "../admin/students.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading onsite section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Onsite section. Please try again.</p>');
        }
    });
}

function loadOnlineSection () {
    $.ajax({
        url: "../admin/online.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading online section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Online section. Please try again.</p>');
        }
    });
}

function loadUpdatesSection () {
    $.ajax({
        url: "../admin/orgUpdates.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading updates section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Updates section. Please try again.</p>');
        }
    });
}

//TOP NAVIGATION 
function loadArchives () {
    $.ajax({
        url: "../admin/archives.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading school architecture section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load School Architecture section. Please try again.</p>');
        }
    });
}

function loadPersonalization () {
    $.ajax({
        url: "../admin/site.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading personalization section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Personalization section. Please try again.</p>');
        }
    });
}

function loadProfile () {
    $.ajax({
        url: "../admin/profile.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading profile section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Profile section. Please try again.</p>');
        }
    });
}

function loadSettings () {
    $.ajax({
        url: "../admin/profileSettings.php",
        method: 'GET',
        success: function (response) {
            $('#contentArea').html(response);
        },
        error: function (xhr, status, error) {
            console.error('Error loading settings section:', error);
            $('#contentArea').html('<p class="text-danger">Failed to load Settings section. Please try again.</p>');
        }
    });
}

document.addEventListener('DOMContentLoaded', function() {
    // Sticky dropdown for School Configuration on mobile
    const schoolConfigBtn = document.querySelector('.nav-link.dropdown-toggle');
    const dropdownMenu = document.querySelector('.sidebar .dropdown-menu');

    if (schoolConfigBtn && dropdownMenu) {
        schoolConfigBtn.addEventListener('click', function() {
            if (window.innerWidth <= 768) {
                const rect = schoolConfigBtn.getBoundingClientRect();
                // Set top to button, left flush with sidebar
                dropdownMenu.style.setProperty('--dropdown-top', `${rect.top - 10}px`);
                dropdownMenu.style.setProperty('--dropdown-left', `10px`);
            } else {
                dropdownMenu.style.removeProperty('--dropdown-top');
            }
        });
        // Optional: update position on scroll for stickiness
        window.addEventListener('scroll', function() {
            if (window.innerWidth <= 768 && dropdownMenu.classList.contains('show')) {
                const rect = schoolConfigBtn.getBoundingClientRect();
                dropdownMenu.style.setProperty('--dropdown-top', `${rect.top - 10}px`);
                dropdownMenu.style.setProperty('--dropdown-left', `10px`);
            }
        });
    }
});