// Define base_url as a relative path
const base_url = '../../';

// FOOTER RELOAD FUNCTIONS
function updateFooter() {
    $.ajax({
        url: base_url + 'handler/website/fetchFooter.php',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                const footerData = response.data.footer && response.data.footer.length > 0 ? response.data.footer[0] : null;
                const logoData = response.data.logo && response.data.logo.length > 0 ? response.data.logo[0] : null;

                if (logoData) {
                    $('.header-top .logo img').attr('src', base_url + logoData.image_path).show();
                    $('.footer-upper-left .logo').attr('src', base_url + logoData.image_path).show();
                } else {
                    $('.header-top .logo img').attr('src', '').hide();
                    $('.footer-upper-left .logo').attr('src', '').hide();
                }

                if (footerData) {
                    $('.header-top .logo-text').text(footerData.web_name).show();
                    $('.header-top .logo-subtext').text(footerData.org_name + ' | ' + footerData.school_name).show();
                    $('.footer-upper-left .logo-text p:first-child strong').text(footerData.web_name).closest('p').show();
                    $('.footer-upper-left .logo-text p:last-child').text(footerData.school_name).show();
                    $('.socials a').attr('href', footerData.fb_link).closest('.socials').show();
                    $('.contact-info p:first-child').text('Contact Us: ' + footerData.contact_no).show();
                    $('.contact-info p:last-child').text('Email: ' + footerData.email).show();
                } else {
                    $('.header-top .logo-text').text('').hide();
                    $('.header-top .logo-subtext').text('').hide();
                    $('.footer-upper-left .logo-text p:first-child strong').text('').closest('p').hide();
                    $('.footer-upper-left .logo-text p:last-child').text('').hide();
                    $('.socials a').attr('href', '#').closest('.socials').hide();
                    $('.contact-info p:first-child').text('').hide();
                    $('.contact-info p:last-child').text('').hide();
                }
            } else {
                $('.header-top .logo img').attr('src', '').hide();
                $('.header-top .logo-text').text('').hide();
                $('.header-top .logo-subtext').text('').hide();
                $('.footer-upper-left .logo').attr('src', '').hide();
                $('.footer-upper-left .logo-text p:first-child strong').text('').closest('p').hide();
                $('.footer-upper-left .logo-text p:last-child').text('').hide();
                $('.socials a').attr('href', '#').closest('.socials').hide();
                $('.contact-info p:first-child').text('').hide();
                $('.contact-info p:last-child').text('').hide();
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching footer data:', error);
            $('.header-top .logo img').attr('src', '').hide();
            $('.header-top .logo-text').text('').hide();
        }
    });
}

setInterval(updateFooter, 10000);

$(document).ready(function() {
    updateFooter();
});

// GENERAL PAGE FUNCTIONS
let carouselInterval = null;
let carouselRefreshInterval = null;
let volunteerHeroInterval = null;
let volunteerRefreshInterval = null;
let calendarHeroInterval = null;
let calendarRefreshInterval = null;
let registrationHeroInterval = null;
let registrationRefreshInterval = null;
let faqsHeroInterval = null;
let faqsRefreshInterval = null;
let transparencyHeroInterval = null;
let transparencyRefreshInterval = null;


