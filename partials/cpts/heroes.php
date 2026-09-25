<?php

/** 
 * partials/cpts/heroes.php
 * 
 * This is the heroes template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
 */

// We don't want to allow direct access to this
defined('ABSPATH') || die('No direct script access allowed');

// hold the ID
$id = get_the_ID();
// Fragment caching for heroes
$cache_key = 'kpt_heroes_' . $id;
$cached = get_transient($cache_key);

if (false !== $cached && !is_user_logged_in()) {
    echo $cached;
    return;
}

ob_start();

// Get the hero assignments from the PAGE meta
$hero_settings = get_post_meta($id, 'page_assignment', true);

// Extract the assigned hero IDs
$assigned_hero_ids = ! empty($hero_settings) ? $hero_settings : array();

// If no heroes assigned, show featured image with page title or just page title
if (empty($assigned_hero_ids)) {
    if (has_post_thumbnail()) : ?>
        <!-- Fallback to Featured Image as Hero -->
        <div class="kpt-hero-single w-full relative h-[200px] md:h-[250px] bg-cover bg-center" style="background-image: url('<?php echo esc_url(get_the_post_thumbnail_url($id, 'hero')); ?>');">
            <div class="kpt-hero-content position-left kpt-hero-content-single">
                <h1 class="text-4xl md:text-5xl font-bold mb-4 kp-gradient-text">
                    <?php echo esc_html(get_the_title()); ?>
                </h1>
            </div>
        </div>
    <?php else : ?>
        <!-- No image, just show title in header area -->
        <div class="w-full pt-6 px-4 sm:px-8 md:px-16">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 kp-gradient-text">
                <?php echo esc_html(get_the_title()); ?>
            </h1>
        </div>
<?php endif;
    return;
}

// Get the assigned heroes
$args = array(
    'post_type'      => 'kpt_hero',
    'post__in'       => $assigned_hero_ids,
    'orderby'        => 'rand', // random order is fine
    'posts_per_page' => -1,
    'post_status'    => 'publish',
);

// get the posts
$heroes = get_posts($args);

?>

<?php if (! empty($heroes)) : ?>

    <?php if (count($heroes) > 1) : ?>

        <!-- Multiple Heroes - Slideshow -->
        <div class="kpt-hero-slideshow w-full relative h-[200px] md:h-[250px]">
            <?php foreach ($heroes as $index => $hero) :

                $hero_id = $hero->ID;
                $hero_title = $hero->post_title;
                $hero_content = $hero->post_content;
                $hero_image = get_the_post_thumbnail_url($hero_id, 'hero');

                // Randomly assign left or right position
                $position = (rand(0, 1) === 0) ? 'position-left' : 'position-right';
            ?>
                <div class="kpt-hero-slide <?php echo $index === 0 ? 'active' : ''; ?> w-full h-full bg-cover bg-center" <?php echo $index === 0 ? 'style="background-image: url(\'' . esc_url($hero_image) . '\');"' : 'data-bg="' . esc_url($hero_image) . '"'; ?>>
                    <div class="kpt-hero-content <?php echo esc_attr($position); ?>">
                        <?php if ($hero_title) : ?>
                            <h2 class="kpt-hero-title"><?php echo esc_html($hero_title); ?></h2>
                        <?php endif; ?>
                        <?php if ($hero_content) : ?>
                            <div class="kpt-hero-text"><?php echo wp_kses_post($hero_content); ?></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>

            <!-- Slideshow Controls -->
            <button class="kpt-hero-prev" aria-label="Previous slide">&lsaquo;</button>
            <button class="kpt-hero-next" aria-label="Next slide">&rsaquo;</button>
        </div>

        <div class="w-full pt-6 px-4 sm:px-8 md:px-16">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 kp-gradient-text">
                <?php echo esc_html(get_the_title()); ?>
            </h1>
        </div>

    <?php else : ?>

        <!-- Single Hero -->
        <?php
        $hero = $heroes[0];
        $hero_id = $hero->ID;
        $hero_title = $hero->post_title;
        $hero_content = $hero->post_content;
        $hero_image = get_the_post_thumbnail_url($hero_id, 'hero');

        // Random position for single hero
        $position = (rand(0, 1) === 0) ? 'position-left' : 'position-right';
        ?>
        <div class="kpt-hero-single w-full relative h-[200px] md:h-[250px] bg-cover bg-center" style="background-image: url('<?php echo esc_url($hero_image); ?>');">
            <div class="kpt-hero-content <?php echo esc_attr($position); ?>">
                <?php if ($hero_title) : ?>
                    <h2 class="kpt-hero-title"><?php echo esc_html($hero_title); ?></h2>
                <?php endif; ?>
                <?php if ($hero_content) : ?>
                    <div class="kpt-hero-text"><?php echo wp_kses_post($hero_content); ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="w-full pt-6 px-4 sm:px-8 md:px-16">
            <h1 class="text-4xl md:text-5xl font-bold mb-4 kp-gradient-text">
                <?php echo esc_html(get_the_title()); ?>
            </h1>
        </div>

    <?php endif; ?>

<?php endif; ?>

<?php
$output = ob_get_clean();
set_transient($cache_key, $output, 12 * HOUR_IN_SECONDS);
echo $output;
