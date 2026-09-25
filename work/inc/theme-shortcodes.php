<?php
/** 
 * Shortcodes class
 * 
 * This class is responsible for creating the themes shortcodes
 * 
 * @since 8.4
 * @access public
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// make sure this isn't already loaded in
if( ! class_exists( 'KPT_Shortcodes' ) ) {

    /** 
     * KPT_Shortcodes
     * 
     * This class is responsible for properly pulling in our theme assets
     * 
     * @since 8.4
     * @access public
     * @author Kevin Pirnie <me@kpirnie.com>
     * @package Kevin Pirnie's Theme
     * 
    */
    class KPT_Shortcodes {


        public function add_shortcodes( ) : void {

            $this -> add_menu_shortcodes( );

        }

        private function add_menu_shortcodes( ) : void {

            // add our menu shortcodes
            add_shortcode( 'add_social_menu', function( ) {

                return wp_nav_menu( array(
                    'theme_location' => 'social',
                    'container' => 'nav',
                    'container_class' => 'flex items-center',
                    'menu_class' => 'flex items-center space-x-4',
                    'fallback_cb' => false,
                    'depth' => 1,
                    'walker' => new KPT_Top_Header_Nav_Walker( ),
                    'echo' => false,
                ) );

            } );

        }

    }

}