DOMReady(function () {

    // Event delegation for all dropdown toggles
    document.addEventListener('click', function (e) {
        const toggle = e.target.closest('.dropdown-toggle');

        if (toggle) {
            e.preventDefault();
            e.stopPropagation();

            const parentLi = toggle.closest('li.has-dropdown');
            const submenu = parentLi.querySelector(':scope > .submenu');
            const arrow = toggle.querySelector('.fa-solid');

            if (submenu) {
                const isOpen = !submenu.classList.contains('hidden');

                // Get all ancestor submenus (parent chain)
                const ancestors = [];
                let current = parentLi.parentElement;
                while (current) {
                    if (current.classList && current.classList.contains('submenu')) {
                        ancestors.push(current);
                    }
                    current = current.parentElement;
                }

                // Close ALL dropdowns except ancestors and the current one
                document.querySelectorAll('.submenu').forEach(menu => {
                    if (menu !== submenu && !ancestors.includes(menu)) {
                        menu.classList.add('hidden');
                    }
                });

                // Reset ALL arrows except those in ancestor chain
                document.querySelectorAll('.dropdown-toggle .fa-solid').forEach(otherArrow => {
                    const otherParentLi = otherArrow.closest('li.has-dropdown');
                    const otherSubmenu = otherParentLi?.querySelector(':scope > .submenu');

                    if (otherArrow !== arrow && !ancestors.includes(otherSubmenu)) {
                        otherArrow.classList.remove('rotate-180');
                    }
                });

                // Toggle current dropdown
                submenu.classList.toggle('hidden');
                arrow.classList.toggle('rotate-180');
            }
        } else if (!e.target.closest('.submenu, .has-dropdown')) {
            // Close all dropdowns if clicking outside
            document.querySelectorAll('.submenu').forEach(menu => {
                menu.classList.add('hidden');
            });
            document.querySelectorAll('.dropdown-toggle .fa-solid').forEach(arrow => {
                arrow.classList.remove('rotate-180');
            });
        }
    });

});