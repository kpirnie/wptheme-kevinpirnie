<?php
/** 
 * CTA Block
 * 
 * Gutenberg block for displaying CTAs
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

if ( ! class_exists( 'KPT_Blocks' ) ) {

    class KPT_Blocks {

        public function register_blocks() : void {
            
            add_action( 'init', array( $this, 'register_cta_block' ) );
            add_action( 'init', array( $this, 'register_contact_form_block' ) );
            add_action( 'init', array( $this, 'register_portfolio_block' ) );
            add_filter( 'block_categories_all', array( $this, 'add_block_category' ), 10, 2 );
            add_action( 'enqueue_block_editor_assets', array( $this, 'enqueue_block_editor_assets' ) );

        }

        public function add_block_category( $categories, $post ) : array {
            
            return array_merge(
                array(
                    array(
                        'slug'  => 'kpt-blocks',
                        'title' => __( 'KP Theme Blocks', 'kpt' ),
                        'icon'  => 'admin-customizer',
                    ),
                ),
                $categories
            );
            
        }

        public function register_portfolio_block() : void {

            if ( ! function_exists( 'register_block_type' ) ) {
                return;
            }

            register_block_type( 'kpt/portfolio-block', array(
                'api_version'     => 2,
                'title'           => __( 'Portfolio Slideshow', 'kpt' ),
                'description'     => __( 'Display portfolio items as a slideshow', 'kpt' ),
                'category'        => 'kpt-blocks',
                'icon'            => 'images-alt2',
                'keywords'        => array( 'portfolio', 'slideshow', 'gallery', 'projects' ),
                'supports'        => array(
                    'anchor' => true,
                    'align'  => array( 'wide', 'full' ),
                ),
                'attributes'      => array(
                    'imageSize' => array(
                        'type'    => 'string',
                        'default' => 'portfolio',
                    ),
                ),
                'render_callback' => array( $this, 'render_portfolio_block' ),
            ) );
            
        }

        public function render_portfolio_block( $attributes ) : string {
    
            $image_size = isset( $attributes['imageSize'] ) ? $attributes['imageSize'] : 'portfolio';
            
            ob_start();
            set_query_var( 'portfolio_image_size', $image_size );
            get_template_part( 'partials/cpts/portfolio' );
            return ob_get_clean();
            
        }

        public function register_cta_block() : void {
            
            if ( ! function_exists( 'register_block_type' ) ) {
                return;
            }

            register_block_type( 'kpt/cta-block', array(
                'api_version'     => 2,
                'title'           => __( 'CTA Display', 'kpt' ),
                'description'     => __( 'Display a Call To Action', 'kpt' ),
                'category'        => 'kpt-blocks',
                'icon'            => 'megaphone',
                'keywords'        => array( 'cta', 'call to action', 'banner' ),
                'supports'        => array(
                    'anchor' => true,
                    'align'  => array( 'wide', 'full' ),
                ),
                'attributes'      => array(
                    'ctaId' => array(
                        'type'    => 'number',
                        'default' => 0,
                    ),
                ),
                'render_callback' => array( $this, 'render_cta_block' ),
            ) );
            
        }

        public function render_cta_block( $attributes ) : string {
            
            $cta_id = isset( $attributes['ctaId'] ) ? intval( $attributes['ctaId'] ) : 0;

            if ( empty( $cta_id ) || get_post_type( $cta_id ) !== 'kpt_cta' ) {
                return '<div class="kpt-cta-block-placeholder" style="padding: 2rem; text-align: center; background: #f0f0f0; border: 2px dashed #ccc; border-radius: 8px;"><p>' . __( 'Please select a CTA to display.', 'kpt' ) . '</p></div>';
            }

            ob_start();
            
            set_query_var( 'cta_id', $cta_id );
            get_template_part( 'partials/cpts/cta' );
            
            return ob_get_clean();
            
        }

        public function enqueue_block_editor_assets() : void {
    
            $is_debug = defined('KPT_DEBUG') && KPT_DEBUG;
            
            // Enqueue the block JavaScript
            wp_enqueue_script(
                'kpt-cta-block-editor',
                get_stylesheet_directory_uri() . '/assets/js/blocks/cta-block.js',
                array( 'wp-blocks', 'wp-element', 'wp-editor', 'wp-components', 'wp-data', 'wp-server-side-render' ),
                $is_debug ? time() : filemtime( get_stylesheet_directory() . '/assets/js/blocks/cta-block.js' )
            );

            // Enqueue Contact Form block JavaScript
            wp_enqueue_script(
                'kpt-contact-form-block-editor',
                get_stylesheet_directory_uri() . '/assets/js/blocks/contact-form-block.js',
                array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-server-side-render' ),
                $is_debug ? time() : filemtime( get_stylesheet_directory() . '/assets/js/blocks/contact-form-block.js' )
            );
            
            // Enqueue Portfolio block JavaScript
            wp_enqueue_script(
                'kpt-portfolio-block-editor',
                get_stylesheet_directory_uri() . '/assets/js/blocks/portfolio-block.js',
                array( 'wp-blocks', 'wp-element', 'wp-block-editor', 'wp-components', 'wp-server-side-render' ),
                $is_debug ? time() : filemtime( get_stylesheet_directory() . '/assets/js/blocks/portfolio-block.js' )
            );
        }

        public function register_contact_form_block() : void {
    
            if ( ! function_exists( 'register_block_type' ) ) {
                return;
            }

            register_block_type( 'kpt/contact-form-block', array(
                'api_version'     => 2,
                'title'           => __( 'Contact Form', 'kpt' ),
                'description'     => __( 'Display the contact form', 'kpt' ),
                'category'        => 'kpt-blocks',
                'icon'            => 'email',
                'keywords'        => array( 'contact', 'form', 'email' ),
                'supports'        => array(
                    'anchor' => true,
                    'align'  => array( 'wide', 'full' ),
                ),
                'render_callback' => array( $this, 'render_contact_form_block' ),
            ) );
            
        }

        public function render_contact_form_block( $attributes ) : string {
            
            ob_start();
            get_template_part( 'partials/contact' );
            return ob_get_clean();
            
        }

    }

}