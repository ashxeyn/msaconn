/**
 * Directly manages the responsive positioning of the top navigation bar
 * based on the actual sidebar width
 */
(function() {
    function adjustTopNav() {
        const sidebar = document.querySelector('.sidebar') || document.getElementById('sidebar');
        const topNav = document.querySelector('.admin-topbar');
        
        if (!sidebar || !topNav) return;
        
        // Get actual width of the sidebar
        const sidebarWidth = sidebar.getBoundingClientRect().width;
        
        // Set the left position of the top nav to match sidebar width
        if (sidebarWidth > 0) {
            topNav.style.left = sidebarWidth + 'px';
        }
    }
    
    // Run on initial load with a small delay to ensure DOM is ready
    window.addEventListener('DOMContentLoaded', function() {
        // Initial adjustment with a slight delay
        setTimeout(adjustTopNav, 100);
        
        // Set up mutation observer to detect sidebar changes
        if (typeof MutationObserver !== 'undefined') {
            const sidebar = document.querySelector('.sidebar') || document.getElementById('sidebar');
            if (sidebar) {
                const observer = new MutationObserver(function(mutations) {
                    adjustTopNav();
                });
                
                observer.observe(sidebar, { 
                    attributes: true, 
                    attributeFilter: ['style', 'class'],
                    subtree: false 
                });
            }
        }
        
        // Use ResizeObserver to track sidebar size changes directly
        if (typeof ResizeObserver !== 'undefined') {
            const sidebar = document.querySelector('.sidebar') || document.getElementById('sidebar');
            if (sidebar) {
                const resizeObserver = new ResizeObserver(function() {
                    adjustTopNav();
                });
                resizeObserver.observe(sidebar);
            }
        }
        
        // Listen for window resize events as a fallback
        window.addEventListener('resize', adjustTopNav);
        
        // Continually check during initial page load
        let checkCount = 0;
        const intervalId = setInterval(function() {
            adjustTopNav();
            checkCount++;
            if (checkCount >= 10) {
                clearInterval(intervalId);
            }
        }, 200); // Check every 200ms for 2 seconds total
    });
})(); 