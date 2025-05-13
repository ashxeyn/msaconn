document.addEventListener('DOMContentLoaded', function() {
    // Select elements
    const menuToggle = document.querySelector('.menu-toggle');
    const navbar = document.querySelector('.navbar');
    const dropdowns = document.querySelectorAll('.dropdown');
    
    console.log('Header JS loaded', { 
        menuToggle: menuToggle ? 'Found' : 'Not found', 
        navbar: navbar ? 'Found' : 'Not found',
        dropdownsCount: dropdowns.length
    });
    
    // Log active menu items
    const activeLinks = document.querySelectorAll('.nav-links a.active');
    console.log('Active links found:', activeLinks.length);
    activeLinks.forEach((link, i) => {
        console.log(`Active link ${i}:`, link.textContent, link.href);
    });
    
    // Toggle menu on hamburger click
    if (menuToggle && navbar) {
        menuToggle.addEventListener('click', function() {
            console.log('Menu toggle clicked');
            menuToggle.classList.toggle('active');
            navbar.classList.toggle('active');
        });
    }
    
    // Handle dropdown menus
    dropdowns.forEach((dropdown, index) => {
        const link = dropdown.querySelector('a');
        const dropdownContent = dropdown.querySelector('.dropdown-content');
        
        console.log(`Dropdown ${index}:`, { 
            link: link ? 'Found' : 'Not found',
            dropdownContent: dropdownContent ? 'Found' : 'Not found'
        });
        
        // Add click event for mobile
        if (link) {
            link.addEventListener('click', function(e) {
                console.log(`Dropdown ${index} clicked, mobile: ${window.innerWidth <= 768}`);
                
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    e.stopPropagation(); // Prevent event bubbling
                    
                    dropdown.classList.toggle('active');
                    
                    // Toggle this dropdown content
                    if (dropdownContent) {
                        const isActive = dropdownContent.classList.toggle('active');
                        console.log(`Dropdown ${index} content toggled to: ${isActive ? 'active' : 'inactive'}`);
                        
                        // Set display style directly in addition to class
                        dropdownContent.style.display = isActive ? 'block' : 'none';
                        
                        // Close other dropdown contents
                        dropdowns.forEach((otherDropdown, otherIndex) => {
                            if (otherDropdown !== dropdown) {
                                const otherContent = otherDropdown.querySelector('.dropdown-content');
                                if (otherContent && otherContent.classList.contains('active')) {
                                    otherDropdown.classList.remove('active');
                                    otherContent.classList.remove('active');
                                    otherContent.style.display = 'none';
                                    console.log(`Closed other dropdown ${otherIndex}`);
                                }
                            }
                        });
                    }
                }
            });
        }
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            const isClickInsideMenu = navbar.contains(e.target);
            const isClickOnToggle = menuToggle.contains(e.target);
            
            if (!isClickInsideMenu && !isClickOnToggle && navbar.classList.contains('active')) {
                console.log('Clicked outside menu, closing');
                navbar.classList.remove('active');
                menuToggle.classList.remove('active');
                
                // Close all dropdown contents
                dropdowns.forEach((dropdown, index) => {
                    dropdown.classList.remove('active');
                    const dropdownContent = dropdown.querySelector('.dropdown-content');
                    if (dropdownContent) {
                        dropdownContent.classList.remove('active');
                        dropdownContent.style.display = 'none';
                        console.log(`Closed dropdown ${index}`);
                    }
                });
            }
        }
    });
    
    // Handle window resize
    window.addEventListener('resize', function() {
        console.log('Window resized, width:', window.innerWidth);
        
        if (window.innerWidth > 768) {
            // Reset mobile menu when resizing to desktop
            if (navbar.classList.contains('active')) {
                navbar.classList.remove('active');
                menuToggle.classList.remove('active');
                console.log('Reset mobile menu on resize');
            }
            
            // Reset all dropdowns
            dropdowns.forEach((dropdown, index) => {
                dropdown.classList.remove('active');
                const dropdownContent = dropdown.querySelector('.dropdown-content');
                if (dropdownContent) {
                    dropdownContent.classList.remove('active');
                    dropdownContent.style.display = '';  // Reset to default
                    console.log(`Reset dropdown ${index} on resize`);
                }
            });
        }
    });
});