// LANDING PAGE FUNCTIONS
function updateLandingPage() {
    $.ajax({
        url: base_url + 'handler/website/fetchLandingPage.php',
        method: 'GET',
        dataType: 'json',
        cache: false,
        success: function(response) {
            if (response.status === 'success') {
                const data = response.data;
                
                if (data.carousel) {
                    updateCarousel(data.carousel);
                }
                
                if (data.home) {
                    updateHomeContent(data.home);
                }
                
                if (data.prayerSchedule) {
                    updatePrayerSchedule(data.prayerSchedule);
                }
                
                if (data.orgUpdates) {
                    updateOrgUpdates(data.orgUpdates);
                }
                
                console.log('Landing page content updated successfully');
            } else {
                console.error('Error in response:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching landing page data:', error);
        }
    });
}

function updateCarousel(carouselData) {
    const carouselContainer = $('.carousel');
    const heroContentContainer = $('.carousel .hero-content'); 

    if (!carouselData || carouselData.length === 0) {
        if (carouselContainer.length) {
            carouselContainer.empty(); 
            $('.carousel-indicators').empty(); 
            carouselContainer.append('<div class="carousel-slide placeholder"><p>Carousel content is currently unavailable.</p></div>'); // Optional placeholder
            if (carouselInterval) clearInterval(carouselInterval);
            if (carouselRefreshInterval) clearInterval(carouselRefreshInterval); 
            console.log('Carousel data empty, cleared carousel.');
        }
        return;
    }
    
    const originalHeroHTML = heroContentContainer.length > 0 ? heroContentContainer.prop('outerHTML') : '';
    
    $('.carousel-slide').remove(); 
    
    carouselData.forEach((item, index) => {
        const isActive = index === 0 ? 'active' : '';
        const slide = `
            <div class="carousel-slide ${isActive}">
                <div class="carousel-background" style="background-image: url('${base_url + item.image_path}');"></div>
                <div class="carousel-overlay"></div>
                ${index === 0 ? originalHeroHTML : ''} 
            </div>
        `;
        carouselContainer.append(slide);
    });
    
    updateCarouselIndicators(carouselData.length);
    initCarousel(); 
}

function updateCarouselIndicators(slideCount) {
    const indicatorsContainer = $('.carousel-indicators');
    indicatorsContainer.empty();
    
    for (let i = 0; i < slideCount; i++) {
        const isActive = i === 0 ? 'active' : '';
        indicatorsContainer.append(`<span class="indicator ${isActive}" data-slide="${i}"></span>`);
    }
}

function updateHomeContent(homeData) {
    const heroContent = $('.carousel .hero-content'); 
    
    if (!heroContent.length) return; 

    if (!homeData || homeData.length === 0) {
        heroContent.find('h2').text('');
        heroContent.find('p').text('');
        // heroContent.hide(); 
        // heroContent.html('<p>Welcome!</p>'); 
        console.log('Home data empty, cleared hero content.');
        return;
    }
    
    // heroContent.show(); 
    const homeItem = homeData[0];
    const currentTitle = heroContent.find('h2').text();
    const currentDesc = heroContent.find('p').text();
            
    if (currentTitle !== homeItem.title || currentDesc !== homeItem.description) {
        heroContent.find('h2').text(homeItem.title);
        heroContent.find('p').text(homeItem.description);
        console.log('Hero content updated.');
    }
}

function updatePrayerSchedule(scheduleData) {
    if (!scheduleData || scheduleData.length === 0) return;
    
    const tableBody = $('#prayer-schedule-content table tbody');
    const currentContent = tableBody.html();
    let newContent = '';
    const today = new Date();
    today.setHours(0,0,0,0); 
    
    scheduleData.forEach(item => {
        const dateObj = new Date(item.date);
        dateObj.setHours(0,0,0,0); 
        if (dateObj < today) return; 
        const formattedDate = dateObj.toLocaleDateString('en-US', { month: 'long', day: 'numeric', year: 'numeric' });
        const formattedTime = item.time ? new Date('1970-01-01T' + item.time + 'Z').toLocaleTimeString('en-US', {hour: 'numeric', minute:'2-digit', hour12: true, timeZone: 'UTC'}) : 'N/A';
        const row = `
            <tr>
                <td>${formattedDate}</td>
                <td>${formattedTime}</td>
                <td>${getDayName(dateObj)}</td>
                <td>${item.speaker}</td>
                <td>${item.topic}</td>
                <td>${item.location}</td>
            </tr>
        `;
        newContent += row;
    });
    
    if (currentContent !== newContent) {
        tableBody.html(newContent);
    }
}

function getDayName(date) {
    const days = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
    return days[date.getDay()];
}

function updateOrgUpdates(updatesData) {
    if (!updatesData || updatesData.length === 0) return;
    
    const updatesContainer = $('#updates-container');
    const currentContent = updatesContainer.html();
    let newContent = '';
    
    const limitedUpdates = updatesData.slice(0, 4);
    
    limitedUpdates.forEach(item => {
        const formattedDate = formatDate(new Date(item.created_at));
        const imagePath = item.image_path ? base_url + 'assets' + item.image_path : base_url + 'assets/images/login.jpg';
        
        // Count words for truncated content
        const words = item.content.split(' ');
        const truncatedContent = (words.length > 95) ? words.slice(0, 95).join(' ') + '...' : item.content;
        
        newContent += `
            <a href="news.php?id=${item.update_id}" class="update-link" style="text-decoration: none; color: inherit; display: block;">
                <div class="update-item">
                    <div class="update-details">
                        <img src="${imagePath}" alt="Update Image" class="update-image">
                        <p class="update-date">${formattedDate}</p>
                        <h3 class="update-title">${item.title}</h3>
                        <p class="update-content">${truncatedContent}</p>
                    </div>
                </div>
            </a>
        `;
    });
    
    if (currentContent !== newContent) {
        updatesContainer.html(newContent);
    }
}

function formatDate(date) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return date.toLocaleDateString('en-US', options);
}

