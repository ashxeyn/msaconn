document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('executive-officers-container');
    const cards = Array.from(document.querySelectorAll('.officer-card'));
    const cardWidth = cards[0].offsetWidth;
    const gap = 24; // 1.5rem gap in pixels
    let animationFrame;
    let isPaused = false;
    let speed = 2.5; // pixels per frame, increase for faster scroll
    let position = -(cardWidth + gap); // Start at the first real card (after the clone)

    // Clone all cards for seamless looping
    cards.forEach(card => {
        const clone = card.cloneNode(true);
        clone.classList.add('clone');
        container.appendChild(clone);
    });

    // Total width of all cards (original + clones)
    const totalCards = container.querySelectorAll('.officer-card').length;
    const totalWidth = (cardWidth + gap) * totalCards;
    const originalCardsWidth = (cardWidth + gap) * cards.length;

    // Set initial position
    function setPosition() {
        container.style.transition = 'none';
        container.style.transform = `translateX(${position}px)`;
    }

    // Continuous animation loop
    function animate() {
        if (!isPaused) {
            position -= speed;
            // If we've scrolled past the original set, reset to start
            if (Math.abs(position) >= originalCardsWidth) {
                position = -(cardWidth + gap);
            }
            container.style.transform = `translateX(${position}px)`;
        }
        animationFrame = requestAnimationFrame(animate);
    }

    // Pause on hover
    container.addEventListener('mouseenter', () => {
        isPaused = true;
    });
    container.addEventListener('mouseleave', () => {
        isPaused = false;
    });

    // Optional: Manual scroll buttons to speed up or reverse
    const scrollLeft = document.querySelector('.scroll-button[onclick*="left"]');
    const scrollRight = document.querySelector('.scroll-button[onclick*="right"]');
    if (scrollLeft && scrollRight) {
        scrollLeft.addEventListener('click', () => {
            speed = Math.abs(speed) * -1; // Reverse direction
        });
        scrollRight.addEventListener('click', () => {
            speed = Math.abs(speed); // Forward direction
        });
    }

    // Set initial position and start animation
    setPosition();
    animate();
    
});
