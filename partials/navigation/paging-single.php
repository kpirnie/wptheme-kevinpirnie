<?php
/** 
 * navigation/paging-single.php
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>

<div class="border-t border-b border-gray-700 py-6 mb-8">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <?php
            $prev_post = get_previous_post();
            if ($prev_post): ?>
                <a href="<?php echo get_permalink($prev_post); ?>" class="flex items-start text-[#599bb8] hover:text-blue-700 transition-colors">
                    <svg class="w-5 h-5 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                    <span class="text-sm"><?php echo esc_html( $prev_post->post_title ); ?></span>
                </a>
            <?php endif; ?>
        </div>
        <div class="md:text-right">
            <?php
            $next_post = get_next_post();
            if ($next_post): ?>
                <a href="<?php echo get_permalink($next_post); ?>" class="flex items-start md:justify-end text-[#599bb8] hover:text-blue-700 transition-colors">
                    <span class="text-sm md:order-1"><?php echo esc_html( $next_post->post_title ); ?></span>
                    <svg class="w-5 h-5 ml-2 flex-shrink-0 mt-0.5 md:order-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                    </svg>
                </a>
            <?php endif; ?>
        </div>
    </div>
</div>
