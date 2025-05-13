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

// LANDING PAGE FUNCTIONS
let carouselInterval = null;
let carouselRefreshInterval = null;

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
    if (!carouselContainer.length) return; // Only proceed if we're on the landing page
    
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
    
    // Only update hero content if we're on the landing page
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

$(document).ready(function() {
    if (typeof base_url === 'undefined') {
        const pathArray = window.location.pathname.split('/');
        base_url = window.location.origin + '/' + pathArray[1] + '/';
    }
    
    if (window.location.pathname.includes('landing_page')) {
        updateLandingPage();
        initCarousel();
    }
});

// VOLUNTEER FUNCTIONS