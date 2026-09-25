<?php
/** 
 * header.php
 * 
 * This is the header template
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

?>
<!DOCTYPE html>
<html <?php language_attributes( ); ?> class="scroll-smooth dark">
    <head>
        <meta charset="<?php bloginfo( 'charset' ); ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <?php wp_head( ); ?>
        <link rel="icon" type="image/svg+xml" href="/wp-content/uploads/2025/10/kevinpirnie-favicon-initials.svg">
        <link rel="alternate icon" type="image/webp" href="/wp-content/uploads/2025/10/kevinpirnie-favicon-initials_512.webp">
        <link rel="apple-touch-icon" href="/wp-content/uploads/2025/10/kevinpirnie-favicon-initials_512.webp">
    </head>
    <body <?php body_class( 'bg-gray-900 text-gray-100 font-mono' ); ?>>
        <?php wp_body_open( ); ?>

        <svg style="position: absolute; width: 0; height: 0; pointer-events: none;" aria-hidden="true">
            <defs>
                <filter id="fa-thin-filter">
                    <feMorphology operator="erode" radius="0.5"/>
                    <feGaussianBlur stdDeviation="0.1"/>
                </filter>
            </defs>
        </svg>

        <?php
            // pull in the top menu partial
            get_template_part( 'partials/navigation/top' );

            // now pull in the main navigation header
            get_template_part( 'partials/navigation/main' );
        ?>

        <main id="content" class="min-h-screen">
            <div class="w-full">