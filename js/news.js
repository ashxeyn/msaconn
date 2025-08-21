

function makeStickyHeader() {
    console.log('Original makeStickyHeader called - functionality moved to news-header-fix.js');
}

function updateSidebar() {
    const currentArticleId = document.querySelector('meta[name="article-id"]').getAttribute('content');
    const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content');
    
    const xhr = new XMLHttpRequest();
    xhr.open('GET', 'news.php?id=' + currentArticleId + '&ajax=1&sidebar_only=1&no_css=1', true);
    
    xhr.onload = function() {
        if (this.status === 200) {
            const currentSidebar = document.querySelector('.sidebar-container');
            if (!currentSidebar) return; 
            
            const tempDiv = document.createElement('div');
            tempDiv.innerHTML = this.responseText;
            
            const newSidebar = tempDiv.querySelector('.sidebar-container');
            
            if (newSidebar) {
                currentSidebar.innerHTML = newSidebar.innerHTML;
                
                currentSidebar.querySelectorAll('img.sidebar-image').forEach(img => {
                    img.onerror = function() {
                        const originalSrc = this.getAttribute('src');
                        if (originalSrc && !originalSrc.startsWith('http') && !originalSrc.startsWith('/')) {
                            this.src = baseUrl + originalSrc;
                        }
                    };
                    
                    const currentSrc = img.getAttribute('src');
                    if (currentSrc) {
                        img.src = currentSrc + (currentSrc.includes('?') ? '&' : '?') + 'cache=' + new Date().getTime();
                    }
                });
                
                console.log('Sidebar content updated at ' + new Date().toLocaleTimeString());
            } else {
                console.error('Invalid sidebar content received');
            }
        }
    };
    
    xhr.onerror = function() {
        console.error('Error updating sidebar');
    };
    
    xhr.send();
}

function updateLayout() {
    const header = document.querySelector('header');
    const main = document.querySelector('main');
    const sidebar = document.querySelector('.sidebar-container');
    const footer = document.querySelector('footer');
    
    if (!header || !main || !sidebar || !footer) return;
    
    const headerHeight = header.offsetHeight;
    const footerHeight = footer.offsetHeight;
    const windowHeight = window.innerHeight;
    
    function handleMediaQueries() {
        if (window.innerWidth <= 992) {
            sidebar.style.position = 'relative';
            sidebar.style.height = 'auto';
        } else {
            sidebar.style.position = 'sticky';
            sidebar.style.height = '100vh';
        }
    }
    
    handleMediaQueries();
}

document.addEventListener('DOMContentLoaded', function() {
    console.log('Starting news page functionality');
    
    makeStickyHeader();
    
    updateLayout();
    
    window.addEventListener('resize', function() {
        updateLayout();
    });
    
    window.addEventListener('load', function() {
        updateLayout();
    });
    
    setTimeout(updateSidebar, 5000);
    
    setInterval(updateSidebar, 10000);
});
