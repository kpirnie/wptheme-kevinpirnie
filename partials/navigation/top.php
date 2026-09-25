<?php
/** 
 * navigation/top.php
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>

<div id="top-header" class="text-white transition-transform duration-300">

    <div class="w-full px-4 sm:px-8 md:px-16">

        <div class="flex justify-between items-center py-2 text-xs md:text-sm">
            <?php
            wp_nav_menu( array(
                'theme_location' => 'top',
                'container' => 'nav',
                'container_class' => 'flex items-center',
                'menu_class' => 'flex items-center space-x-4',
                'fallback_cb' => false,
                'depth' => 1,
                'walker' => new KPT_Top_Header_Nav_Walker( ),
            ) );
            ?>

            <?php
            wp_nav_menu( array(
                'theme_location' => 'social',
                'container' => 'nav',
                'container_class' => 'flex items-center',
                'menu_class' => 'flex items-center space-x-4',
                'fallback_cb' => false,
                'depth' => 1,
                'walker' => new KPT_Top_Header_Nav_Walker( ),
            ) );
            ?>

        </div>
    </div>

</div>
