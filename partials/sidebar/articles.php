<?php
/** 
 * partials/sidebar-articles.php
 * 
 * Contact form template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 */

defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>
<div class="lg:sticky lg:top-24">
                    
    <!-- Search Widget -->
    <div class="bg-gray-800 rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-100">Search</h3>
        <form role="search" method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
            <div class="flex gap-2">
                <input type="search" 
                    name="s" 
                    placeholder="Search..." 
                    class="flex-1 px-3 py-2 rounded-lg border border-gray-700 bg-gray-900 text-gray-100 focus:outline-none focus:ring-2 focus:ring-[#599bb8]"
                    value="<?php echo get_search_query(); ?>">
                <button type="submit" 
                        class="px-4 py-2 bg-gradient-to-r from-[#599bb8] to-[#2d7696] text-white rounded-lg transition-all hover:from-[#43819c] hover:to-[#2d7696]">
                    <span class="fa-solid fa-magnifying-glass"></span>
                </button>
            </div>
        </form>
    </div>
    
    <!-- Archives Widget -->
    <div class="bg-gray-800 rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-100">Article Archives</h3>
        <ul class="space-y-2 list-disc list-inside">
            <?php
            wp_get_archives(array(
                'type' => 'monthly',
                'limit' => 12,
                'format' => 'custom',
                'before' => '<li>',
                'after' => '</li>',
                'show_post_count' => true,
                'echo' => true
            ));
            ?>
        </ul>
    </div>
    
    <!-- Categories Widget -->
    <div class="bg-gray-800 rounded-lg shadow-md p-6 mb-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-100">Article Categories</h3>
        <div class="flex flex-wrap gap-2">
            <?php
            $categories = get_categories(array(
                'orderby' => 'name',
                'order' => 'ASC'
            ));
            foreach($categories as $category) {
                echo '<a href="' . get_category_link($category->term_id) . '" class="text-xs px-3 py-1 bg-gray-700 text-gray-300 rounded-full hover:bg-blue-900 hover:text-white transition-colors">' . $category->name . '</a>';
            }
            ?>
        </div>
    </div>
    
    <!-- Tags Cloud Widget -->
    <?php
    $tags = get_tags(array('orderby' => 'count', 'order' => 'DESC', 'number' => 10000));
    if ($tags):
    ?>
    <div class="bg-gray-800 rounded-lg shadow-md p-6">
        <h3 class="text-lg font-semibold mb-4 text-gray-100">Article Tags</h3>
        <div class="flex flex-wrap gap-2">
            <?php
            foreach($tags as $tag) {
                echo '<a href="' . get_tag_link($tag->term_id) . '" class="text-xs px-3 py-1 bg-gray-700 text-gray-300 rounded-full hover:bg-blue-900 hover:text-white transition-colors">' . $tag->name . '</a>';
            }
            ?>
        </div>
    </div>
    <?php endif; ?>
    
</div>