function initCarousel() {
    if (carouselInterval) {
        clearInterval(carouselInterval);
    }
    if (carouselRefreshInterval) {
        clearInterval(carouselRefreshInterval);
    }

    const slides = document.querySelectorAll('.carousel-slide');
    const indicators = document.querySelectorAll('.carousel-indicators .indicator');
    const totalSlides = slides.length;
    let currentSlide = 0;

    if (slides.length === 0) return;
    
        slides[0].classList.add('active');
    if (indicators.length > 0) {
        indicators[0].classList.add('active');
    }
    
    function showSlide(n) {
        slides.forEach(slide => slide.classList.remove('active'));
        indicators.forEach(indicator => indicator.classList.remove('active'));
        slides[n].classList.add('active');
        indicators[n].classList.add('active');
        currentSlide = n;
    }
    
    function nextSlide() {
        currentSlide = (currentSlide + 1) % totalSlides;
        showSlide(currentSlide);
    }
    
    function prevSlide() {
        currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
        showSlide(currentSlide);
    }
    
    $('.carousel-button.next').off('click');
    $('.carousel-button.prev').off('click');
    $('.carousel-indicators .indicator').off('click');
    $('.carousel-button.next').on('click', function() {
        nextSlide();
        resetInterval();
    });

    $('.carousel-button.prev').on('click', function() {
        prevSlide();
        resetInterval();
    });

    $('.carousel-indicators .indicator').on('click', function() {
        const index = $(this).data('slide');
        showSlide(index);
        resetInterval();
    });

    function resetInterval() {
        if (carouselInterval) {
            clearInterval(carouselInterval);
        }
        startAutoSlide();
    }

    function startAutoSlide() {
        carouselInterval = setInterval(nextSlide, 5000); 
    }

    startAutoSlide();

    carouselRefreshInterval = setInterval(function() {
        updateLandingPage();
    }, 20000); 

    $('.carousel').hover(
        function() {
            if (carouselInterval) {
                clearInterval(carouselInterval);
            }
            if (carouselRefreshInterval) {
                clearInterval(carouselRefreshInterval);
            }
        },
        function() {
            startAutoSlide();
            carouselRefreshInterval = setInterval(function() {
                updateLandingPage();
            }, 20000);
        }
    );
}

// $(document).ready(function() {
//     if (typeof base_url === 'undefined') {
//         const pathArray = window.location.pathname.split('/');
//         base_url = window.location.origin + '/' + pathArray[1] + '/';
//     }
    
//     if (window.location.pathname.includes('landing_page')) {
//         updateLandingPage();
//         initCarousel();
//     }
// });

