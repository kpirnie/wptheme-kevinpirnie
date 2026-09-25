<?php
/** 
 * Theme Supports Class
 * 
 * This file manages the theme supports and 
 * removal of items that are not necessary for the functionality
 * we need
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

if( ! class_exists( 'KPT_Supports' ) ) {

    /** 
     * Class KPT_Supports
     * 
     * The primary theme class
     * 
     * @since 8.4
     * @access public
     * @author Kevin Pirnie <me@kpirnie.com>
     * @package Kevin Pirnie's Theme
     * 
    */
    class KPT_Supports {

        /** 
         * the_theme_supports
         * 
         * What's the theme actually support
         * 
         * @since 8.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        public function the_theme_supports( ) : void {

            // pull in the private stuff
            $this -> theme_supports( );
            $this -> theme_cleanup( );

            // toss in menus we want
            register_nav_menus( array(
                'primary' => __( 'Primary Menu', 'kpt' ),
                'top' => __( 'Top Header Menu', 'kpt' ),
                'social' => __( 'Social Menu', 'kpt' ),
                'bottom' => __( 'Footer Bottom Menu', 'kpt' ),
            ) );

            // modify our excerpt length
            add_filter( 'excerpt_length', function( $length ) : int {
                return 20;
            } );

        }

        /** 
         * theme_supports
         * 
         * What's the theme support
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function theme_supports( ) : void {

            // toss in our supports
            add_theme_support( 'title-tag' );
            add_theme_support( 'post-thumbnails' );
            add_theme_support( 'html5', array( 'search-form', 'gallery', 'caption', 'script', 'style' ) );
            add_theme_support( 'custom-logo' );
            add_theme_support( 'responsive-embeds' );
            add_theme_support( 'align-wide' );
            add_theme_support( 'align-full' );
            add_theme_support( 'custom-units', 'px', 'em', 'rem', 'vh', 'vw' );
            add_theme_support( 'appearance-tools' );
            add_theme_support( 'border' );

            // allow SVG's to be uploaded
            add_filter( 'upload_mimes', function( $mimes ) {
                $mimes['svg'] = 'image/svg+xml';
                $mimes['svgz'] = 'image/svg+xml';
                return $mimes;
            } );

            // add in more image sizes to select from
            add_image_size( 'hero', 1920, 350, array( 'center', 'center' ) );
            add_image_size( 'articlehead', 963, 385, array( 'center', 'center' ) );
            add_image_size( 'articlelist', 520, 193, array( 'center', 'center' ) );
            add_image_size( 'innerpage', 482, 397, array( 'center', 'center' ) );
            add_image_size( 'portfolio-featured', 800, 850, array( 'center', 'center' ) );
            add_image_size( 'portfolio-grid', 400, 275, array( 'center', 'center' ) );

            // Make custom image sizes selectable in editor
            add_filter( 'image_size_names_choose', function( $sizes ) {
                return array_merge( $sizes, array(
                    'hero' => __( 'Hero (1920x350)' ),
                    'portfolio-featured' => __( 'Portfolio Featured (800x850)' ),
                    'portfolio-grid' => __( 'Portfolio Grid (400x275)' ),
                    'articlehead' => __( 'Article Head (963x385)' ),
                    'articlelist' => __( 'Article List (520x193)' ),
                    'innerpage' => __( 'Inner Page (482x397)' ),
                ) );
            } );

        }

        /** 
         * theme_cleanup
         * 
         * Cleanup items from the theme that we do not want 
         * or are not necessary
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function theme_cleanup( ) : void {

            // remove some supports
            remove_theme_support( 'core-block-patterns' );
    
            // remove the admin bar from the front-end of the site
            add_filter( 'show_admin_bar', '__return_false' );

            // remove the really simple discover link
            remove_action( 'wp_head', 'rsd_link' );
            
            // remove the Windows Live Writer manifest file link
            remove_action( 'wp_head', 'wlwmanifest_link' );
            
            // remove the generator meta tag
            remove_action( 'wp_head', 'wp_generator', 10, 0 );

            // remove comment functionality
            $this -> remove_commenting( );

            // remove the xml rpc functionality
            $this -> remove_xml_rpc( );

            // remove the rest
            $this -> remove_rest( );

        }

        /** 
         * remove_commenting
         * 
         * The method is responsible for turning off commenting
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
         * @return void This method does not return anything
         * 
        */
        private function remove_commenting( ) : void {

            // Close comments on the front-end
            add_filter('comments_open', '__return_false', 20, 2);
            add_filter('pings_open', '__return_false', 20, 2);
            
            // Hide existing comments
            add_filter('comments_array', '__return_empty_array', 10, 2);
            
            // Remove comments page in menu
            add_action('admin_menu', function() {
                remove_menu_page('edit-comments.php');
            });
            
            // Redirect any user trying to access comments page
            add_action('admin_init', function() {
                global $pagenow;
                if ($pagenow === 'edit-comments.php') {
                    wp_redirect(admin_url());
                    exit;
                }
            });
            
            // Remove comments metabox from dashboard
            add_action('admin_init', function() {
                remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');
            });
            
            // Disable support for comments and trackbacks in post types
            add_action('admin_init', function() {
                $post_types = get_post_types();
                foreach ($post_types as $post_type) {
                    if (post_type_supports($post_type, 'comments')) {
                        remove_post_type_support($post_type, 'comments');
                        remove_post_type_support($post_type, 'trackbacks');
                    }
                }
            });
            
            // Close comments on the front-end for existing posts
            add_filter('comments_open', '__return_false', 20, 2);
            add_filter('pings_open', '__return_false', 20, 2);
            
            // Remove comments from admin bar
            add_action('init', function() {
                if (is_admin_bar_showing()) {
                    remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
                }
            });
            
            // Remove comment-reply script from front-end
            add_action('wp_enqueue_scripts', function() {
                wp_dequeue_script('comment-reply');
            }, 100);
            
            // Remove comments REST API endpoints
            add_filter('rest_endpoints', function($endpoints) {
                if (isset($endpoints['/wp/v2/comments'])) {
                    unset($endpoints['/wp/v2/comments']);
                }
                if (isset($endpoints['/wp/v2/comments/(?P<id>[\d]+)'])) {
                    unset($endpoints['/wp/v2/comments/(?P<id>[\d]+)']);
                }
                return $endpoints;
            });
            
            // Remove comments links from admin bar
            add_action('add_admin_bar_menus', function() {
                remove_action('admin_bar_menu', 'wp_admin_bar_comments_menu', 60);
            });
            
            // Hide comments column in posts/pages list
            add_filter('manage_posts_columns', function($columns) {
                unset($columns['comments']);
                return $columns;
            });
            
            add_filter('manage_pages_columns', function($columns) {
                unset($columns['comments']);
                return $columns;
            });
            
        }

        /** 
         * remove_xml_rpc
         * 
         * The method is responsible for turning the xml rpc
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
         * @return void This method does not return anything
         * 
        */
        private function remove_xml_rpc( ) : void {

            // Disable XML-RPC
            add_filter('xmlrpc_enabled', '__return_false');
            
            // Disable X-Pingback HTTP header
            add_filter('wp_headers', function($headers) {
                unset($headers['X-Pingback']);
                return $headers;
            });
            
            // Remove RSD link from head
            remove_action('wp_head', 'rsd_link');
            
            // Remove Windows Live Writer manifest link
            remove_action('wp_head', 'wlwmanifest_link');
            
            // Remove X-Pingback header
            add_filter('pings_open', '__return_false', 9999);
            
            // Block XML-RPC requests at the earliest possible point
            add_action('init', function() {
                if (defined('XMLRPC_REQUEST') && XMLRPC_REQUEST) {
                    // Return 403 Forbidden
                    header('HTTP/1.1 403 Forbidden');
                    header('Content-Type: text/plain');
                    die('XML-RPC services are disabled on this site.');
                }
            }, 1);
            
            // Alternative: Block access to xmlrpc.php file
            add_action('plugins_loaded', function() {
                if (isset($_SERVER['SCRIPT_FILENAME']) && 
                    'xmlrpc.php' === basename($_SERVER['SCRIPT_FILENAME'])) {
                    status_header(403);
                    die('XML-RPC services are disabled on this site.');
                }
            }, 1);
            
            // Remove XML-RPC methods
            add_filter('xmlrpc_methods', function($methods) {
                return array();
            });
            
            // Disable pingbacks
            add_filter('xmlrpc_call', function($call) {
                if ($call === 'pingback.ping') {
                    return new IXR_Error(403, 'Pingbacks are not supported.');
                }
                return $call;
            });

        }

        /** 
         * remove_rest
         * 
         * The method is responsible for removing the rest api from the front-end
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
         * @return void This method does not return anything
         * 
        */
        private function remove_rest( ) : void {

            // Remove REST API link tag from head
            remove_action('wp_head', 'rest_output_link_wp_head', 10);
            
            // Remove REST API link from HTTP headers
            remove_action('template_redirect', 'rest_output_link_header', 11);
            
            // Remove oEmbed discovery links
            remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
            
            // Remove oEmbed-specific JavaScript from front-end
            remove_action('wp_head', 'wp_oembed_add_host_js');
            
            // Remove JSON API link
            remove_action('wp_head', 'rest_output_link_wp_head');
            
            // Remove shortlink
            remove_action('wp_head', 'wp_shortlink_wp_head', 10);
            
            // Remove alternate link for JSON
            remove_action('wp_head', 'rest_output_link_wp_head', 10);
            
            // Disable REST API for non-logged-in users on front-end
            add_filter('rest_authentication_errors', function($result) {

                // If a previous authentication check has already been performed, return that result
                if (true === $result || is_wp_error($result)) {
                    return $result;
                }
                
                // If user is logged in (wp-admin usage), allow REST API
                if (is_user_logged_in()) {
                    return $result;
                }
                
                // Block REST API access for non-logged-in users
                return new WP_Error(
                    'rest_disabled',
                    __('REST API is disabled for public access.'),
                    array('status' => 401)
                );
            });
            
        }

    }

}