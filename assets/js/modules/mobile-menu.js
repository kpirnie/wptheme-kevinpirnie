DOMReady(function () {

    const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
    const mobileMenu = document.getElementById('mobile-menu');

    if (mobileMenuToggle && mobileMenu) {
        mobileMenuToggle.addEventListener('click', function () {
            mobileMenu.classList.toggle('hidden');

            if (!mobileMenu.classList.contains('hidden')) {
                document.querySelectorAll('.submenu-mobile').forEach(submenu => {
                    submenu.classList.add('hidden');
                });
                document.querySelectorAll('.submenu-toggle svg').forEach(arrow => {
                    arrow.classList.remove('rotate-180');
                });
            }
        });
    }

    // Event delegation for mobile submenu toggles
    document.addEventListener('click', function (e) {
        const toggle = e.target.closest('.submenu-toggle');

        if (toggle) {
            e.preventDefault();
            e.stopPropagation();

            const parentLi = toggle.closest('li');
            const submenu = parentLi.querySelector(':scope > .submenu-mobile');
            const arrow = toggle.querySelector('svg');

            if (submenu) {
                const isOpen = !submenu.classList.contains('hidden');

                const ancestors = [];
                let current = parentLi.parentElement;
                while (current) {
                    if (current.classList && current.classList.contains('submenu-mobile')) {
                        ancestors.push(current);
                    }
                    current = current.parentElement;
                }

                document.querySelectorAll('.submenu-mobile').forEach(menu => {
                    if (menu !== submenu && !ancestors.includes(menu)) {
                        menu.classList.add('hidden');
                    }
                });

                document.querySelectorAll('.submenu-toggle svg').forEach(otherArrow => {
                    const otherParentLi = otherArrow.closest('li');
                    const otherSubmenu = otherParentLi?.querySelector(':scope > .submenu-mobile');

                    if (otherArrow !== arrow && !ancestors.includes(otherSubmenu)) {
                        otherArrow.classList.remove('rotate-180');
                    }
                });

                submenu.classList.toggle('hidden');
                arrow.classList.toggle('rotate-180');
            }
        }
    });

    // Event delegation for mobile parent links
    document.addEventListener('click', function (e) {
        const link = e.target.closest('.mobile-menu-list .has-submenu > div > a');

        if (link) {
            e.preventDefault();

            const parentLi = link.closest('li');
            const submenu = parentLi.querySelector(':scope > .submenu-mobile');
            const arrow = link.closest('div').querySelector('.submenu-toggle svg');

            if (submenu) {
                const ancestors = [];
                let current = parentLi.parentElement;
                while (current) {
                    if (current.classList && current.classList.contains('submenu-mobile')) {
                        ancestors.push(current);
                    }
                    current = current.parentElement;
                }

                document.querySelectorAll('.submenu-mobile').forEach(menu => {
                    if (menu !== submenu && !ancestors.includes(menu)) {
                        menu.classList.add('hidden');
                    }
                });

                document.querySelectorAll('.submenu-toggle svg').forEach(otherArrow => {
                    const otherParentLi = otherArrow.closest('li');
                    const otherSubmenu = otherParentLi?.querySelector(':scope > .submenu-mobile');

                    if (otherArrow !== arrow && !ancestors.includes(otherSubmenu)) {
                        otherArrow.classList.remove('rotate-180');
                    }
                });

                submenu.classList.toggle('hidden');
                if (arrow) {
                    arrow.classList.toggle('rotate-180');
                }
            }
        }
    });

});