// VOLUNTEER HERO FUNCTIONS
function updateVolunteerHero() {
    $.ajax({
        url: base_url + 'handler/website/fetchVolunteerHero.php',
        method: 'GET',
        dataType: 'json',
        cache: false,
        success: function(response) {
            if (response.status === 'success') {
                const data = response.data;
                
                updateVolunteerContent(data.volunteerInfo);
                updateVolunteerBackground(data.backgroundImage);
                
                console.log('Volunteer hero content updated successfully at', new Date().toLocaleTimeString());
            } else {
                console.error('Error in response:', response.message);
                updateVolunteerContent(null); 
                updateVolunteerBackground(null);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching volunteer hero data:', error);
            updateVolunteerContent(null); 
            updateVolunteerBackground(null);
        }
    });
}

function updateVolunteerContent(volunteerInfo) {
    const heroContent = $('.hero-content');
    if (!heroContent.length) return;

    if (!volunteerInfo || volunteerInfo.length === 0) {
        heroContent.find('h2').text('');
        heroContent.find('p').text('');
        console.log('Volunteer content data empty, cleared hero content.');
        return;
    }

    const info = volunteerInfo[0];
    const currentTitle = heroContent.find('h2').text().trim();
    const currentDesc = heroContent.find('p').text().trim();

    if (currentTitle !== info.title.trim() || currentDesc !== info.description.trim()) {
        heroContent.find('h2').text(info.title);
        heroContent.find('p').text(info.description);
        console.log('Volunteer content updated');
    }
}

function updateVolunteerBackground(backgroundImages) {
    const heroBackground = $('.hero-background');
    if (!heroBackground.length) return;

    if (!backgroundImages || backgroundImages.length === 0) {
        heroBackground.removeAttr('style');
        console.log('Volunteer background data empty, cleared background.');
        return;
    }

    const image = backgroundImages[0];
    const newImagePath = base_url + image.image_path;
    const newBgStyle = `background-image: url('${newImagePath}');`;
    
    heroBackground.attr('style', newBgStyle);
    console.log('Volunteer background updated');
}

function initVolunteerHero() {
    if (volunteerHeroInterval) {
        clearInterval(volunteerHeroInterval);
    }
    
    if (volunteerRefreshInterval) {
        clearInterval(volunteerRefreshInterval);
    }

    updateVolunteerHero();

    volunteerHeroInterval = setInterval(function() {
        updateVolunteerHero();
    }, 10000); 

    $('.hero').hover(
        function() {
            if (volunteerHeroInterval) {
                clearInterval(volunteerHeroInterval);
            }
            if (volunteerRefreshInterval) {
                clearInterval(volunteerRefreshInterval);
            }
            console.log('Volunteer hero updates paused on hover');
        },
        function() {
            volunteerHeroInterval = setInterval(function() {
                updateVolunteerHero();
            }, 10000);
            console.log('Volunteer hero updates resumed after hover');
        }
    );
}

// CALENDAR PAGE FUNCTIONS
function updateCalendarPage() {
    $.ajax({
        url: base_url + 'handler/website/fetchCalendar.php',
        method: 'GET',
        dataType: 'json',
        cache: false,
        success: function(response) {
            if (response.status === 'success') {
                const data = response.data;
                
                updateCalendarBackground(data.backgroundImage);
                updateCalendarContent(data.calendarInfo);
                
                if (data.dailyPrayers) {
                    updateDailyPrayers(data.dailyPrayers);
                }
                
                console.log('Calendar page content updated successfully at', new Date().toLocaleTimeString());
            } else {
                console.error('Error in response:', response.message);
                updateCalendarBackground(null);
                updateCalendarContent(null);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching calendar data:', error);
            updateCalendarBackground(null);
            updateCalendarContent(null);
        }
    });
}

function updateCalendarBackground(backgroundImages) {
    const heroBackground = $('.hero-background');
    if (!heroBackground.length) return;

    if (!backgroundImages || backgroundImages.length === 0) {
        heroBackground.removeAttr('style');
        console.log('Calendar background data empty, cleared background.');
        return;
    }
    
    const image = backgroundImages[0];
    const newImagePath = base_url + image.image_path;
    const newBgStyle = `background-image: url('${newImagePath}');`;
    
    heroBackground.attr('style', newBgStyle);
    console.log('Calendar background updated');
}

function updateCalendarContent(calendarInfo) {
    const heroContent = $('.hero-content');
    if (!heroContent.length) return;

    if (!calendarInfo || calendarInfo.length === 0) {
        heroContent.find('h2').text('');
        heroContent.find('p').text('');
        console.log('Calendar content data empty, cleared hero content.');
        return;
    }

    const info = calendarInfo[0];
    const currentTitle = heroContent.find('h2').text().trim();
    const currentDesc = heroContent.find('p').text().trim();

    if (currentTitle !== info.title.trim() || currentDesc !== info.description.trim()) {
        heroContent.find('h2').text(info.title);
        heroContent.find('p').text(info.description);
        console.log('Calendar content updated');
    }
}

function updateDailyPrayers(dailyPrayers) {
    if (!dailyPrayers) return;
    
    const tableBody = $('.msa-table tbody');
    if (!tableBody.length) return;
    
    const todayDate = new Date().toISOString().split('T')[0]; 
    const hasTodayPrayer = dailyPrayers.some(prayer => prayer.date === todayDate);
    let newContent = '';
    
    if (hasTodayPrayer) {
        dailyPrayers.forEach(prayer => {
            if (prayer.date !== todayDate) return;
            
            const prayerTypeDisplay = prayer.prayer_type.charAt(0).toUpperCase() + prayer.prayer_type.slice(1);
            const isFriday = new Date(prayer.date).getDay() === 5; 
            const timeDisplay = prayer.time ? new Date('1970-01-01T' + prayer.time).toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit', hour12: true}) : '<span class="text-danger">No time set</span>';
            const iqamahDisplay = prayer.iqamah ? new Date('1970-01-01T' + prayer.iqamah).toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit', hour12: true}) : '<span class="text-danger">No time set</span>';
            
            newContent += `
                <tr>
                    <td>
                        ${prayerTypeDisplay}
                        ${(isFriday && prayer.prayer_type === "jumu'ah") ? '<br><small class="text-muted">(Friday Prayer)</small>' : ''}
                    </td>
                    <td>${timeDisplay}</td>
                    <td>${iqamahDisplay}</td>
                    <td>${prayer.location}</td>
                </tr>
            `;
        });
    } else {
        newContent = `
            <tr>
                <td colspan="4" class="text-center">No prayer schedules for today</td>
            </tr>
        `;
    }
    
    const currentContent = tableBody.html().trim();
    if (currentContent !== newContent.trim()) {
        tableBody.html(newContent);
        console.log('Daily prayers schedule updated at', new Date().toLocaleTimeString());
    }
}

function initCalendarPage() {
    if (calendarHeroInterval) {
        clearInterval(calendarHeroInterval);
    }
    
    if (calendarRefreshInterval) {
        clearInterval(calendarRefreshInterval);
    }

    // Initial update
    updateCalendarPage();

    // Set up periodic updates every 5 seconds
    calendarRefreshInterval = setInterval(function() {
        updateCalendarPage();
    }, 5000); 

    // Pause updates when user is interacting with the page
    $('.hero').hover(
        function() {
            if (calendarHeroInterval) {
                clearInterval(calendarHeroInterval);
            }
            if (calendarRefreshInterval) {
                clearInterval(calendarRefreshInterval);
            }
            console.log('Calendar updates paused on hover');
        },
        function() {
            calendarRefreshInterval = setInterval(function() {
                updateCalendarPage();
            }, 5000);
            console.log('Calendar updates resumed after hover');
        }
    );

    // Force update when window regains focus
    $(window).on('focus', function() {
        updateCalendarPage();
    });

    // Force update when tab becomes visible
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            updateCalendarPage();
        }
    });
}

