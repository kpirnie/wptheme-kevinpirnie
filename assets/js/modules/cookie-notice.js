// DOM ready event
DOMReady(function () {

    // ========================================
    // Cookie Notice Functions
    // ========================================
    function getCookie(name) {
        const value = `; ${document.cookie}`;
        const parts = value.split(`; ${name}=`);
        if (parts.length === 2) return parts.pop().split(';').shift();
    }

    function setCookie(name, value, days) {
        const date = new Date();
        date.setTime(date.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = `${name}=${value};expires=${date.toUTCString()};path=/;SameSite=Lax`;
    }

    function disableScroll() {
        document.body.style.overflow = 'hidden';
        document.body.style.paddingRight = (window.innerWidth - document.documentElement.clientWidth) + 'px';
    }

    function enableScroll() {
        document.body.style.overflow = '';
        document.body.style.paddingRight = '';
    }

    async function loadCookiePolicy() {
        const modalContent = document.getElementById('kp-modal-content');

        try {
            const response = await fetch('/cookie-policy/');

            if (!response.ok) {
                throw new Error('Failed to load cookie policy');
            }

            const html = await response.text();
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');

            // Extract the main content (adjust selector based on your page structure)
            const content = doc.querySelector('.article-content') || doc.querySelector('article') || doc.querySelector('main');

            if (content) {
                modalContent.innerHTML = content.innerHTML;
            } else {
                modalContent.innerHTML = '<p class="text-center">Unable to load cookie policy content.</p>';
            }
        } catch (error) {
            console.error('Error loading cookie policy:', error);
            modalContent.innerHTML = '<p class="text-center text-red-400">Error loading cookie policy. Please visit the <a href="/about-kevin-pirnie/cookie-policy/" class="underline">Cookie Policy page</a>.</p>';
        }
    }

    // Cookie Notice Elements
    const notice = document.getElementById('kp-cookie-notice');
    const overlay = document.getElementById('kp-cookie-overlay');
    const acceptBtn = document.getElementById('kp-cookie-accept');
    const declineBtn = document.getElementById('kp-cookie-decline');
    const learnMoreBtn = document.getElementById('kp-cookie-learn-more');
    const modal = document.getElementById('kp-cookie-modal');
    const modalClose = document.getElementById('kp-modal-close');
    const modalOverlay = document.getElementById('kp-modal-overlay');

    // Check if user has made any choice
    const cookieConsent = getCookie('kp_cookie_consent');

    // Show cookie notice only if no consent decision has been made
    if (notice && overlay && !cookieConsent) {
        notice.style.display = 'block';
        notice.classList.remove('hidden');
        overlay.style.display = 'block';
        overlay.classList.remove('hidden');
        disableScroll();
    }

    // Accept cookies
    if (acceptBtn) {
        acceptBtn.addEventListener('click', function () {
            setCookie('kp_cookie_consent', 'accepted', 365);
            notice.style.display = 'none';
            overlay.style.display = 'none';
            enableScroll();
        });
    }

    // Decline cookies
    if (declineBtn) {
        declineBtn.addEventListener('click', function () {
            setCookie('kp_cookie_consent', 'declined', 365);
            window.location.href = 'https://www.google.com/search?q=why+do+I+need+cookies';
        });
    }

    // Learn more modal
    if (learnMoreBtn && modal) {
        learnMoreBtn.addEventListener('click', function (e) {
            e.preventDefault();
            modal.classList.remove('hidden');
            loadCookiePolicy();
        });
    }

    // Close modal
    if (modalClose && modal) {
        modalClose.addEventListener('click', function () {
            modal.classList.add('hidden');
        });
    }

    // Close modal on overlay click
    if (modalOverlay && modal) {
        modalOverlay.addEventListener('click', function () {
            modal.classList.add('hidden');
        });
    }

});
