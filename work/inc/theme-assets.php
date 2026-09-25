<?php

/** 
 * Assets class
 * 
 * This class is responsible for properly pulling in our theme assets
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
if (! class_exists('KPT_Assets')) {

    /** 
     * KPT_Assets
     * 
     * This class is responsible for properly pulling in our theme assets
     * 
     * @since 8.4
     * @access public
     * @author Kevin Pirnie <me@kpirnie.com>
     * @package Kevin Pirnie's Theme
     * 
     */
    class KPT_Assets
    {

        /** 
         * enqueue
         * 
         * Setup the css and javascript enqueuers
         * 
         * @since 8.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
         */
        public function enqueue()
        {

            // only run on the frontend, not in wp-admin
            if (is_admin()) {
                return;
            }

            // remove jquery from front-end
            $this->remove_frontend_jquery();

            // enqueue our styles
            $this->pull_css();

            // enqueue our scripts
            $this->pull_js();

            // Remove WordPress block library CSS on resume page
            add_action('wp_enqueue_scripts', function () {
                // Check if we're on the resume page (adjust slug as needed)
                if (is_page('kevin-pirnie-devops-support-lead-wordpress-hosting')) {
                    // Dequeue block library styles
                    wp_dequeue_style('wp-block-library');
                    wp_dequeue_style('wp-block-library-theme');
                    wp_dequeue_style('wc-blocks-style');
                    wp_dequeue_style('global-styles');
                }
            }, 100);
        }

        /** 
         * pull_css
         * 
         * Properly enqueue the css for our theme
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
         */
        private function pull_css(): void
        {

            $is_debug = defined('KPT_DEBUG') && KPT_DEBUG;

            // Google Fonts
            wp_enqueue_style(
                'kpt_font',
                '//fonts.googleapis.com/css2?family=Source+Code+Pro:wght@300;400;500;600;700&display=swap',
                array(),
                null
            );

            // if we are debugging, load individual CSS modules
            if ($is_debug) {

                // Base Tailwind (processed)
                wp_enqueue_style(
                    'kpt_tw',
                    get_stylesheet_directory_uri() . '/assets/css/tw.css',
                    array('kpt_font'),
                    time()
                );

                // FontAwesome SVG Icons
                wp_enqueue_style(
                    'kpt_fa_icons',
                    get_stylesheet_directory_uri() . '/assets/css/fa-svg-icons.css',
                    array('kpt_tw'),
                    time()
                );

                // Individual CSS modules for debugging
                $css_modules = array(
                    'kpt_fontawesome' => 'modules/fontawesome.css',
                    'kpt_header' => 'modules/header.css',
                    'kpt_menu_base' => 'modules/menu-base.css',
                    'kpt_menu_main' => 'modules/menu-main.css',
                    'kpt_menu_mobile' => 'modules/menu-mobile.css',
                    'kpt_branding' => 'modules/branding.css',
                    'kpt_breadcrumbs' => 'modules/breadcrumbs.css',
                    'kpt_prose' => 'modules/prose.css',
                    'kpt_comp' => 'modules/components.css',
                    'kpt_pagination' => 'modules/pagination.css',
                    'kpt_logos' => 'modules/logos.css',
                    'kpt_heroes' => 'modules/heroes.css',
                    'kpt_cta' => 'modules/cta.css',
                    'kpt_blocks' => 'modules/blocks.css',
                    'kpt_utilities' => 'modules/utilities.css',
                    'kpt_portfolio' => 'modules/portfolio.css',
                );

                $last_dep = 'kpt_fa_icons';
                foreach ($css_modules as $handle => $file) {
                    wp_enqueue_style(
                        $handle,
                        get_stylesheet_directory_uri() . '/assets/css/' . $file,
                        array($last_dep),
                        time()
                    );
                    $last_dep = $handle;
                }
            } else {
                // Production: single minified file
                wp_enqueue_style(
                    'kpt_theme',
                    get_stylesheet_directory_uri() . '/assets/css/theme.min.css',
                    array('kpt_font'),
                    null
                );
            }

            // Custom CSS - style.css (always load last)
            wp_enqueue_style(
                'kpt_custom',
                get_stylesheet_uri(),
                $is_debug ? array('kpt_utilities') : array('kpt_theme'),
                $is_debug ? time() : null
            );
        }

        /** 
         * pull_js
         * 
         * Properly enqueue the javascript for our theme
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
         */
        private function pull_js(): void
        {

            $is_debug = defined('KPT_DEBUG') && KPT_DEBUG;

            // if we are debugging
            if ($is_debug) {

                // hold the debug scripts in dependency order
                $js = array(
                    'kpt_main' => array(
                        'url' => get_stylesheet_directory_uri() . '/assets/js/modules/main.js',
                        'deps' => array()
                    ),
                    'kpt_cookie' => array(
                        'url' => get_stylesheet_directory_uri() . '/assets/js/modules/cookie-notice.js',
                        'deps' => array('kpt_main')
                    ),
                    'kpt_hero' => array(
                        'url' => get_stylesheet_directory_uri() . '/assets/js/modules/hero-carousel.js',
                        'deps' => array('kpt_main')
                    ),
                    'kpt_menu_main' => array(
                        'url' => get_stylesheet_directory_uri() . '/assets/js/modules/main-menu.js',
                        'deps' => array('kpt_main')
                    ),
                    'kpt_menu_mobile' => array(
                        'url' => get_stylesheet_directory_uri() . '/assets/js/modules/mobile-menu.js',
                        'deps' => array('kpt_main')
                    ),
                    'kpt_scroll' => array(
                        'url' => get_stylesheet_directory_uri() . '/assets/js/modules/scroll-to-top.js',
                        'deps' => array('kpt_main')
                    ),
                    'kpt_search' => array(
                        'url' => get_stylesheet_directory_uri() . '/assets/js/modules/search.js',
                        'deps' => array('kpt_main')
                    ),
                    'kpt_header' => array(
                        'url' => get_stylesheet_directory_uri() . '/assets/js/modules/top-header.js',
                        'deps' => array('kpt_main')
                    ),
                    'kpt_portfolio_lazy' => array(
                        'url' => get_stylesheet_directory_uri() . '/assets/js/modules/portfolio-lazy.js',
                        'deps' => array('kpt_main'),
                    ),
                );

                // loop the js array
                foreach ($js as $k => $v) {

                    // enqueue the script
                    wp_enqueue_script(
                        $k,
                        $v['url'],
                        $v['deps'],
                        time(),
                        ['in_footer' => true, 'strategy' => 'defer']
                    );
                }

                // clean up the js array
                unset($js);

                // otherwise (production mode)
            } else {

                // enqueue the minified script
                wp_enqueue_script(
                    'kpt_theme',
                    get_stylesheet_directory_uri() . '/assets/js/theme.min.js',
                    array(),
                    null,
                    ['in_footer' => true, 'strategy' => 'defer']
                );
            }

            // always enqueue this one with a querystring
            wp_enqueue_script(
                'kpt_custom',
                get_stylesheet_directory_uri() . '/script.js',
                array(),
                time(),
                ['in_footer' => true, 'strategy' => 'defer']
            );
        }


        /** 
         * remove_frontend_jquery
         * 
         * Properly remove jquery from the front-end of the site
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
         */
        private function remove_frontend_jquery(): void
        {

            // make sure we only do this in the front-end, and only on pages that are not our form
            if (! is_admin()) {

                // remove it
                add_action('wp_enqueue_scripts', function () {

                    // check for the contact me page
                    if (! is_page(83)) {

                        // setup an array of items to be removed
                        $_remove = array('jquery', 'wp-embed');

                        // loop over this array and properly remove them
                        foreach ($_remove as $_hndl) {

                            // dequeue it first
                            wp_dequeue_script($_hndl);

                            // now unregister it
                            wp_deregister_script($_hndl);
                        }

                        // do the same for unnecessary CSS
                        $_remove = array('wp-block-library', 'classic-themes-styles', 'global-styles');

                        // loop over this array and properly remove them
                        foreach ($_remove as $_hndl) {

                            // dequeue it first
                            wp_dequeue_style($_hndl);

                            // now unregister it
                            wp_deregister_style($_hndl);
                        }
                    }
                }, PHP_INT_MAX - 1);
            }
        }
    }
}
