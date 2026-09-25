<?php
/** 
 * partials/cpts/cta.php
 * 
 * This is the CTA display template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// Get CTA ID
$cta_id = isset( $cta_id ) ? $cta_id : ( isset( $args['cta_id'] ) ? $args['cta_id'] : get_the_ID( ) );

// Get the settings - it's serialized so get_post_meta will unserialize it
$cta_settings = get_post_meta( $cta_id, 'kpt_cta_settings', true );
$cta_buttons = ( $cta_settings['cta_buttons'] ) ?? array( );

// Get CTA data
$cta_title = get_the_title( $cta_id );
$cta_content = get_post_field( 'post_content', $cta_id );
$cta_featured_image = get_the_post_thumbnail_url( $cta_id, 'articlehead' );

// Determine if we have a background image
$has_bg_image = ! empty( $cta_featured_image );
?>

<div class="kpt-cta-container w-full my-8">
    <div class="kpt-cta relative overflow-hidden rounded-lg shadow-lg transition-shadow duration-300 hover:shadow-xl <?php echo $has_bg_image ? 'min-h-[300px]' : 'bg-gradient-to-br from-gray-800 to-gray-900'; ?>">
        
        <?php if ( $has_bg_image ) : ?>
            <!-- Background Image with Overlay -->
            <div class="kpt-cta-bg absolute inset-0 bg-cover bg-center" style="background-image: url('<?php echo esc_url( $cta_featured_image ); ?>');">
                <div class="absolute inset-0 bg-gray-900 opacity-85"></div>
            </div>
        <?php endif; ?>
        
        <!-- Content Container -->
        <div class="kpt-cta-content relative z-10 px-6 py-12 md:px-16">
            <div class="max-w-4xl mx-auto text-center">
                
                <?php if ( ! empty( $cta_title ) ) : ?>
                    <h2 class="text-3xl md:text-4xl font-bold mb-4 text-white">
                        <?php echo esc_html( $cta_title ); ?>
                    </h2>
                <?php endif; ?>
                
                <?php if ( ! empty( $cta_content ) ) : ?>
                    <div class="text-lg text-gray-200 mb-8 leading-relaxed">
                        <?php echo wp_kses_post( $cta_content ); ?>
                    </div>
                <?php endif; ?>
                
                <div class="flex flex-wrap gap-4 justify-center items-center">
                    <!-- Buttons -->
                    <?php if ( ! empty( $cta_buttons ) && is_array( $cta_buttons ) ) : ?>
                        <div class="flex flex-wrap gap-4 justify-center items-center">
                            
                            <?php foreach ( $cta_buttons as $button ) : 
                                // Get button data
                                $button_type = isset( $button['cta_type'] ) ? $button['cta_type'] : 1;
                                $button_link = isset( $button['cta_button'] ) ? $button['cta_button'] : array();
                                $button_url = isset( $button_link['url'] ) ? $button_link['url'] : '';
                                $button_text = isset( $button_link['text'] ) ? $button_link['text'] : '';
                                $button_target = isset( $button_link['target'] ) && ! empty( $button_link['target'] ) ? $button_link['target'] : '_self';
                                
                                // Skip if no URL or text
                                if ( empty( $button_url ) || empty( $button_text ) ) {
                                    continue;
                                }
                                
                                // Determine button class based on type
                                $button_class = 'inline-flex items-center gap-2 px-6 py-2 group text-white rounded-md transition-all font-medium hover:bg-gray-800'; // Default primary
                                
                                if ( $button_type == 2 ) {
                                    $button_class .= ' bg-gray-900';
                                } elseif ( $button_type == 3 ) {
                                    $button_class .= ' bg-[#000000]';
                                } else {
                                    $button_class .= ' btn-primary';
                                }
                            ?>
                                <a href="<?php echo esc_url( $button_url ); ?>" 
                                target="<?php echo esc_attr( $button_target ); ?>"
                                class="<?php echo esc_attr( $button_class ); ?>">
                                    <span><?php echo esc_html( $button_text ); ?></span>
                                    <span class="fa-solid fa-arrow-right text-sm transition-transform group-hover:translate-x-1"></span>
                                </a>
                            <?php endforeach; ?>
                            
                        </div>
                    <?php endif; ?>
                    
                </div>
                
            </div>
        </div>
        
    </div>
</div>