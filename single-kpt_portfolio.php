<?php
/** 
 * single-kpt_portfolio.php
 * 
 * Single portfolio item template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

get_header( ); 

the_post( );

?>

<section <?php post_class( 'w-full pt-6 px-4 sm:px-8 md:px-16' ); ?>>

    <?php get_template_part( 'partials/navigation/breadcrumbs' ); ?>
    
    <div class="w-full flex flex-col lg:flex-row gap-8">
        <article class="w-full lg:w-2/3">
            <?php get_template_part( 'partials/content/post' ); ?>    
        </article>
        <aside class="w-full lg:w-1/3">
            <?php get_template_part( 'partials/sidebar/portfolio' ); ?>
        </aside>

    </div>

</section>

<?php 

get_footer( );