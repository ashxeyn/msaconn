// FOOTER RELOAD FUNCTIONS
function updateFooter() {
    $.ajax({
        url: base_url + 'handler/website/fetchFooter.php',  // Add base_url to path
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                const footer = response.data.footer[0];
                const logo = response.data.logo[0];

                $('.footer-upper-left .logo').attr('src', base_url + logo.image_path);

                $('.logo-text p:first-child strong').text(footer.web_name);
                $('.logo-text p:last-child').text(footer.school_name);

                $('.socials a').attr('href', footer.fb_link);
                $('.contact-info p:first-child').text('Contact Us: ' + footer.contact_no);
                $('.contact-info p:last-child').text('Email: ' + footer.email);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching footer data:', error);
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
                
                // Update carousel first
                if (data.carousel) {
                    updateCarousel(data.carousel);
                }
                
                // Update other content
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
    if (!carouselData || carouselData.length === 0) return;
    
    const carouselContainer = $('.carousel');
    if (!carouselContainer.length) return; 
    
    const heroContent = $('.hero-content').clone();
    
    $('.carousel-slide').remove();
    
    carouselData.forEach((item, index) => {
        const isActive = index === 0 ? 'active' : '';
        const slide = `
            <div class="carousel-slide ${isActive}">
                <div class="carousel-background" style="background-image: url('${base_url + item.image_path}');"></div>
                <div class="carousel-overlay"></div>
                ${index === 0 ? heroContent.prop('outerHTML') : ''}
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
    if (!homeData || homeData.length === 0) return;
    
    if (window.location.pathname.includes('landing_page')) {
        const homeItem = homeData[0];
        const heroContent = $('.carousel .hero-content');
        
        if (heroContent.length) {
            const currentTitle = heroContent.find('h2').text();
            const currentDesc = heroContent.find('p').text();
            
            if (currentTitle !== homeItem.title || currentDesc !== homeItem.description) {
                heroContent.find('h2').text(homeItem.title);
                heroContent.find('p').text(homeItem.description);
            }
        }
    }
}

function updatePrayerSchedule(scheduleData) {
    if (!scheduleData || scheduleData.length === 0) return;
    
    const tableBody = $('#prayer-schedule-content table tbody');
    const currentContent = tableBody.html();
    let newContent = '';
    
    scheduleData.forEach(item => {
        const row = `
            <tr>
                <td>${item.date}</td>
                <td>${getDayName(new Date(item.date))}</td>
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
        
        newContent += `
            <div class="update-item">
                <div class="update-details">
                    <img src="${imagePath}" alt="Update Image" class="update-image">
                    <p class="update-date">${formattedDate}</p>
                    <h3 class="update-title">${item.title}</h3>
                    <p class="update-content">${item.content}</p>
                </div>
            </div>
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
                
                // Update volunteer info content
                if (data.volunteerInfo && data.volunteerInfo.length > 0) {
                    updateVolunteerContent(data.volunteerInfo);
                }
                
                // Update background image
                if (data.backgroundImage && data.backgroundImage.length > 0) {
                    updateVolunteerBackground(data.backgroundImage);
                }
                
                console.log('Volunteer hero content updated successfully at', new Date().toLocaleTimeString());
            } else {
                console.error('Error in response:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching volunteer hero data:', error);
        }
    });
}

function updateVolunteerContent(volunteerInfo) {
    const heroContent = $('.hero-content');
    if (!heroContent.length) return;

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

    const image = backgroundImages[0];
    const newImagePath = base_url + image.image_path;
    const currentBgStyle = heroBackground.attr('style');
    const newBgStyle = `background-image: url('${newImagePath}');`;
    
    if (!currentBgStyle || !currentBgStyle.includes(image.image_path)) {
        heroBackground.attr('style', newBgStyle);
        console.log('Volunteer background updated');
    }
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
                
                if (data.backgroundImage && data.backgroundImage.length > 0) {
                    updateCalendarBackground(data.backgroundImage);
                }
                
                if (data.calendarInfo && data.calendarInfo.length > 0) {
                    updateCalendarContent(data.calendarInfo);
                }
                
                if (data.dailyPrayers) {
                    updateDailyPrayers(data.dailyPrayers);
                }
                
                console.log('Calendar page content updated successfully at', new Date().toLocaleTimeString());
            } else {
                console.error('Error in response:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching calendar data:', error);
        }
    });
}

function updateCalendarBackground(backgroundImages) {
    if (!backgroundImages || backgroundImages.length === 0) return;
    
    const heroBackground = $('.hero-background');
    if (!heroBackground.length) return;

    const image = backgroundImages[0];
    const newImagePath = base_url + image.image_path;
    const currentBgStyle = heroBackground.attr('style');
    const newBgStyle = `background-image: url('${newImagePath}');`;
    
    if (!currentBgStyle || !currentBgStyle.includes(image.image_path)) {
        heroBackground.attr('style', newBgStyle);
        console.log('Calendar background updated');
    }
}

function updateCalendarContent(calendarInfo) {
    if (!calendarInfo || calendarInfo.length === 0) return;
    
    const heroContent = $('.hero-content');
    if (!heroContent.length) return;

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
    
    const tableBody = $('.prayer-table tbody');
    if (!tableBody.length) return;
    
    const todayDate = new Date().toISOString().split('T')[0]; 
    const hasTodayPrayer = dailyPrayers.some(prayer => prayer.date === todayDate);
    let newContent = '';
    
    if (hasTodayPrayer) {
        dailyPrayers.forEach(prayer => {
            if (prayer.date !== todayDate) return;
            
            const prayerTypeDisplay = prayer.prayer_type.charAt(0).toUpperCase() + prayer.prayer_type.slice(1);
            const isFriday = new Date(prayer.date).getDay() === 5; // 5 is Friday
            const timeDisplay = prayer.time ? new Date('1970-01-01T' + prayer.time).toLocaleTimeString('en-US', {hour: 'numeric', minute: '2-digit', hour12: true}) : '<span class="text-danger">No time set</span>';
            
            newContent += `
                <tr>
                    <td>${timeDisplay}</td>
                    <td>
                        ${prayerTypeDisplay}
                        ${(isFriday && prayer.prayer_type === "jumu'ah") ? '<br><small class="text-muted">(Friday Prayer)</small>' : ''}
                    </td>
                    <td>${prayer.speaker}</td>
                    <td>${prayer.topic}</td>
                    <td>${prayer.location}</td>
                </tr>
            `;
        });
    } else {
        newContent = `
            <tr>
                <td colspan="5" class="text-center">No prayer schedules for today</td>
            </tr>
        `;
    }
    
    const currentContent = tableBody.html().trim();
    if (currentContent !== newContent.trim()) {
        tableBody.html(newContent);
        console.log('Daily prayers schedule updated');
    }
}

function initCalendarPage() {
    if (calendarHeroInterval) {
        clearInterval(calendarHeroInterval);
    }
    
    if (calendarRefreshInterval) {
        clearInterval(calendarRefreshInterval);
    }

    updateCalendarPage();

    calendarRefreshInterval = setInterval(function() {
        updateCalendarPage();
    }, 10000); 

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
            }, 15000);
            console.log('Calendar updates resumed after hover');
        }
    );
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
                
                if (data.backgroundImage && data.backgroundImage.length > 0) {
                    updateRegistrationBackground(data.backgroundImage);
                }
                
                if (data.registrationInfo && data.registrationInfo.length > 0) {
                    updateRegistrationContent(data.registrationInfo);
                }
                
                console.log('Registration madrasa content updated successfully at', new Date().toLocaleTimeString());
            } else {
                console.error('Error in response:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching registration data:', error);
        }
    });
}

function updateRegistrationBackground(backgroundImages) {
    if (!backgroundImages || backgroundImages.length === 0) return;
    
    const heroBackground = $('.hero-background');
    if (!heroBackground.length) return;

    const image = backgroundImages[0];
    const newImagePath = base_url + image.image_path;
    const currentBgStyle = heroBackground.attr('style');
    const newBgStyle = `background-image: url('${newImagePath}');`;
    
    if (!currentBgStyle || !currentBgStyle.includes(image.image_path)) {
        heroBackground.attr('style', newBgStyle);
        console.log('Registration background updated');
    }
}

function updateRegistrationContent(registrationInfo) {
    if (!registrationInfo || registrationInfo.length === 0) return;
    
    const heroContent = $('.hero-content');
    if (!heroContent.length) return;

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
                
                if (data.backgroundImage && data.backgroundImage.length > 0) {
                    updateFaqsBackground(data.backgroundImage);
                }
                
                if (data.faqsInfo && data.faqsInfo.length > 0) {
                    updateFaqsContent(data.faqsInfo);
                }
                
                console.log('FAQs page content updated successfully at', new Date().toLocaleTimeString());
            } else {
                console.error('Error in response:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching FAQs data:', error);
        }
    });
}

function updateFaqsBackground(backgroundImages) {
    if (!backgroundImages || backgroundImages.length === 0) return;
    
    const heroBackground = $('.hero-background');
    if (!heroBackground.length) return;

    const image = backgroundImages[0];
    const newImagePath = base_url + image.image_path;
    const currentBgStyle = heroBackground.attr('style');
    const newBgStyle = `background-image: url('${newImagePath}');`;
    
    if (!currentBgStyle || !currentBgStyle.includes(image.image_path)) {
        heroBackground.attr('style', newBgStyle);
        console.log('FAQs background updated');
    }
}

function updateFaqsContent(faqsInfo) {
    if (!faqsInfo || faqsInfo.length === 0) return;
    
    const heroContent = $('.hero-content');
    if (!heroContent.length) return;

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
                
                if (data.backgroundImage && data.backgroundImage.length > 0) {
                    updateTransparencyBackground(data.backgroundImage);
                }
                
                if (data.transparencyInfo && data.transparencyInfo.length > 0) {
                    updateTransparencyContent(data.transparencyInfo);
                }
                
                if (data.cashIn && data.cashOut) {
                    updateTransparencyTables(data.cashIn, data.cashOut, 
                        data.totalCashIn, data.totalCashOut, data.totalFunds);
                }
                
                console.log('Transparency report content updated successfully at', new Date().toLocaleTimeString());
            } else {
                console.error('Error in response:', response.message);
            }
        },
        error: function(xhr, status, error) {
            console.error('Error fetching transparency data:', error);
        }
    });
}

function updateTransparencyBackground(backgroundImages) {
    if (!backgroundImages || backgroundImages.length === 0) return;
    
    const heroBackground = $('.hero-background');
    if (!heroBackground.length) return;

    const image = backgroundImages[0];
    const newImagePath = base_url + image.image_path;
    const currentBgStyle = heroBackground.attr('style');
    const newBgStyle = `background-image: url('${newImagePath}');`;
    
    if (!currentBgStyle || !currentBgStyle.includes(image.image_path)) {
        heroBackground.attr('style', newBgStyle);
        console.log('Transparency background updated');
    }
}

function updateTransparencyContent(transparencyInfo) {
    if (!transparencyInfo || transparencyInfo.length === 0) return;
    
    const heroContent = $('.hero-content');
    if (!heroContent.length) return;

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

function isPageActive(pagePattern) {
    const isActive = window.location.pathname.includes(pagePattern);
    console.log('Checking if page is active:', pagePattern, 'Result:', isActive, 'Current path:', window.location.pathname);
    return isActive;
}

$(document).ready(function() {
    if (typeof base_url === 'undefined') {
        const pathArray = window.location.pathname.split('/');
        base_url = window.location.origin + '/' + pathArray[1] + '/';
    }
    
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
});


// DATA TABLES FOR TRANSPARENCY REPORT
$(document).ready(function() {
    var cashInTable = $('#cashinTable').DataTable({
        pageLength: 10,
        lengthChange: false,
        searching: false,
        ordering: true,
        info: false,
        paging: true
    });
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
});













