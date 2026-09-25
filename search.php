<?php
/** 
 * index.php
 * 
 * This is the main index template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// get the header
get_header( ); 
?>

<section <?php post_class( 'w-full pt-6 px-4 sm:px-8 md:px-16' ); ?>>
    <div class="w-full flex flex-col lg:flex-row gap-8">
        <div <?php post_class('w-full lg:w-2/3'); ?>>
            <h2 class="text-3xl md:text-4xl font-bold mb-4 kp-gradient-text"><?php echo get_post_type_object( get_post_type() ) -> labels -> singular_name; ?></h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <?php while ( have_posts( ) ): the_post( ); ?>
                    <?php get_template_part( 'partials/content/posts' ); ?>
                <?php endwhile; ?>
            </div>                
            <?php get_template_part( 'partials/navigation/paging', 'archives' ); ?>
        </div>
        <aside class="w-full lg:w-1/3">
            <?php get_template_part( 'partials/sidebar/articles' ); ?>
        </aside>
    </div>
</section>

<?php 

// get the footer
get_footer( );
