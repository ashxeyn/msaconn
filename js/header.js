document.addEventListener('DOMContentLoaded', function() {
    const menuToggle = document.querySelector('.menu-toggle');
    const navbar = document.querySelector('.navbar');
    const dropdowns = document.querySelectorAll('.dropdown');
    
    console.log('Header JS loaded', { 
        menuToggle: menuToggle ? 'Found' : 'Not found', 
        navbar: navbar ? 'Found' : 'Not found',
        dropdownsCount: dropdowns.length
    });
    
    const activeLinks = document.querySelectorAll('.nav-links a.active');
    console.log('Active links found:', activeLinks.length);
    activeLinks.forEach((link, i) => {
        console.log(`Active link ${i}:`, link.textContent, link.href);
    });
    
    if (menuToggle && navbar) {
        menuToggle.addEventListener('click', function() {
            console.log('Menu toggle clicked');
            menuToggle.classList.toggle('active');
            navbar.classList.toggle('active');
        });
    }
    
    dropdowns.forEach((dropdown, index) => {
        const link = dropdown.querySelector('a');
        const dropdownContent = dropdown.querySelector('.dropdown-content');
        const arrow = link ? link.querySelector('.arrow') : null;
        
        console.log(`Dropdown ${index}:`, { 
            link: link ? 'Found' : 'Not found',
            arrow: arrow ? 'Found' : 'Not found',
            dropdownContent: dropdownContent ? 'Found' : 'Not found'
        });
        
        if (link) {
            link.addEventListener('click', function(e) {
                console.log(`Dropdown ${index} clicked, mobile: ${window.innerWidth <= 768}`);
                
                if (window.innerWidth <= 768) {
                    e.preventDefault();
                    e.stopPropagation(); 
                    
                    const isOpen = link.classList.toggle('open');
                    console.log(`Toggling dropdown ${index} to ${isOpen ? 'open' : 'closed'}`);
                    
                    if (dropdownContent) {
                        dropdownContent.classList.toggle('active');
                        
                        if (dropdownContent.classList.contains('active')) {
                            dropdownContent.style.display = 'block';
                            console.log(`Dropdown ${index} opened`);
                        } else {
                            dropdownContent.style.display = 'none';
                            console.log(`Dropdown ${index} closed`);
                        }
                    }
                }
            });
        }
    });
    
    document.addEventListener('click', function(e) {
        if (window.innerWidth <= 768) {
            const isClickInsideMenu = navbar.contains(e.target);
            const isClickOnToggle = menuToggle.contains(e.target);
            
            if (!isClickInsideMenu && !isClickOnToggle && navbar.classList.contains('active')) {
                console.log('Clicked outside menu, closing');
                navbar.classList.remove('active');
                menuToggle.classList.remove('active');
                
                dropdowns.forEach((dropdown, index) => {
                    const link = dropdown.querySelector('a');
                    if (link) link.classList.remove('open');
                    
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
    
    window.addEventListener('resize', function() {
        console.log('Window resized, width:', window.innerWidth);
        
        if (window.innerWidth > 768) {
            if (navbar.classList.contains('active')) {
                navbar.classList.remove('active');
                menuToggle.classList.remove('active');
                console.log('Reset mobile menu on resize');
            }
            
            dropdowns.forEach((dropdown, index) => {
                const link = dropdown.querySelector('a');
                if (link) link.classList.remove('open');
                
                dropdown.classList.remove('active');
                const dropdownContent = dropdown.querySelector('.dropdown-content');
                if (dropdownContent) {
                    dropdownContent.classList.remove('active');
                    dropdownContent.style.display = '';  
                    console.log(`Reset dropdown ${index} on resize`);
                }
            });
        }
    });
});