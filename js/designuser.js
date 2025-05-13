document.addEventListener('DOMContentLoaded', function() {
    // Initialize immediately
    initGlassCards();
});

function initGlassCards() {
    const container = document.getElementById('executive-officers-container');
    if (!container) return;
    
    // Make container visible
    container.style.opacity = 1;
    
    // Add font awesome stylesheet if not already added
    if (!document.querySelector('link[href*="font-awesome"]')) {
        const link = document.createElement('link');
        link.rel = 'stylesheet';
        link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css';
        document.head.appendChild(link);
    }
    
    // Setup hover effects for existing cards
    setupGlassCards();
    
    // Listen for officer content updates
    document.addEventListener('officersUpdated', function() {
        setupGlassCards();
    });
}

function setupGlassCards() {
    // Get all officer cards
    const cards = document.querySelectorAll('.officer-card');
    
    cards.forEach(card => {
        // Skip if already initialized
        if (card.dataset.initialized) return;
        
        // Mark as initialized
        card.dataset.initialized = true;
        
        // Add blur background if not present
        if (!card.querySelector('.blur-bg')) {
            const blurBg = document.createElement('div');
            blurBg.className = 'blur-bg';
            card.prepend(blurBg);
        }
        
        // Add social links if not present
        if (!card.querySelector('.social-links')) {
            const socialLinks = document.createElement('ul');
            socialLinks.className = 'social-links';
            socialLinks.innerHTML = `
                <li><a href="#"><i class="fas fa-envelope"></i></a></li>
                <li><a href="#"><i class="fas fa-linkedin"></i></a></li>
            `;
            card.appendChild(socialLinks);
        }
        
        // Add hover effects to enhance the glassmorphism feel
        card.addEventListener('mouseenter', function() {
            card.style.transform = 'translateY(-10px)';
            card.style.background = 'rgba(255, 255, 255, 0.1)';
            card.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.2)';
            
            const image = card.querySelector('.officer-image');
            if (image) {
                image.style.transform = 'scale(1.05)';
                image.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.3)';
                image.style.borderColor = 'rgba(255, 255, 255, 0.5)';
            }
        });
        
        card.addEventListener('mouseleave', function() {
            card.style.transform = '';
            card.style.background = '';
            card.style.boxShadow = '';
            
            const image = card.querySelector('.officer-image');
            if (image) {
                image.style.transform = '';
                image.style.boxShadow = '';
                image.style.borderColor = '';
            }
        });
    });
}
