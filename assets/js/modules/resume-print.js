// DOM ready event
DOMReady(function () {

    // ========================================
    // Resume Print Functionality
    // ========================================

    // Try multiple selectors to find the print button
    const printButton = document.querySelector('#print-resume') ||
        document.querySelector('.print-resume') ||
        document.querySelector('a[href="#print"]') ||
        document.querySelector('a[href*="print-resume"]');

    // Only run if we find a print button
    if (!printButton) {
        return;
    }

    // Simple print on click
    printButton.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        window.print();
    });

});