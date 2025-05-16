/**
 * News Page Header Fix
 * This script specifically addresses header issues in news.php
 * FORCEFUL APPROACH to ensure content is properly positioned
 */

(function() {
    // Function to apply fixed header and position content correctly
    function applyHeaderFix() {
        // Check if we're on the news page
        const isNewsPage = window.location.pathname.includes('/news.php') || 
                          document.querySelector('.article-container') !== null;
        
        if (!isNewsPage) return;
        
        // Add class to body for CSS targeting
        document.body.classList.add('news-page');
        
        // Get elements
        const header = document.querySelector('header');
        const main = document.querySelector('main');
        const pageContainer = document.querySelector('.page-container');
        const articleContainer = document.querySelector('.article-container');
        const sidebarContainer = document.querySelector('.sidebar-container');
        
        if (!header || !main) return;
        
        // Measure the header height - use actual height
        const headerHeight = header.offsetHeight || 140;

        // BALANCED APPROACH - moderate spacing
        
        // 1. Make the header fixed at the top
        header.style.cssText = `
            position: fixed !important;
            top: 0 !important;
            left: 0 !important;
            right: 0 !important;
            width: 100% !important;
            z-index: 999999 !important;
            margin: 0 !important;
            padding-bottom: 0 !important;
            overflow: visible !important;
        `;
        
        // 2. Adjust body padding to position content correctly
        document.body.style.cssText += `
            padding-top: ${headerHeight}px !important;
            margin-top: 0 !important;
        `;
        
        // 3. Position the main content with minimal spacing
        if (main) {
            main.style.cssText += `
                margin-top: 0 !important;
                padding-top: 0 !important;
                position: relative !important;
            `;
        }
        
        // 4. Fix the page container with minimal spacing
        if (pageContainer) {
            pageContainer.style.cssText += `
                margin-top: 0 !important;
                padding-top: 0 !important;
                position: relative !important;
            `;
        }
        
        // 5. Fix the article container with minimal spacing
        if (articleContainer) {
            articleContainer.style.cssText += `
                margin-top: 10px !important; /* Just enough spacing */
                padding-top: 0 !important;
                position: relative !important;
            `;
        }
        
        // 6. Fix the sidebar container with matching spacing
        if (sidebarContainer) {
            if (window.innerWidth >= 992) {
                // Desktop view - make sidebar sticky
                sidebarContainer.style.cssText += `
                    position: sticky !important;
                    top: ${headerHeight + 10}px !important;
                    height: calc(100vh - ${headerHeight + 10}px) !important;
                    max-height: calc(100vh - ${headerHeight + 10}px) !important;
                    margin-top: 10px !important;
                `;
            } else {
                // Mobile view - make sidebar normal flow
                sidebarContainer.style.cssText += `
                    position: relative !important;
                    top: 0 !important;
                    height: auto !important;
                    margin-top: 10px !important;
                `;
            }
        }
        
        // 7. Ensure dropdown menus work
        const dropdowns = document.querySelectorAll('.nav-links .dropdown');
        dropdowns.forEach(dropdown => {
            dropdown.style.position = 'relative';
            
            const dropdownContent = dropdown.querySelector('.dropdown-content');
            if (dropdownContent) {
                dropdownContent.style.cssText = `
                    position: absolute !important;
                    z-index: 9999999 !important;
                `;
                
                // Fix hover behavior
                dropdown.addEventListener('mouseenter', function() {
                    dropdownContent.style.display = 'block';
                });
                
                dropdown.addEventListener('mouseleave', function() {
                    dropdownContent.style.display = 'none';
                });
            }
        });
        
        console.log('BALANCED header fix applied with header height:', headerHeight);
    }
    
    // Apply on DOM ready
    document.addEventListener('DOMContentLoaded', applyHeaderFix);
    
    // Apply on resize
    window.addEventListener('resize', applyHeaderFix);
    
    // Apply on load
    window.addEventListener('load', applyHeaderFix);
    
    // Apply immediately if document is already loaded
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(applyHeaderFix, 0);
    }
})(); 