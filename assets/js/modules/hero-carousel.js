DOMReady(function () {

    const slideshow = document.querySelector('.kpt-hero-slideshow');

    if (slideshow) {
        const slides = slideshow.querySelectorAll('.kpt-hero-slide');
        const prevBtn = slideshow.querySelector('.kpt-hero-prev');
        const nextBtn = slideshow.querySelector('.kpt-hero-next');

        let currentSlide = 0;
        let autoplayInterval;
        let isVisible = false;

        // Intersection Observer for lazy loading
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting && !isVisible) {
                    isVisible = true;
                    loadSlideBackground(slides[currentSlide]);
                    startAutoplay();
                }
            });
        }, { threshold: 0.1 });

        observer.observe(slideshow);

        function loadSlideBackground(slide) {
            const bgUrl = slide.getAttribute('data-bg');
            if (bgUrl && !slide.style.backgroundImage) {
                slide.style.backgroundImage = `url('${bgUrl}')`;
            }
        }

        function goToSlide(n) {
            slides.forEach(slide => {
                slide.classList.remove('active', 'prev');
            });

            slides[currentSlide].classList.add('prev');
            currentSlide = (n + slides.length) % slides.length;

            loadSlideBackground(slides[currentSlide]);
            slides[currentSlide].classList.add('active');
        }

        function nextSlide() {
            goToSlide(currentSlide + 1);
        }

        function prevSlide() {
            goToSlide(currentSlide - 1);
        }

        prevBtn.addEventListener('click', prevSlide);
        nextBtn.addEventListener('click', nextSlide);

        function startAutoplay() {
            autoplayInterval = setInterval(nextSlide, 7000);
        }

        function stopAutoplay() {
            clearInterval(autoplayInterval);
        }

        slideshow.addEventListener('mouseenter', stopAutoplay);
        slideshow.addEventListener('mouseleave', () => {
            if (isVisible) startAutoplay();
        });

        document.addEventListener('keydown', function (e) {
            if (e.key === 'ArrowLeft') prevSlide();
            if (e.key === 'ArrowRight') nextSlide();
        });
    }

});