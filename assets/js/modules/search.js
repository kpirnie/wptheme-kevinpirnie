// DOM ready event
DOMReady( function( ) {
    // ========================================
    // Search toggle - Desktop
    // ========================================
    const searchToggle = document.getElementById('search-toggle');
    const searchForm = document.getElementById('search-form');

    if (searchToggle && searchForm) {
        searchToggle.addEventListener('click', function () {
            searchForm.classList.toggle('hidden');
            if (!searchForm.classList.contains('hidden')) {
                searchForm.querySelector('input[type="search"]').focus();
            }
        });
    }

    // Search toggle - Mobile
    const searchToggleMobile = document.getElementById('search-toggle-mobile');
    if (searchToggleMobile && searchForm) {
        searchToggleMobile.addEventListener('click', function () {
            searchForm.classList.toggle('hidden');
            if (!searchForm.classList.contains('hidden')) {
                searchForm.querySelector('input[type="search"]').focus();
            }
        });
    }
} );
