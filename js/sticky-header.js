/**
 * Enhanced Sticky Header JavaScript
 * 
 * This script ensures the header remains properly fixed at the top of all pages,
 * and adjusts content positioning to prevent header overlap.
 */
document.addEventListener('DOMContentLoaded', function() {
    // Get header element
    const header = document.querySelector('header');
    
    if (header) {
        // Force position fixed with !important through JS
        header.style.setProperty('position', 'fixed', 'important');
        header.style.setProperty('top', '0', 'important');
        header.style.setProperty('left', '0', 'important');
        header.style.setProperty('width', '100%', 'important');
        header.style.setProperty('z-index', '999999', 'important');
        
        // Add helper class
        header.classList.add('sticky-header-forced');
        
        // Get hero section if on about us page
        const heroSection = document.querySelector('.hero');
        
        // Set initial spacing
        updateSpacing();
        
        // Update spacing on window resize
        window.addEventListener('resize', updateSpacing);
        
        // Update again after all images and resources load
        window.addEventListener('load', updateSpacing);
    }
    
    /**
     * Calculate and update the spacing based on current header height
     */
    function updateSpacing() {
        const headerHeight = header.offsetHeight;
        
        // Check if we're on the about us page (has hero section)
        const heroSection = document.querySelector('.hero');
        if (heroSection) {
            // Remove any existing inline styles that might interfere
            heroSection.style.marginTop = headerHeight + 'px';
            document.body.style.paddingTop = '0';
            
            // Apply a very small positive offset (1px)
            heroSection.style.marginTop = (headerHeight + 1) + 'px';
            
            // Ensure the hero background extends properly
            const heroBackground = heroSection.querySelector('.hero-background');
            if (heroBackground) {
                heroBackground.style.height = '100%';
            }
            
            // Debug info
            console.log('About page: Hero margin adjusted to:', (headerHeight + 1) + 'px');
        } else {
            // On other pages - use body padding
            document.body.style.paddingTop = headerHeight + 'px';
            console.log('Regular page - Body padding-top set to:', headerHeight + 'px');
        }
    }
});