/**
 * News page JavaScript functionality
 * Controls sidebar dynamic updates and layout adjustments
 */

// Function to make the header sticky
function makeStickyHeader() {
    const header = document.querySelector('header');
    if (!header) return;
    
    // Force the header to be fixed at the top
    header.style.position = 'fixed';
    header.style.top = '0';
    header.style.left = '0';
    header.style.width = '100%';
    header.style.zIndex = '10000';
    
    // Add some padding to the main content to prevent it from being hidden under the header
    const headerHeight = header.offsetHeight;
    const main = document.querySelector('main');
    if (main) {
        main.style.paddingTop = headerHeight + 'px';
    }
    
    console.log('Header made sticky with height: ' + headerHeight + 'px');
}

// Function to fetch and update the sidebar content
function updateSidebar() {
    // Get the article ID from the data attribute on the page
    const currentArticleId = document.querySelector('meta[name="article-id"]').getAttribute('content');
    const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');
    
    // Create AJAX request
    const xhr = new XMLHttpRequest();
    // Request sidebar-only update
    xhr.open('GET', 'news.php?id=' + currentArticleId + '&ajax=1&sidebar_only=1&no_css=1', true);
    
    xhr.onload = function() {
        if (this.status === 200) {
            // Get the current sidebar
            const currentSidebar = document.querySelector('.sidebar-container');
            if (!currentSidebar) return; // Exit if no sidebar found
            
            // Create a temporary element to parse the response
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = this.responseText;
            
            // Get the new sidebar content
            const newSidebar = tempDiv.querySelector('.sidebar-container');
            
            // Only update if we found valid sidebar content in the response
            if (newSidebar) {
                // Update the innerHTML instead of replacing the entire element
                currentSidebar.innerHTML = newSidebar.innerHTML;
                
                // Fix any broken image paths by adding base URL if needed
                currentSidebar.querySelectorAll('img.sidebar-image').forEach(img => {
                    // If the image is not loading, try to fix the path
                    img.onerror = function() {
                        const originalSrc = this.getAttribute('src');
                        // Check if the path is relative and needs to be fixed
                        if (originalSrc && !originalSrc.startsWith('http') && !originalSrc.startsWith('/')) {
                            this.src = baseUrl + originalSrc;
                        }
                    };
                    
                    // Force image reload
                    const currentSrc = img.getAttribute('src');
                    if (currentSrc) {
                        img.src = currentSrc + (currentSrc.includes('?') ? '&' : '?') + 'cache=' + new Date().getTime();
                    }
                });
                
                console.log('Sidebar content updated at ' + new Date().toLocaleTimeString());
            } else {
                console.error('Invalid sidebar content received');
            }
        }
    };
    
    xhr.onerror = function() {
        console.error('Error updating sidebar');
    };
    
    xhr.send();
}

// Function to update layout based on elements' heights
function updateLayout() {
    const header = document.querySelector('header');
    const main = document.querySelector('main');
    const sidebar = document.querySelector('.sidebar-container');
    const footer = document.querySelector('footer');
    
    if (!header || !main || !sidebar || !footer) return;
    
    // Get heights
    const headerHeight = header.offsetHeight;
    const footerHeight = footer.offsetHeight;
    const windowHeight = window.innerHeight;
    
    // Handle mobile view
    function handleMediaQueries() {
        if (window.innerWidth <= 992) {
            // Mobile layout
            sidebar.style.position = 'relative';
            sidebar.style.height = 'auto';
        } else {
            // Desktop layout - update layout for proper sidebar positioning
            sidebar.style.position = 'sticky';
            sidebar.style.height = '100vh';
        }
    }
    
    // Run media query handler
    handleMediaQueries();
}

