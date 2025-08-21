

(function() {
    function applyHeaderFix() {
        const isNewsPage = window.location.pathname.includes('/news.php') || 
                          document.querySelector('.article-container') !== null;
        
        if (!isNewsPage) return;
        
        document.body.classList.add('news-page');
        
        const header = document.querySelector('header');
        const main = document.querySelector('main');
        const pageContainer = document.querySelector('.page-container');
        const articleContainer = document.querySelector('.article-container');
        const sidebarContainer = document.querySelector('.sidebar-container');
        
        if (!header || !main) return;
        
        const headerHeight = header.offsetHeight || 140;

        
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
        
        document.body.style.cssText += `
            padding-top: ${headerHeight}px !important;
            margin-top: 0 !important;
        `;
        
        if (main) {
            main.style.cssText += `
                margin-top: 0 !important;
                padding-top: 0 !important;
                position: relative !important;
            `;
        }
        
        if (pageContainer) {
            pageContainer.style.cssText += `
                margin-top: 0 !important;
                padding-top: 0 !important;
                position: relative !important;
            `;
        }
        
        if (articleContainer) {
            articleContainer.style.cssText += `
                margin-top: 10px !important; /* Just enough spacing */
                padding-top: 0 !important;
                position: relative !important;
            `;
        }
        
        if (sidebarContainer) {
            if (window.innerWidth >= 992) {
                sidebarContainer.style.cssText += `
                    position: sticky !important;
                    top: ${headerHeight + 10}px !important;
                    height: calc(100vh - ${headerHeight + 10}px) !important;
                    max-height: calc(100vh - ${headerHeight + 10}px) !important;
                    margin-top: 10px !important;
                `;
            } else {
                sidebarContainer.style.cssText += `
                    position: relative !important;
                    top: 0 !important;
                    height: auto !important;
                    margin-top: 10px !important;
                `;
            }
        }
        
        const dropdowns = document.querySelectorAll('.nav-links .dropdown');
        dropdowns.forEach(dropdown => {
            dropdown.style.position = 'relative';
            
            const dropdownContent = dropdown.querySelector('.dropdown-content');
            if (dropdownContent) {
                dropdownContent.style.cssText = `
                    position: absolute !important;
                    z-index: 9999999 !important;
                `;
                
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
    
    document.addEventListener('DOMContentLoaded', applyHeaderFix);
    
    window.addEventListener('resize', applyHeaderFix);
    
    window.addEventListener('load', applyHeaderFix);
    
    if (document.readyState === 'complete' || document.readyState === 'interactive') {
        setTimeout(applyHeaderFix, 0);
    }
})(); 