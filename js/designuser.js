document.addEventListener('DOMContentLoaded', function() {
    initGlassCards();
    
    window.addEventListener('resize', handleResize);
    
    handleResize();
});

function handleResize() {
    const width = window.innerWidth;
    const cards = document.querySelectorAll('.officer-card');
    
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
    
    container.style.opacity = 1;
    
    setupGlassCards();
    
    document.addEventListener('officersUpdated', function() {
        setupGlassCards();
        handleResize();
    });
}

function setupGlassCards() {
    const cards = document.querySelectorAll('.officer-card');
    
    cards.forEach(card => {
        if (card.dataset.initialized) return;
        
        card.dataset.initialized = true;
        
        if (!card.querySelector('.blur-bg')) {
            const blurBg = document.createElement('div');
            blurBg.className = 'blur-bg';
            card.prepend(blurBg);
        }
        
        const supportsHover = window.matchMedia("(hover: hover)").matches;
        
        if (supportsHover) {
            card.addEventListener('mouseenter', function() {
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

document.addEventListener('DOMContentLoaded', function() {
    const scrollOptions = passiveSupported ? { passive: true } : false;
    window.addEventListener('scroll', optimizeOnScroll, scrollOptions);
});

function optimizeOnScroll() {
    const viewHeight = window.innerHeight;
    const scrollTop = window.scrollY;
    const cards = document.querySelectorAll('.officer-card');
    
    cards.forEach(card => {
        const rect = card.getBoundingClientRect();
        const isVisible = (rect.top < viewHeight && rect.bottom > 0);
        
        if (!isVisible) {
            card.style.willChange = 'auto';
        } else {
            card.style.willChange = 'transform';
        }
    });
}
