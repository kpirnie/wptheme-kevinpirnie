<?php
/** 
 * Widget/Sidebar Clas
 * 
 * This file will manage the widgets and sidebars in use through the site
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

if( ! class_exists( 'KPT_Widgets' ) ) {

    /** 
     * Class KPT_Widgets
     * 
     * Our widget and sidebar class
     * 
     * @since 8.4
     * @access public
     * @author Kevin Pirnie <me@kpirnie.com>
     * @package Kevin Pirnie's Theme
     * 
    */
    class KPT_Widgets {

        /** 
         * add_sidebars
         * 
         * Add the themes sidebars
         * 
         * @since 8.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        public function add_sidebars( ) : void {

            // hook into the widget initialization
            add_action( 'widgets_init', function( ) {

                register_sidebar( array(
                    'name' => __( 'Footer Column 1', 'kpt' ),
                    'id' => 'footer-1',
                    'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
                    'after_widget' => '</div>',
                    'before_title' => '<h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">',
                    'after_title' => '</h3>',
                ));
                
                register_sidebar( array(
                    'name' => __( 'Footer Column 2', 'kpt' ),
                    'id' => 'footer-2',
                    'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
                    'after_widget' => '</div>',
                    'before_title' => '<h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">',
                    'after_title' => '</h3>',
                ));
                
                register_sidebar( array(
                    'name' => __( 'Footer Column 3', 'kpt' ),
                    'id' => 'footer-3',
                    'before_widget' => '<div id="%1$s" class="widget %2$s mb-6">',
                    'after_widget' => '</div>',
                    'before_title' => '<h3 class="text-lg font-semibold mb-4 text-gray-900 dark:text-gray-100">',
                    'after_title' => '</h3>',
                ) );

            } );

        }

    }

}
