<?php

/** 
 * Performance class
 * 
 * This class is responsible for managing the performance of the theme
 * 
 * @since 8.4
 * @access public
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
 */

// We don't want to allow direct access to this
defined('ABSPATH') || die('No direct script access allowed');

// make sure this isn't already loaded in
if (! class_exists('KPT_Performance')) {

    /** 
     * KPT_Performance
     * 
     * This class is responsible for managing some 
     * performance options and settings of the site
     * they will only be applied when KPT_DEBUG either does not exist, or is false
     * 
     * @since 8.4
     * @access public
     * @author Kevin Pirnie <me@kpirnie.com>
     * @package Kevin Pirnie's Theme
     * 
     */
    class KPT_Performance
    {

        // hold the debug flag
        private bool $is_debug;

        // fire up the class
        public function __construct()
        {

            // set the debug flag
            $this->is_debug = (defined('KPT_DEBUG') && KPT_DEBUG) ? true : false;
        }

        /** 
         * manage_performance
         * 
         * Publicy manage the performance of the site's theme
         * 
         * @since 8.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
         */
        public function manage_performance(): void
        {

            // if we are not in debug mode
            if (! $this->is_debug) {

                // manage the scripts
                $this->manage_scripts();
            }

            // fire up the cleanup crew no matter what
            $this->cleanup_crew();

            // setup the image filters
            $this->image_filters();
        }

        /** 
         * image_filters
         * 
         * add in lazy loading and image dimensions
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
         */
        private function image_filters(): void
        {

            // Add native lazy loading to images
            add_filter('wp_get_attachment_image_attributes', function ($attr, $attachment, $size) {
                if (!is_admin()) {
                    $attr['loading'] = 'lazy';
                    $attr['decoding'] = 'async';

                    // Hero images get priority
                    if (in_array($size, ['hero', 'portfolio-featured', 'articlehead'])) {
                        $attr['fetchpriority'] = 'high';
                        $attr['loading'] = 'eager';
                    }
                }
                return $attr;
            }, 10, 3);

            // Add width/height to prevent layout shift
            add_filter('wp_get_attachment_image_attributes', function ($attr, $attachment) {
                if (!isset($attr['width']) || !isset($attr['height'])) {
                    $meta = wp_get_attachment_metadata($attachment->ID);
                    if (!empty($meta['width']) && !empty($meta['height'])) {
                        $attr['width'] = $meta['width'];
                        $attr['height'] = $meta['height'];
                    }
                }
                return $attr;
            }, 10, 2);
        }

        /** 
         * cleanup_crew
         * 
         * Cleans up unnecessary items
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
         */
        private function cleanup_crew(): void
        {

            // remove the emoji styles and scripts actions
            remove_action('wp_head', 'print_emoji_detection_script', 7);
            remove_action('admin_print_scripts', 'print_emoji_detection_script');
            remove_action('wp_print_styles', 'print_emoji_styles');
            remove_action('admin_print_styles', 'print_emoji_styles');
            remove_filter('the_content_feed', 'wp_staticize_emoji');
            remove_filter('comment_text_rss', 'wp_staticize_emoji');
            remove_filter('wp_mail', 'wp_staticize_emoji_for_email');

            // remove them from the tinymce plugins
            add_filter('tiny_mce_plugins', function ($_plugs): array {

                // make sure the plugins is an array
                if (is_array($_plugs)) {

                    // remove the wpemoji plugins from it and return
                    return array_diff($_plugs, array('wpemoji'));

                    // otherwise
                } else {

                    // return an empty array
                    return array();
                }
            });

            // check the resource hints for the emoji prefetch
            add_filter('wp_resource_hints', function ($_urls, $_rel_type): array {

                // if the relationship type is prefetch
                if ('dns-prefetch' == $_rel_type) {

                    // This filter is documented in wp-includes/formatting.php
                    $emoji_svg_url = apply_filters('emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/');

                    // remove it from the urls array
                    $_urls = array_diff($_urls, array($emoji_svg_url));
                }

                // return the urls array
                return $_urls;
            }, 10, 2);
        }

        /** 
         * manage_scripts
         * 
         * Manage the script locations and querystrings
         * 
         * @since 8.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
         */
        private function manage_scripts(): void
        {

            // remove these from the head
            remove_action('wp_head', 'wp_print_scripts');
            remove_action('wp_head', 'wp_print_head_scripts', 9);
            remove_action('wp_head', 'wp_enqueue_scripts', 1);

            // add them to the footer
            add_action('wp_footer', 'wp_print_scripts', 5);
            add_action('wp_footer', 'wp_enqueue_scripts', 5);
            add_action('wp_footer', 'wp_print_head_scripts', 5);

            // Since gravityforms seems to be very popular, let's make sure the scripts for it are loaded properly as well
            if (has_filter('gform_init_scripts_footer')) {

                // force gravity forms javascripts to the footer
                add_filter('gform_init_scripts_footer', '__return_true');
            }

            // hook into our script and style loaders
            add_filter('style_loader_src', 'kp_remove_ver', 1, PHP_INT_MAX);
            add_filter('script_loader_src', 'kp_remove_ver', 1, PHP_INT_MAX);

            // make sure the function does not currently exist
            if (! function_exists('kp_remove_ver')) {
                function kp_remove_ver($_src): string
                {

                    // remove the assigned versioning querystrings from the source
                    $_src = remove_query_arg(array('ver', 'version', 'v'), $_src);

                    // return the source		
                    return $_src;
                }
            }

            // Enqueue instant.page to load absolutely dead last
            add_action('wp_print_footer_scripts', function () {
?>
                <script src="//instant.page/5.2.0" type="module" defer></script>
<?php
            }, PHP_INT_MAX);
        }
    }
}
