// Performance optimization script
document.addEventListener('DOMContentLoaded', function() {
    // Lazy load images
    const lazyImages = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                observer.unobserve(img);
            }
        });
    });
    
    lazyImages.forEach(img => imageObserver.observe(img));
    
    // Defer non-critical CSS
    const deferredStyles = document.querySelectorAll('link[data-defer]');
    deferredStyles.forEach(style => {
        style.setAttribute('media', 'print');
        style.addEventListener('load', function() {
            this.media = 'all';
        });
    });
    
    // Preconnect to external domains
    const preconnectLinks = [
        'https://fonts.googleapis.com',
        'https://fonts.gstatic.com',
        'https://cdn.jsdelivr.net'
    ];
    
    preconnectLinks.forEach(domain => {
        const link = document.createElement('link');
        link.rel = 'preconnect';
        link.href = domain;
        link.crossOrigin = domain.includes('fonts.gstatic.com') ? 'anonymous' : '';
        document.head.appendChild(link);
    });
    
    // Optimize animations for performance
    const animatedElements = document.querySelectorAll('.animated-gradient, .floating-shapes, .shape');
    animatedElements.forEach(el => {
        el.style.willChange = 'transform, opacity';
    });
    
    // Debounce scroll and resize events
    function debounce(func, wait) {
        let timeout;
        return function() {
            const context = this;
            const args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), wait);
        };
    }
    
    // Optimize scroll performance
    const scrollHandler = debounce(() => {
        // Your scroll handling code
    }, 16);
    
    window.addEventListener('scroll', scrollHandler, { passive: true });
    
    // Optimize resize performance
    const resizeHandler = debounce(() => {
        // Your resize handling code
    }, 250);
    
    window.addEventListener('resize', resizeHandler, { passive: true });
    
    // Add resource hints for critical resources
    const resourceHints = [
        { rel: 'preload', href: 'styles.css', as: 'style' },
        { rel: 'preload', href: 'https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@300;400;500;600;700&family=Montserrat:wght@300;400;500&display=swap', as: 'style' }
    ];
    
    resourceHints.forEach(hint => {
        const link = document.createElement('link');
        link.rel = hint.rel;
        link.href = hint.href;
        link.as = hint.as;
        document.head.appendChild(link);
    });
    
    // Optimize form submission
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', function(e) {
            // Prevent double submission
            if (this.classList.contains('submitting')) {
                e.preventDefault();
                return;
            }
            
            this.classList.add('submitting');
            
            // Re-enable form after submission
            setTimeout(() => {
                this.classList.remove('submitting');
            }, 5000);
        });
    });
    
    // Add offline support with service worker
    if ('serviceWorker' in navigator) {
        window.addEventListener('load', () => {
            navigator.serviceWorker.register('/sw.js')
                .then(registration => {
                    console.log('ServiceWorker registration successful');
                })
                .catch(err => {
                    console.log('ServiceWorker registration failed: ', err);
                });
        });
    }
}); 