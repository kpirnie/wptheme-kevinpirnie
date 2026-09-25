// DOM ready event
DOMReady(function () {

    // ========================================
    // Top header hide/show on scroll
    // ========================================
    let lastScroll = 0;
    const topHeader = document.getElementById('top-header');
    if (topHeader) {
        window.addEventListener('scroll', function () {
            const currentScroll = window.pageYOffset;

            if (currentScroll > 50) {
                if (currentScroll > lastScroll) {
                    topHeader.style.transform = 'translateY(-100%)';
                } else {
                    topHeader.style.transform = 'translateY(0)';
                }
            } else {
                topHeader.style.transform = 'translateY(0)';
            }

            lastScroll = currentScroll;
        });
    }

});