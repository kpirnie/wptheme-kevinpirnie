<?php
/** 
 * Theme Settings
 * 
 * This class controls the themes settings
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// pull our framework
use \KP\WPFieldFramework\Loader;

// make sure this class doesnt already exist
if( ! class_exists( 'KPT_Settings' ) ) {

    /** 
     * Class KPT_Settings
     * 
     * Controls the theme settings
     * 
     * @since 8.4
     * @access public
     * @author Kevin Pirnie <me@kpirnie.com>
     * @package Kevin Pirnie's Theme
     * 
    */
    class KPT_Settings {

        // hold the framework
        private $fw;

        /** 
         * add_settings
         * 
         * Add in the theme's settings
         * 
         * @since 8.4
         * @access public
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        public function add_settings( ) : void {

            // setup the framework
            $this -> fw = Loader::init( );

            // call the admin settings
            $this -> create_theme_settings( );

            // add in the heroes settings
            $this -> heroes_settings( );

            // add in the cta settings
            $this -> cta_settings( );

            // add in the portfolio settings
            $this -> portfolio_settings( );

            // add in the post settings
            $this -> post_settings( );
            

        }

        /** 
         * create_theme_settings
         * 
         * Create the theme's settings
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function create_theme_settings( ) : void {

            // our settings id
            $settings_id = 'kptheme_settings';

            // create the main options page
            $this -> fw -> addOptionsPage( [
                'option_key' => $settings_id,
                'page_title'  => 'Theme Options',
                'menu_title'  => 'Theme Options',
                'capability'  => 'manage_options',
                'menu_slug'   => 'theme-options',
                'icon_url'    => 'dashicons-admin-customizer',
                'position'    => 2,
                'sections'    => [
                    'general' => [
                        'title'       => 'General',
                        'description' => 'General theme settings.',
                        'fields'      => [
                            [
                                'id'          => 'kpt_recaptcha_site_key',
                                'type'        => 'text',
                                'label'       => 'reCaptcha Site Key',
                                'placeholder' => 'Enter site key...',
                                'default'     => '',
                                'required'    => true,
                            ],
                            [
                                'id'          => 'kpt_recaptcha_secret_key',
                                'type'        => 'text',
                                'label'       => 'reCaptcha Secret Key',
                                'placeholder' => 'Enter recpatcha secret...',
                                'default'     => '',
                                'required'    => true,
                            ],
                        ],
                    ],
                ],
            ] );

        }

        /** 
         * heroes_settings
         * 
         * Add the theme's hero settings settings
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function heroes_settings( ) : void {

            // page settings key
            $settings_key = 'kpt_hero_settings';

            // add out metabox
            $this -> fw -> addMetaBox( [
                'id' => $settings_key,
                'title' => 'Page Options',
                'post_types' => ['page',],
                'context' => 'side',
                'priority' => 'high',
                'fields' => [
                    [
                        'id'          => 'page_secondary_title',
                        'type'        => 'text',
                        'label'       => 'Secondary Title',
                        'description' => 'this is only shown on the admin list page',
                    ],
                    [
                        'id'          => 'page_assignment',
                        'type'        => 'checkboxes',
                        'label'       => 'Hero Assignment',
                        'description' => 'Select the heroes you want to assign here',
                        'options'     => $this -> get_heroes( ),
                    ],
                    
                ],
            ] );

        }

        /** 
         * portfolio_settings
         * 
         * Add the theme's portfolio settings
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function portfolio_settings() : void {
            
            // portfolio settings key
            $settings_key = 'kpt_portfolio_settings';

            // add our metabox
            $this -> fw -> addMetaBox( [
                'id' => $settings_key,
                'title' => 'Portfolio Options',
                'post_types' => ['kpt_portfolio',],
                'context' => 'side',
                'priority' => 'high',
                'fields' => [
                    [
                        'id'          => 'portfolio_url',
                        'type'        => 'link',
                        'label'       => 'Client Site URL',
                    ],
                    
                ],
            ] );

        }

        /** 
         * cta_settings
         * 
         * Add the theme's CTA settings
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function cta_settings( ) : void {

            // page settings key
            $settings_key = 'kpt_cta_settings';

            // add our metabox
            $this -> fw -> addMetaBox( [
                'id' => $settings_key,
                'title' => 'CTA Options',
                'post_types' => ['kpt_cta',],
                'context' => 'side',
                'priority' => 'high',
                'fields' => [
                    [
                        'id'          => 'cta_buttons',
                        'type'        => 'repeater',
                        'label'       => 'Buttons',
                        'button_label' => 'Add Button',
                        'collapsed'    => true,
                        'sortable'     => true,
                        'row_label'    => 'Button',
                        'fields'       => [
                            [
                                'id' => 'cta_button_type',
                                'label' => 'Type',
                                'type' => 'select',
                                'options' => [
                                    1 => 'Primary',
                                    2 => 'Secondary',
                                    3 => 'Plain',
                                ]
                            ],
                            [
                                'id'           => 'cta_button_link',
                                'type'         => 'link',
                                'title'        => 'Link',
                            ],
                        ],
                    ],
                    
                ],
            ] );

        }

        /** 
         * post_settings
         * 
         * Add the theme's POST settings
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function post_settings( ) : void {

            // page settings key
            $settings_key = 'kpt_post_settings';

            // add out metabox
            $this -> fw -> addMetaBox( [
                'id' => $settings_key,
                'title' => 'Post Options',
                'post_types' => ['post',],
                'context' => 'side',
                'priority' => 'high',
                'fields' => [
                    [
                        'id'          => 'post_social_posted',
                        'type'        => 'checkbox',
                        'label'       => 'Posted on Social?',
                        'description' => 'is this posted on the social networks yet?',
                    ],                    
                ],
            ] );

        }
        
        /** 
         * get_heroes
         * 
         * Get all heroes for the settings
         * 
         * @since 8.4
         * @access private
         * @author Kevin Pirnie <me@kpirnie.com>
         * @package Kevin Pirnie's Theme
         * 
        */
        private function get_heroes( ) : array {

            // the return
            $ret = [];

            // setup the args for the hero CPT
            $args = array(
                'post_type'      => 'kpt_hero', 
                'posts_per_page' => -1,
                'post_status'    => 'publish',
                'fields'         => 'ids',
            );

            // now get the heroes
            $heroes = get_posts( $args );

            // if there aren't ay heroes
            if( ! $heroes ) {
                return $ret;
            }

            // loop over them
            foreach( $heroes as $hero ) {

                $ret[$hero] = get_the_title( $hero );

            }

            // return it
            return $ret;

        }

    }

}