/**
 * News page JavaScript functionality
 * Controls sidebar dynamic updates and layout adjustments
 */

// Function to make the header sticky
function makeStickyHeader() {
    // This function is intentionally left minimal to avoid conflicts with news-header-fix.js
    // The actual fixed header implementation is now handled by news-header-fix.js
    console.log('Original makeStickyHeader called - functionality moved to news-header-fix.js');
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

// Initialize everything when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    console.log('Starting news page functionality');
    
    // The header stickiness is now handled by news-header-fix.js
    // We keep this call for backward compatibility
    makeStickyHeader();
    
    // Initial layout update
    updateLayout();
    
    // Update layout on window resize
    window.addEventListener('resize', function() {
        updateLayout();
    });
    
    // Update layout when all content is loaded
    window.addEventListener('load', function() {
        updateLayout();
    });
    
    // Initial sidebar update after 3 seconds
    setTimeout(updateSidebar, 5000);
    
    // Then regular updates every 10 seconds
    setInterval(updateSidebar, 10000);
});