// Add a scroll event listener to ensure header stickiness
window.addEventListener('scroll', function() {
    const header = document.querySelector('header');
    if (header) {
        // Reinforce sticky behavior on scroll
        Object.assign(header.style, {
            position: 'sticky',
            top: '0',
            zIndex: '999999'
        });
    }
});

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Starting news page functionality');
    
    // Get current article ID from meta tag
    const articleId = document.querySelector('meta[name="article-id"]').content;
    const baseUrl = document.querySelector('meta[name="base-url"]').content;
    
    // Highlight current article in sidebar
    const currentItem = document.querySelector(`.update-item[data-id="${articleId}"]`);
    if (currentItem) {
        currentItem.classList.add('active');
        // Scroll the sidebar to show the active item
        setTimeout(() => {
            currentItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }, 300);
    }
    
    // Fix header stickiness with more forceful approach
    const header = document.querySelector('header');
    if (header) {
        // Use more forceful approach to make header sticky
        Object.assign(header.style, {
            position: 'sticky',
            top: '0',
            zIndex: '999999',
            marginBottom: '-3px'
        });
        
        // Add !important to position sticky through style tag
        const stickyStyle = document.createElement('style');
        stickyStyle.textContent = `
            header {
                position: sticky !important;
                top: 0 !important;
                z-index: 999999 !important;
            }
            
            @media screen and (max-width: 768px) {
                header {
                    position: sticky !important;
                }
            }
        `;
        document.head.appendChild(stickyStyle);
        
        // Create a pseudo-element to extend the header down
        const headerStyle = document.createElement('style');
        headerStyle.textContent = `
            header::after {
                content: "";
                display: block;
                height: 5px;
                width: 100%;
                background-color: #fff;
                position: absolute;
                bottom: -3px;
                left: 0;
                z-index: 999998;
            }
        `;
        document.head.appendChild(headerStyle);
        
        // Ensure absolutely no gap between header and content with extreme measures
        const pageContainer = document.querySelector('.page-container');
        const mainElement = document.querySelector('main');
        const articleContainer = document.querySelector('.article-container');
        
        if (pageContainer) {
            pageContainer.style.marginTop = '-3px';
            pageContainer.style.paddingTop = '0';
            pageContainer.style.transform = 'translateY(-2px)';
        }
        
        if (mainElement) {
            mainElement.style.marginTop = '-3px';
            mainElement.style.paddingTop = '0';
            mainElement.style.transform = 'translateY(-2px)';
        }
        
        if (articleContainer) {
            articleContainer.style.marginTop = '-3px';
            articleContainer.style.paddingTop = '0';
            articleContainer.style.transform = 'translateY(-2px)';
        }
        
        // Also fix any article header spacing
        const articleHeader = document.querySelector('.article-header');
        if (articleHeader) {
            articleHeader.style.paddingTop = '2rem';  // Increased padding to move content lower
            articleHeader.style.marginTop = '0';
        }
        
        // Fix dropdown menus
        const dropdowns = document.querySelectorAll('.nav-links .dropdown');
        dropdowns.forEach(dropdown => {
            const dropdownContent = dropdown.querySelector('.dropdown-content');
            if (dropdownContent) {
                // Ensure dropdowns have proper z-index and positioning
                dropdownContent.style.zIndex = '9999999';
                dropdownContent.style.position = 'absolute';
                
                // Fix hover behavior on desktop
                if (window.innerWidth > 768) {
                    dropdown.addEventListener('mouseenter', function() {
                        dropdownContent.style.display = 'block';
                    });
                    
                    dropdown.addEventListener('mouseleave', function() {
                        dropdownContent.style.display = 'none';
                    });
                }
            }
        });
    }
    
    // Make sure sidebar doesn't overlap with content
    const sidebar = document.querySelector('.sidebar-container');
    if (sidebar) {
        sidebar.style.overflowY = 'auto';
    }
    
    // AJAX sidebar update functionality (if implemented)
    const updateLinks = document.querySelectorAll('.update-link');
    updateLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Existing AJAX functionality would go here
        });
    });
    
    // Initial layout update
    updateLayout();
    
    // Update layout on window resize
    window.addEventListener('resize', function() {
        updateLayout();
        makeStickyHeader(); // Re-apply sticky header on resize
    });
    
    // Update layout when all content is loaded
    window.addEventListener('load', function() {
        updateLayout();
        makeStickyHeader(); // Make sure header is sticky when all content is loaded
    });
    
    // Initial sidebar update after 3 seconds
    setTimeout(updateSidebar, 3000);
    
    // Then regular updates every 10 seconds
    setInterval(updateSidebar, 10000);
});
