<?php
/** 
 * navigation/footer.php
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>
<div class="flex space-x-4">
    <?php
    wp_nav_menu( array(
        'theme_location' => 'bottom',
        'container' => 'nav',
        'container_class' => 'flex items-center',
        'menu_class' => 'flex items-center space-x-2 whitespace-nowrap',
        'fallback_cb' => false,
        'depth' => 1,
        'walker' => new KPT_Top_Header_Nav_Walker( ),
    ) );
    ?>
</div>
