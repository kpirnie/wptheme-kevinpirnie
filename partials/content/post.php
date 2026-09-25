<?php
/** 
 * partials/content/post.php
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );
if( 'kpt_portfolio' === get_post_type( ) ):
    $settings = get_post_meta( $post -> ID, 'portfolio_url', true );
    $link_data = isset( $settings ) ? $settings : array();
    // var_dump($settings);array(3) { ["url"]=> string(23) "https://ihoptimize.org/" ["title"]=> string(0) "" ["target"]=> string(6) "_blank" }
endif;
?>

<?php if ( has_post_thumbnail() ) : ?>
    <div class="relative mb-8 rounded-lg overflow-hidden h-96 md:h-[500px]">
        <?php the_post_thumbnail( 'full', array( 'class' => 'w-full h-full object-cover' ) ); ?>
        
        <div class="absolute inset-0 kpt-portfolio-item-overlay"></div>
        
        <div class="absolute bottom-0 left-0 right-0 p-6 md:p-8">
            <h1 class="text-3xl md:text-4xl font-bold mb-4 kp-gradient-text">
                <?php the_title(); ?>
            </h1>
            
            <?php if ( has_excerpt() ) : ?>
                <div class="text-lg md:text-xl text-gray-200">
                    <?php the_excerpt(); ?>
                </div>
            <?php endif; ?>
        </div>

    </div>
<?php else : ?>
    <header class="mb-8">
        <h1 class="text-3xl md:text-4xl font-bold mb-4 kp-gradient-text">
            <?php the_title(); ?>
        </h1>
        
        <?php if ( has_excerpt() ) : ?>
            <div class="text-xl text-gray-400 mb-6">
                <?php the_excerpt(); ?>
            </div>
        <?php endif; ?>
    </header>
<?php endif; ?>

<?php if( 'post' === get_post_type( ) ): ?>
    <div class="mb-6">                    
        <div class="flex flex-wrap items-center justify-end gap-4 text-sm text-gray-400">
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
                <?php echo get_the_date(); ?>
            </span>
            <span class="flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd"/>
                </svg>
                <?php the_author(); ?>
            </span>
        </div>
    </div>
<?php endif; ?>

<div class="article-content prose prose-lg mb-8">
    <?php the_content(); ?>
</div>

<?php if( 'post' === get_post_type( ) ): ?>
    <?php
    $categories = get_the_category();
    if ($categories):
    ?>
    <div class="border-t border-gray-700 pt-6 mb-8">
        <div class="flex flex-wrap gap-2 items-center">
            <span class="text-sm font-semibold text-gray-300">Categories:</span>
            <?php
            foreach ($categories as $category) {
                echo '<a href="' . get_category_link($category->term_id) . '" class="text-xs px-3 py-1 bg-gray-700 text-gray-300 rounded-full hover:bg-gray-600 transition-colors">' . esc_html($category->name) . '</a>';
            }
            ?>
        </div>
    </div>
    <?php endif; ?>
    
    <?php if (has_tag()): ?>
        <div class="border-t border-gray-700 pt-6 mb-8">
            <div class="flex flex-wrap gap-2 items-center">
                <span class="text-sm font-semibold text-gray-300">Tags:</span>
                <?php
                $tags = get_the_tags();
                if ($tags) {
                    foreach ($tags as $tag) {
                        echo '<a href="' . get_tag_link($tag->term_id) . '" class="text-xs px-3 py-1 bg-orange-900 text-orange-200 rounded-full hover:bg-orange-800 transition-colors">#' . esc_html($tag->name) . '</a>';
                    }
                }
                ?>
            </div>
        </div>
    <?php endif; ?>
    
<?php endif; ?>

<?php get_template_part( 'partials/navigation/paging', 'single' ); ?>
