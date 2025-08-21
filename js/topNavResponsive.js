
(function() {
    function adjustTopNav() {
        const sidebar = document.querySelector('.sidebar') || document.getElementById('sidebar');
        const topNav = document.querySelector('.admin-topbar');
        
        if (!sidebar || !topNav) return;
        
        const sidebarWidth = sidebar.getBoundingClientRect().width;
        
        if (sidebarWidth > 0) {
            topNav.style.left = sidebarWidth + 'px';
        }
    }
    
    window.addEventListener('DOMContentLoaded', function() {
        setTimeout(adjustTopNav, 100);
        
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
        
        if (typeof ResizeObserver !== 'undefined') {
            const sidebar = document.querySelector('.sidebar') || document.getElementById('sidebar');
            if (sidebar) {
                const resizeObserver = new ResizeObserver(function() {
                    adjustTopNav();
                });
                resizeObserver.observe(sidebar);
            }
        }
        
        window.addEventListener('resize', adjustTopNav);
        
        let checkCount = 0;
        const intervalId = setInterval(function() {
            adjustTopNav();
            checkCount++;
            if (checkCount >= 10) {
                clearInterval(intervalId);
            }
        }, 200); 
    });
})(); 