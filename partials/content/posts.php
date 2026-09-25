<?php
/** 
 * partials/content/posts.php
 * 
 * Reusable post card template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>

<article id="post-<?php the_ID(); ?>" <?php post_class('bg-white dark:bg-gray-800 rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 flex flex-col'); ?>>
    <?php if (has_post_thumbnail()): ?>
        <a href="<?php the_permalink(); ?>" class="block">
            <?php the_post_thumbnail('articlelist', array('class' => 'w-full h-48 object-cover')); ?>
        </a>
    <?php else: ?>
        <a href="<?php the_permalink(); ?>" class="block bg-gradient-to-br bg-kp-gradient h-48 flex items-center justify-center">
            <svg class="w-16 h-16 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </a>
    <?php endif; ?>
    
    <div class="p-6 flex-1 flex flex-col">
        <h2 class="text-xl font-bold mb-2">
            <a href="<?php the_permalink(); ?>" class="text-gray-900 dark:text-gray-100 hover:text-[#599bb8] dark:hover:text-blue-400 transition-colors">
                <?php the_title(); ?>
            </a>
        </h2>
        
        <?php if( 'kpt_portfolio' !== get_post_type( ) ): ?>
        <div class="text-sm text-gray-500 dark:text-gray-400 mb-3 text-right">
            <span class="inline-flex items-center">
                <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"/>
                </svg>
                <?php echo get_the_date(); ?>
            </span>
        </div>
        <?php endif; ?>
        
        <div class="text-gray-600 dark:text-gray-300 mb-4 flex-1">
            <?php the_excerpt(); ?>
        </div>
        
        <a href="<?php the_permalink(); ?>" class="inline-flex items-center text-[#599bb8] dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 font-medium mb-4">
            Read More
            <span class="fa-solid fa-chevron-right ml-1 text-xs transition-transform"></span>
        </a>
    </div>
    
</article>