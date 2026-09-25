DOMReady(function () {

    const lazyBackgrounds = document.querySelectorAll('.kpt-lazy-bg');

    if ('IntersectionObserver' in window && lazyBackgrounds.length > 0) {
        const bgObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const bg = entry.target;
                    const bgUrl = bg.getAttribute('data-bg');
                    if (bgUrl) {
                        bg.style.backgroundImage = `url('${bgUrl}')`;
                        bg.removeAttribute('data-bg');
                    }
                    bgObserver.unobserve(bg);
                }
            });
        }, {
            rootMargin: '50px'
        });

        lazyBackgrounds.forEach(bg => bgObserver.observe(bg));
    } else {
        // Fallback for browsers without IntersectionObserver
        lazyBackgrounds.forEach(bg => {
            const bgUrl = bg.getAttribute('data-bg');
            if (bgUrl) {
                bg.style.backgroundImage = `url('${bgUrl}')`;
            }
        });
    }

});