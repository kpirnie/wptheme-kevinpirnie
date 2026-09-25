<?php

/** 
 * partials/cpts/portfolio.php
 * 
 * Portfolio layout: 1 featured image (50% width) + 6 grid items (2x3)
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
 */

defined('ABSPATH') || die('No direct script access allowed');

$args = array(
    'post_type'      => 'kpt_portfolio',
    'posts_per_page' => 7,
    'post_status'    => 'publish',
    'orderby'        => 'rand',
);

// Fragment caching for portfolio
$cache_key = 'kpt_portfolio_' . md5(serialize($args ?? []));
$cached = get_transient($cache_key);

if (false !== $cached && !is_user_logged_in()) {
    echo $cached;
    return;
}

ob_start();

$portfolio_items = get_posts($args);

if (empty($portfolio_items) || count($portfolio_items) < 7) {
    return;
}

// Separate featured item from grid items
$featured_item = $portfolio_items[0];
$grid_items = array_slice($portfolio_items, 1, 6);

// Get featured item data
$featured_id = $featured_item->ID;
$featured_title = $featured_item->post_title;
$featured_excerpt = $featured_item->post_excerpt;
$featured_content = $featured_item->post_content;
$featured_image = get_the_post_thumbnail_url($featured_id, get_query_var('portfolio_image_size', 'portfolio-featured'));
$featured_url = get_permalink($featured_id);
?>

<div class="kpt-portfolio-featured w-full my-8 bg-gray-800 rounded-md shadow-md p-4 border-2 border-kp-navy">

    <div class="flex flex-col md:flex-row gap-4 items-stretch">

        <!-- Featured Item (50% width) -->
        <!-- Height: 3 rows × 242px + 2 gaps × 16px = 758px -->
        <div class="w-full md:w-1/2 h-[758px]">
            <a href="<?php echo esc_url($featured_url); ?>" class="kpt-portfolio-item kpt-portfolio-featured-item relative overflow-hidden rounded-md group block h-[400px] md:h-[758px] border-2 border-kp-gray">

                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 ease-out group-hover:scale-105 kpt-lazy-bg"
                    data-bg="<?php echo esc_url($featured_image); ?>">
                </div>

                <div class="absolute inset-0 kpt-portfolio-item-overlay"></div>

                <div class="absolute bottom-0 left-0 right-0 p-6 transition-all duration-700 ease-out">

                    <?php if ($featured_title) : ?>
                        <h3 class="text-white font-bold text-xl md:text-2xl mb-3"><?php echo esc_html($featured_title); ?></h3>
                    <?php endif; ?>

                    <?php if ($featured_excerpt) : ?>
                        <p class="text-gray-300 text-sm md:text-base mb-4 line-clamp-2"><?php echo esc_html($featured_excerpt); ?></p>
                    <?php elseif ($featured_content) : ?>
                        <p class="text-gray-300 text-sm md:text-base mb-4 line-clamp-2"><?php echo wp_trim_words(wp_strip_all_tags($featured_content), 20); ?></p>
                    <?php endif; ?>

                    <span class="inline-flex items-center text-[#599bb8] hover:text-[#43819c] text-sm font-medium transition-colors duration-300 group/link">
                        <span>View Project</span>
                        <span class="fa-solid fa-arrow-right ml-2 transition-transform duration-300 group-hover/link:translate-x-1"></span>
                    </span>

                </div>

            </a>
        </div>

        <!-- Grid Items (50% width, 2x3 grid) -->
        <div class="w-full md:w-1/2 grid grid-cols-2 gap-4 h-full">

            <?php foreach ($grid_items as $item) :
                $item_id = $item->ID;
                $title = $item->post_title;
                $excerpt = $item->post_excerpt;
                $content = $item->post_content;
                $image = get_the_post_thumbnail_url($item_id, get_query_var('portfolio_image_size', 'portfolio-grid'));
                $url = get_permalink($item_id);
            ?>
                <a href="<?php echo esc_url($url); ?>" class="kpt-portfolio-item kpt-portfolio-grid-item relative overflow-hidden rounded-md group block h-[190px] md:h-[242px] border-2 border-kp-darkest-blue">

                    <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 ease-out group-hover:scale-105 kpt-lazy-bg"
                        data-bg="<?php echo esc_url($image); ?>">
                    </div>

                    <div class="absolute inset-0 kpt-portfolio-small-item-overlay"></div>

                    <div class="absolute bottom-0 left-0 right-0 p-3 md:p-4 transition-all duration-700 ease-out">

                        <?php if ($title) : ?>
                            <h4 class="text-white font-bold text-sm md:text-base mb-1 line-clamp-1"><?php echo esc_html($title); ?></h4>
                        <?php endif; ?>

                        <?php if ($excerpt) : ?>
                            <p class="text-gray-300 text-xs mb-2 line-clamp-1 hidden md:block"><?php echo wp_trim_words(esc_html($excerpt), 8); ?></p>
                        <?php elseif ($content) : ?>
                            <p class="text-gray-300 text-xs mb-2 line-clamp-1 hidden md:block"><?php echo wp_trim_words(wp_strip_all_tags($content), 8); ?></p>
                        <?php endif; ?>

                        <span class="inline-flex items-center text-[#599bb8] text-xs font-medium transition-colors duration-300 group/link">
                            <span>View</span>
                            <span class="fa-solid fa-arrow-right ml-1 transition-transform duration-300 group-hover/link:translate-x-1"></span>
                        </span>

                    </div>

                </a>
            <?php endforeach; ?>

        </div>

    </div>

</div>

<?php
$output = ob_get_clean();
set_transient($cache_key, $output, 6 * HOUR_IN_SECONDS);
echo $output;
