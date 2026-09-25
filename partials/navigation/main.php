<?php

/** 
 * navigation/main.php
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
 */

// We don't want to allow direct access to this
defined('ABSPATH') || die('No direct script access allowed');

?>
<header id="main-header" class="sticky top-0 z-50 bg-gray-900/95 backdrop-blur-xs shadow-md shadow-gray-950 transition-all duration-300">

    <div class="w-full px-4 sm:px-8 md:px-16">
        <div class="flex justify-between items-center py-4">

            <div class="flex items-center">
                <a href="<?php echo home_url('/'); ?>" class="header-logo">
                    <?php
                    // get the SVG content for my logo
                    echo file_get_contents(ABSPATH . '/wp-content/uploads/2025/10/kevinpirnie-logo-color.svg');
                    ?>
                </a>
            </div>

            <nav class="hidden lg:flex items-center space-x-6">
                <?php
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container' => false,
                    'menu_class' => 'flex space-x-6 items-center',
                    'fallback_cb' => false,
                    'depth' => 5,
                    'walker' => new KPT_Main_Nav_Walker(),
                ));
                ?>
                <button id="search-toggle" class="p-2 rounded-lg hover:bg-gray-800 transition-colors" aria-label="Toggle search">
                    <span class="fa-solid fa-magnifying-glass"></span>
                </button>
            </nav>

            <div class="flex items-center space-x-4 lg:hidden">
                <button id="search-toggle-mobile" class="p-2 rounded-lg hover:bg-gray-800 transition-colors" aria-label="Toggle search">
                    <span class="fa-solid fa-magnifying-glass"></span>
                </button>

                <button id="mobile-menu-toggle" class="p-2 rounded-lg hover:bg-gray-800 transition-colors" aria-label="Toggle menu">
                    <span class="fa-solid fa-ellipsis-vertical"></span>
                </button>
            </div>

        </div>
    </div>

    <div id="search-form" class="hidden border-t border-gray-700">
        <div class="w-full px-4 sm:px-8 md:px-16 py-4">
            <form role="search" method="get" action="<?php echo home_url('/'); ?>" class="flex gap-2">
                <input type="search" name="s" placeholder="Search..." class="flex-1 px-3 md:px-4 py-2 rounded-lg border border-gray-700 bg-gray-800 focus:outline-hidden focus:ring-2 focus:ring-[#599bb8] text-sm md:text-base" value="<?php echo get_search_query(); ?>">
                <button type="submit" class="p-2 md:p-3 text-white rounded-lg transition-all kp-gradient-bg" aria-label="Search">
                    <span class="fa-solid fa-magnifying-glass"></span>
                </button>
            </form>
        </div>
    </div>

    <nav id="mobile-menu" class="hidden lg:hidden border-t border-gray-700">
        <div class="w-full px-4 sm:px-8 md:px-16 py-4">
            <?php
            wp_nav_menu(array(
                'theme_location' => 'primary',
                'container' => false,
                'menu_class' => 'mobile-menu-list',
                'fallback_cb' => false,
                'walker' => new KPT_Mobile_Nav_Walker(),
            ));
            ?>
        </div>
    </nav>

</header>