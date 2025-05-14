document.addEventListener('DOMContentLoaded', function() {
    // Initialize immediately
    initGlassCards();
    
    // Add resize handler for responsive adjustments
    window.addEventListener('resize', handleResize);
    
    // Call it once to set initial state
    handleResize();
});

// Handle viewport size changes
function handleResize() {
    const width = window.innerWidth;
    const cards = document.querySelectorAll('.officer-card');
    
    // Apply different styles based on viewport width
    if (width < 480) {
        cards.forEach(card => {
            if (card.querySelector('.officer-bio')) {
                card.querySelector('.officer-bio').style.fontSize = '0.8rem';
            }
        });
    } else if (width < 768) {
        cards.forEach(card => {
            if (card.querySelector('.officer-bio')) {
                card.querySelector('.officer-bio').style.fontSize = '0.85rem';
            }
        });
    } else {
        cards.forEach(card => {
            if (card.querySelector('.officer-bio')) {
                card.querySelector('.officer-bio').style.fontSize = '';
            }
        });
    }
}

function initGlassCards() {
    const container = document.getElementById('executive-officers-container');
    if (!container) return;
    
    // Make container visible
    container.style.opacity = 1;
    
    // Setup hover effects for existing cards
    setupGlassCards();
    
    // Listen for officer content updates
    document.addEventListener('officersUpdated', function() {
        setupGlassCards();
        // Also run resize handler to apply responsive styles
        handleResize();
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
        
        // Check if device supports hover
        const supportsHover = window.matchMedia("(hover: hover)").matches;
        
        if (supportsHover) {
            // Add hover effects to enhance the glassmorphism feel
            card.addEventListener('mouseenter', function() {
                // Only apply these effects if not on a mobile device
                if (window.innerWidth > 768) {
                    card.style.transform = 'translateY(-10px)';
                    card.style.background = 'rgba(255, 255, 255, 0.1)';
                    card.style.boxShadow = '0 15px 35px rgba(0, 0, 0, 0.2)';
                    
                    const image = card.querySelector('.officer-image');
                    if (image) {
                        image.style.transform = 'scale(1.05)';
                        image.style.boxShadow = '0 8px 25px rgba(0, 0, 0, 0.3)';
                        image.style.borderColor = 'rgba(255, 255, 255, 0.5)';
                    }
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
        } else {
            // For touch devices, add a subtle tap effect
            card.addEventListener('touchstart', function() {
                card.style.transform = 'translateY(-5px)';
                card.style.transition = 'transform 0.2s ease';
            });
            
            card.addEventListener('touchend', function() {
                card.style.transform = '';
            });
        }
    });
}

// Detect passive event support for better performance on mobile
let passiveSupported = false;
try {
    const options = {
        get passive() {
            passiveSupported = true;
            return false;
        }
    };
    window.addEventListener("test", null, options);
    window.removeEventListener("test", null, options);
} catch (err) {
    passiveSupported = false;
}

// Performance optimizations for mobile scrolling
document.addEventListener('DOMContentLoaded', function() {
    // Use passive listeners for scroll events
    const scrollOptions = passiveSupported ? { passive: true } : false;
    window.addEventListener('scroll', optimizeOnScroll, scrollOptions);
});

// Optimize elements based on scroll position
function optimizeOnScroll() {
    // Get visible elements only
    const viewHeight = window.innerHeight;
    const scrollTop = window.scrollY;
    const cards = document.querySelectorAll('.officer-card');
    
    cards.forEach(card => {
        const rect = card.getBoundingClientRect();
        const isVisible = (rect.top < viewHeight && rect.bottom > 0);
        
        // Optimize rendering for off-screen elements
        if (!isVisible) {
            card.style.willChange = 'auto';
        } else {
            card.style.willChange = 'transform';
        }
    });
}
