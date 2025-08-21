
document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('header');
    
    if (header) {
        header.style.setProperty('position', 'fixed', 'important');
        header.style.setProperty('top', '0', 'important');
        header.style.setProperty('left', '0', 'important');
        header.style.setProperty('width', '100%', 'important');
        header.style.setProperty('z-index', '999999', 'important');
        
        header.classList.add('sticky-header-forced');
        
        const heroSection = document.querySelector('.hero');
        
        updateSpacing();
        
        window.addEventListener('resize', updateSpacing);
        
        window.addEventListener('load', updateSpacing);
    }
    
 
    function updateSpacing() {
        const headerHeight = header.offsetHeight;
        
        const heroSection = document.querySelector('.hero');
        if (heroSection) {
            heroSection.style.marginTop = headerHeight + 'px';
            document.body.style.paddingTop = '0';
            
            heroSection.style.marginTop = (headerHeight + 1) + 'px';
            
            const heroBackground = heroSection.querySelector('.hero-background');
            if (heroBackground) {
                heroBackground.style.height = '100%';
            }
            
            console.log('About page: Hero margin adjusted to:', (headerHeight + 1) + 'px');
        } else {
            document.body.style.paddingTop = headerHeight + 'px';
            console.log('Regular page - Body padding-top set to:', headerHeight + 'px');
        }
    }
});