// REGISTRATION MADRASA PAGE FUNCTIONS
function updateRegistrationPage() {
    $.ajax({
        url: base_url + 'handler/website/fetchRegistration.php',
        method: 'GET',
        dataType: 'json',
        cache: false,
        success: function(response) {
            if (response.status === 'success') {
                const data = response.data;
                
                updateRegistrationBackground(data.backgroundImage);
                updateRegistrationContent(data.registrationInfo);
                
                console.log('Registration madrasa content updated successfully at', new Date().toLocaleTimeString());
            } else {
                console.error('Error in response:', response.message);
                updateRegistrationBackground(null);
                updateRegistrationContent(null);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching registration data:', error);
            updateRegistrationBackground(null);
            updateRegistrationContent(null);
        }
    });
}

function updateRegistrationBackground(backgroundImages) {
    const heroBackground = $('.hero-background');
    if (!heroBackground.length) return;

    if (!backgroundImages || backgroundImages.length === 0) {
        heroBackground.removeAttr('style');
        console.log('Registration background data empty, cleared background.');
        return;
    }
    
    const image = backgroundImages[0];
    const newImagePath = base_url + image.image_path;
    const newBgStyle = `background-image: url('${newImagePath}');`;
    
    heroBackground.attr('style', newBgStyle);
    console.log('Registration background updated');
}

function updateRegistrationContent(registrationInfo) {
    const heroContent = $('.hero-content');
    if (!heroContent.length) return;

    if (!registrationInfo || registrationInfo.length === 0) {
        heroContent.find('h2').text('');
        heroContent.find('p').text('');
        console.log('Registration content data empty, cleared hero content.');
        return;
    }

    const info = registrationInfo[0];
    const currentTitle = heroContent.find('h2').text().trim();
    const currentDesc = heroContent.find('p').text().trim();

    if (currentTitle !== info.title.trim() || currentDesc !== info.description.trim()) {
        heroContent.find('h2').text(info.title);
        heroContent.find('p').text(info.description);
        console.log('Registration content updated');
    }
}

function initRegistrationPage() {
    if (registrationHeroInterval) {
        clearInterval(registrationHeroInterval);
    }
    
    if (registrationRefreshInterval) {
        clearInterval(registrationRefreshInterval);
    }

    updateRegistrationPage();

    registrationRefreshInterval = setInterval(function() {
        updateRegistrationPage();
    }, 10000);

    $('.hero').hover(
        function() {
            if (registrationHeroInterval) {
                clearInterval(registrationHeroInterval);
            }
            if (registrationRefreshInterval) {
                clearInterval(registrationRefreshInterval);
            }
            console.log('Registration updates paused on hover');
        },
        function() {
            registrationRefreshInterval = setInterval(function() {
                updateRegistrationPage();
            }, 12000);
            console.log('Registration updates resumed after hover');
        }
    );
}

// FAQS PAGE FUNCTIONS
function updateFaqsPage() {
    $.ajax({
        url: base_url + 'handler/website/fetchFaqs.php',
        method: 'GET',
        dataType: 'json',
        cache: false,
        success: function(response) {
            if (response.status === 'success') {
                const data = response.data;
                
                updateFaqsBackground(data.backgroundImage);
                updateFaqsContent(data.faqsInfo);
                
                console.log('FAQs page content updated successfully at', new Date().toLocaleTimeString());
            } else {
                console.error('Error in response:', response.message);
                updateFaqsBackground(null);
                updateFaqsContent(null);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching FAQs data:', error);
            updateFaqsBackground(null);
            updateFaqsContent(null);
        }
    });
}

function updateFaqsBackground(backgroundImages) {
    const heroBackground = $('.hero-background');
    if (!heroBackground.length) return;

    if (!backgroundImages || backgroundImages.length === 0) {
        heroBackground.removeAttr('style');
        console.log('FAQs background data empty, cleared background.');
        return;
    }
    
    const image = backgroundImages[0];
    const newImagePath = base_url + image.image_path;
    const newBgStyle = `background-image: url('${newImagePath}');`;
    
    heroBackground.attr('style', newBgStyle);
    console.log('FAQs background updated');
}

function updateFaqsContent(faqsInfo) {
    const heroContent = $('.hero-content');
    if (!heroContent.length) return;

    if (!faqsInfo || faqsInfo.length === 0) {
        heroContent.find('h2').text('');
        heroContent.find('p').text('');
        console.log('FAQs content data empty, cleared hero content.');
        return;
    }

    const info = faqsInfo[0];
    const currentTitle = heroContent.find('h2').text().trim();
    const currentDesc = heroContent.find('p').text().trim();

    if (currentTitle !== info.title.trim() || currentDesc !== info.description.trim()) {
        heroContent.find('h2').text(info.title);
        heroContent.find('p').text(info.description);
        console.log('FAQs content updated');
    }
}

function initFaqsPage() {
    if (faqsHeroInterval) {
        clearInterval(faqsHeroInterval);
    }
    
    if (faqsRefreshInterval) {
        clearInterval(faqsRefreshInterval);
    }

    updateFaqsPage();

    faqsRefreshInterval = setInterval(function() {
        updateFaqsPage();
    }, 10000); 

    $('.hero').hover(
        function() {
            if (faqsHeroInterval) {
                clearInterval(faqsHeroInterval);
            }
            if (faqsRefreshInterval) {
                clearInterval(faqsRefreshInterval);
            }
            console.log('FAQs updates paused on hover');
        },
        function() {
            faqsRefreshInterval = setInterval(function() {
                updateFaqsPage();
            }, 10000);
            console.log('FAQs updates resumed after hover');
        }
    );
}

// TRANSPARENCY REPORT PAGE FUNCTIONS
function updateTransparencyPage() {
    $.ajax({
        url: base_url + 'handler/website/fetchTransparency.php',
        method: 'GET',
        dataType: 'json',
        cache: false,
        success: function(response) {
            if (response.status === 'success') {
                const data = response.data;
                
                updateTransparencyBackground(data.backgroundImage);
                updateTransparencyContent(data.transparencyInfo);
                
                if (data.cashIn && data.cashOut) {
                    updateTransparencyTables(data.cashIn, data.cashOut, 
                        data.totalCashIn, data.totalCashOut, data.totalFunds);
                }
                
                console.log('Transparency report content updated successfully at', new Date().toLocaleTimeString());
            } else {
                console.error('Error in response:', response.message);
                updateTransparencyBackground(null);
                updateTransparencyContent(null);
                // updateTransparencyTables(null, null, null, null, null); 
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching transparency data:', error);
            updateTransparencyBackground(null);
            updateTransparencyContent(null);
            // updateTransparencyTables(null, null, null, null, null); 
        }
    });
}

function updateTransparencyBackground(backgroundImages) {
    const heroBackground = $('.hero-background');
    if (!heroBackground.length) return;

    if (!backgroundImages || backgroundImages.length === 0) {
        heroBackground.removeAttr('style');
        console.log('Transparency background data empty, cleared background.');
        return;
    }
    
    const image = backgroundImages[0];
    const newImagePath = base_url + image.image_path;
    const newBgStyle = `background-image: url('${newImagePath}');`;
    
    heroBackground.attr('style', newBgStyle);
    console.log('Transparency background updated');
}

function updateTransparencyContent(transparencyInfo) {
    const heroContent = $('.hero-content');
    if (!heroContent.length) return;

    if (!transparencyInfo || transparencyInfo.length === 0) {
        heroContent.find('h2').text('');
        heroContent.find('p').text('');
        console.log('Transparency content data empty, cleared hero content.');
        return;
    }

    const info = transparencyInfo[0];
    const currentTitle = heroContent.find('h2').text().trim();
    const currentDesc = heroContent.find('p').text().trim();

    if (currentTitle !== info.title.trim() || currentDesc !== info.description.trim()) {
        heroContent.find('h2').text(info.title);
        heroContent.find('p').text(info.description);
        console.log('Transparency content updated');
    }
}

function updateTransparencyTables(cashIn, cashOut, totalCashIn, totalCashOut, totalFunds) {
    let cashinBody = $('#cashinTable tbody');
    let cashinContent = '';
    if (cashIn && cashIn.length > 0) {
        cashIn.forEach(transaction => {
            const startDate = new Date(transaction.report_date);
            let dateDisplay = startDate.toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'});
            let startDay = startDate.toLocaleDateString('en-US', {weekday: 'long'});
            let dayDisplay = startDay;
            if (transaction.end_date) {
                const endDate = new Date(transaction.end_date);
                dateDisplay += ' to ' + endDate.toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'});
                const endDay = endDate.toLocaleDateString('en-US', {weekday: 'long'});
                dayDisplay = (startDay !== endDay) ? `${startDay} - ${endDay}` : startDay;
            }
            cashinContent += `
                <tr>
                    <td>${dateDisplay}</td>
                    <td>${dayDisplay}</td>
                    <td>${transaction.expense_detail}</td>
                    <td>${transaction.expense_category}</td>
                    <td>₱${parseFloat(transaction.amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                </tr>
            `;
        });
    } else {
        cashinContent = '<tr><td colspan="5" class="text-center">No cash-in transactions found.</td></tr>';
    }
    cashinBody.html(cashinContent);

    let cashoutBody = $('#cashoutTable tbody');
    let cashoutContent = '';
    if (cashOut && cashOut.length > 0) {
        cashOut.forEach(transaction => {
            const startDate = new Date(transaction.report_date);
            let dateDisplay = startDate.toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'});
            let startDay = startDate.toLocaleDateString('en-US', {weekday: 'long'});
            let dayDisplay = startDay;
            if (transaction.end_date) {
                const endDate = new Date(transaction.end_date);
                dateDisplay += ' to ' + endDate.toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'});
                const endDay = endDate.toLocaleDateString('en-US', {weekday: 'long'});
                dayDisplay = (startDay !== endDay) ? `${startDay} - ${endDay}` : startDay;
            }
            cashoutContent += `
                <tr>
                    <td>${dateDisplay}</td>
                    <td>${dayDisplay}</td>
                    <td>${transaction.expense_detail}</td>
                    <td>${transaction.expense_category}</td>
                    <td>₱${parseFloat(transaction.amount).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}</td>
                </tr>
            `;
        });
    } else {
        cashoutContent = '<tr><td colspan="5" class="text-center">No cash-out transactions found.</td></tr>';
    }
    cashoutBody.html(cashoutContent);

    $('.summary-table tbody tr:eq(0) td:eq(1)').text(`₱${parseFloat(totalCashIn).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`);
    $('.summary-table tbody tr:eq(1) td:eq(1)').text(`₱${parseFloat(totalCashOut).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`);
    $('.summary-table tbody tr:eq(2) td:eq(1)').text(`₱${parseFloat(totalFunds).toLocaleString('en-US', {minimumFractionDigits: 2, maximumFractionDigits: 2})}`);

    console.log('Transaction tables and summary updated');
}


function initTransparencyPage() {
    if (transparencyHeroInterval) {
        clearInterval(transparencyHeroInterval);
    }
    
    if (transparencyRefreshInterval) {
        clearInterval(transparencyRefreshInterval);
    }

    updateTransparencyPage();

    transparencyRefreshInterval = setInterval(function() {
        updateTransparencyPage();
    }, 10000); 

    $('.hero').hover(
        function() {
            if (transparencyHeroInterval) {
                clearInterval(transparencyHeroInterval);
            }
            if (transparencyRefreshInterval) {
                clearInterval(transparencyRefreshInterval);
            }
            console.log('Transparency updates paused on hover');
        },
        function() {
            transparencyRefreshInterval = setInterval(function() {
                updateTransparencyPage();
            }, 10000);
            console.log('Transparency updates resumed after hover');
        }
    );
}

// ABOUT PAGE FUNCTIONS
function updateAboutPage() {
    $.ajax({
        url: base_url + 'handler/website/fetchAbouts.php',
        method: 'GET',
        dataType: 'json',
        cache: false,
        success: function(response) {
            if (response.status === 'success') {
                const data = response.data;
                
                updateAboutBackground(data.backgroundImage);
                updateAboutContent(data.aboutInfo);
                
                if (data.missionVision && data.missionVision.length > 0) {
                    updateMissionVision(data.missionVision);
                }
                if (data.files) {
                    updateDownloadableFiles(data.files);
                }
                
                console.log('About page content updated successfully at', new Date().toLocaleTimeString());
            } else {
                console.error('Error in response:', response.message);
                updateAboutBackground(null);
                updateAboutContent(null);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching about page data:', error);
            updateAboutBackground(null);
            updateAboutContent(null);
        }
    });
}

function updateAboutBackground(backgroundImages) {
    const heroBackground = $('.hero-background');
    if (!heroBackground.length) return;

    if (!backgroundImages || backgroundImages.length === 0) {
        heroBackground.removeAttr('style');
        console.log('About background data empty, cleared background.');
        return;
    }
    
    const image = backgroundImages[0];
    const newImagePath = base_url + image.image_path;
    const newBgStyle = `background-image: url('${newImagePath}');`;
    
    heroBackground.attr('style', newBgStyle);
    console.log('About background updated');
}

function updateAboutContent(aboutInfo) {
    const heroContent = $('.hero-content');
    if (!heroContent.length) return;

    if (!aboutInfo || aboutInfo.length === 0) {
        heroContent.find('h2').text('');
        heroContent.find('p').text('');
        console.log('About hero content data empty, cleared hero content.');
        return;
    }

    const info = aboutInfo[0];
    const currentTitle = heroContent.find('h2').text().trim();
    const currentDesc = heroContent.find('p').text().trim();

    if (currentTitle !== info.title.trim() || currentDesc !== info.description.trim()) {
        heroContent.find('h2').text(info.title);
        heroContent.find('p').text(info.description);
        console.log('About hero content updated');
    }
}

function updateMissionVision(missionVision) {
    if (!missionVision || missionVision.length === 0) return;
    
    const missionElement = $('.mission p');
    const visionElement = $('.vision p');
    
    if (!missionElement.length || !visionElement.length) return;

    const info = missionVision[0];
    const currentMission = missionElement.text().trim();
    const currentVision = visionElement.text().trim();

    if (currentMission !== info.mission.trim()) {
        missionElement.text(info.mission);
        console.log('Mission updated');
    }

    if (currentVision !== info.vision.trim()) {
        visionElement.text(info.vision);
        console.log('Vision updated');
    }
}

function updateDownloadableFiles(files) {
    if (!files) return;
    
    const downloadsContainer = $('.downloads-list');
    if (!downloadsContainer.length) return;
    
    if (files.length === 0) {
        downloadsContainer.html('<p class="no-downloads">No downloadable resources available at this time.</p>');
        return;
    }
    
    let newContent = '';
    
    files.forEach(file => {
        const fileExtension = file.file_name.split('.').pop().toLowerCase();
        let iconClass = 'file';
        
        if (file.file_type.includes('pdf') || fileExtension === 'pdf') {
            iconClass = 'pdf';
        } else if (file.file_type.includes('word') || fileExtension === 'docx' || fileExtension === 'doc') {
            iconClass = 'docx';
        }
        
        const fileSize = parseInt(file.file_size) || 0;
        let formattedSize = '';
        
        if (fileSize < 1024) {
            formattedSize = fileSize + ' B';
        } else if (fileSize < 1048576) {
            formattedSize = (fileSize / 1024).toFixed(2) + ' KB';
        } else {
            formattedSize = (fileSize / 1048576).toFixed(2) + ' MB';
        }
        
        let createdDate = '';
        if (file.created_at) {
            const date = new Date(file.created_at);
            createdDate = date.toLocaleDateString('en-US', {month: 'long', day: 'numeric', year: 'numeric'});
        }
        
        newContent += `
            <a href="${base_url}assets/downloadables/${file.file_path}" download class="download-card">
                <div class="download-icon ${iconClass}"></div>
                <div class="download-info">
                    <span class="download-title">${file.file_name}</span>
                    <span class="download-type">(${fileExtension.toUpperCase()})</span>
                    ${formattedSize ? `<span class="download-size">${formattedSize}</span>` : ''}
                    ${createdDate ? `<span class="download-date">Added: ${createdDate}</span>` : ''}
                </div>
            </a>
        `;
    });
    
    const currentContent = downloadsContainer.html().trim();
    if (currentContent !== newContent.trim()) {
        downloadsContainer.html(newContent);
        console.log('Downloadable files updated');
    }
}

let aboutHeroInterval = null;
let aboutRefreshInterval = null;

function initAboutPage() {
    if (aboutHeroInterval) {
        clearInterval(aboutHeroInterval);
    }
    
    if (aboutRefreshInterval) {
        clearInterval(aboutRefreshInterval);
    }

    updateAboutPage();

    aboutRefreshInterval = setInterval(function() {
        updateAboutPage();
    }, 10000); 

    $('.hero').hover(
        function() {
            if (aboutHeroInterval) {
                clearInterval(aboutHeroInterval);
            }
            if (aboutRefreshInterval) {
                clearInterval(aboutRefreshInterval);
            }
            console.log('About page updates paused on hover');
        },
        function() {
            aboutRefreshInterval = setInterval(function() {
                updateAboutPage();
            }, 10000);
            console.log('About page updates resumed after hover');
        }
    );
}

function isPageActive(pagePattern) {
    const isActive = window.location.pathname.includes(pagePattern);
    console.log('Checking if page is active:', pagePattern, 'Result:', isActive, 'Current path:', window.location.pathname);
    return isActive;
}

$(document).ready(function() {
    console.log('Website.js initialized on path:', window.location.pathname);
    console.log('Base URL:', base_url);
    
    if (isPageActive('landing_page')) {
        console.log('Landing page detected, initializing carousel and content updates');
    updateLandingPage();
        initCarousel();
    } 
    
    if (isPageActive('volunteer')) {
        console.log('Volunteer page detected, initializing hero content updates');
        initVolunteerHero();
        
        loadVolunteers();
    }

    if (isPageActive('calendar')) {
        console.log('Calendar page detected, initializing content updates');
        initCalendarPage();
    }

    if (isPageActive('Registrationmadrasa')) {
        console.log('Registration Madrasa page detected, initializing content updates');
        initRegistrationPage();
    }

    if (isPageActive('faqs')) {
        console.log('FAQs page detected, initializing content updates');
        initFaqsPage();
    }

    if (isPageActive('transparencyreport')) {
        console.log('Transparency Report page detected, initializing content updates');
        initTransparencyPage();
    }

    if (isPageActive('aboutus')) {
        console.log('About Us page detected, initializing content updates');
        initAboutPage();
    }

    // DATA TABLES FOR TRANSPARENCY REPORT
    if (!$.fn.dataTable.isDataTable('#cashinTable')) {
        var cashInTable = $('#cashinTable').DataTable({
            pageLength: 10,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: false,
            paging: true
        });
    }
    
    if (!$.fn.dataTable.isDataTable('#cashoutTable')) {
        var cashOutTable = $('#cashoutTable').DataTable({
            pageLength: 10,
            lengthChange: false,
            searching: false,
            ordering: true,
            info: false,
            paging: true,
            drawCallback: function(settings) {
                var api = this.api();
                var pageInfo = api.page.info();
                if (pageInfo.page === pageInfo.pages - 1) {
                    $('#summaryTableContainer').show();
                } else {
                    $('#summaryTableContainer').hide();
                }
            }
        });
        
        var pageInfo = cashOutTable.page.info();
        if (pageInfo.page !== pageInfo.pages - 1) {
            $('#summaryTableContainer').hide();
        }
    } else {
        // If already initialized, still handle the summary table visibility
        if ($('#cashoutTable').length) {
            var existingTable = $('#cashoutTable').DataTable();
            var pageInfo = existingTable.page.info();
            if (pageInfo.page !== pageInfo.pages - 1) {
                $('#summaryTableContainer').hide();
            } else {
                $('#summaryTableContainer').show();
            }
        }
    }
});













