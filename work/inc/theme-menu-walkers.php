<?php
/** 
 * Menu Walker Classes
 * 
 * This is our menu walker classes for both the main navigation and the mobile menu
 * 
 * @since 8.4
 * @author Kevin Pirnie <me@kpirnie.com>
 * @package Kevin Pirnie's Theme
 * 
*/

// We don't want to allow direct access to this
defined( 'ABSPATH' ) || die( 'No direct script access allowed' );

// make sure this isn't already loaded in
if( ! class_exists( 'KPT_Main_Nav_Walker' ) ) {

    // Custom Walker for Desktop Hierarchical Menu (Click-based)
    class KPT_Main_Nav_Walker extends Walker_Nav_Menu {

        function start_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            // For nested submenus (depth > 0), position them to the right
            if ($depth === 0) {
                $output .= "\n$indent<ul class=\"submenu submenu-depth-0 absolute left-0 top-full mt-2 bg-gray-800 rounded-lg shadow-lg py-2 min-w-[200px] hidden z-50\">\n";
            } else {
                $output .= "\n$indent<ul class=\"submenu submenu-depth-{$depth} absolute left-full top-0 ml-2 bg-gray-800 rounded-lg shadow-lg py-2 min-w-[200px] hidden z-50\">\n";
            }
        }
        

        function end_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
        }
        

        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            $indent = ($depth) ? str_repeat("\t", $depth) : '';
            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
            
            // Add class to parent items at any depth
            $has_children = in_array('menu-item-has-children', $classes);
            if ($has_children) {
                $class_names .= ' has-dropdown relative group';
            }
            
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
            
            $output .= $indent . '<li' . $class_names . '>';
            
            // For parent items at ANY depth, create a clickable toggle
            if ($has_children) {

                if ($depth > 0) {
                    $button_classes = 'dropdown-toggle block px-4 py-2 hover:bg-gray-700 transition-colors text-sm whitespace-nowrap w-full text-left flex items-center justify-between';
                } else {
                    $button_classes = 'dropdown-toggle transition-colors flex items-center justify-between w-full text-left px-4 py-2';
                }
                
                $output .= '<button class="' . $button_classes . '"';
                $output .= ' data-depth="' . $depth . '"';
                $output .= ' aria-expanded="false" aria-label="Toggle ' . esc_attr($item->title) . ' menu">';
                $output .= '<span class="whitespace-nowrap text-gray-100">' . esc_html($item->title) . '</span>';
                
                // Use right arrow for all nested menus
                if ($depth > 0) {
                    $output .= '<span class="fa-solid fa-chevron-right ml-2 mt-1 text-xs transition-transform text-gray-400"></span>';
                } else {
                    $output .= '<span class="fa-solid fa-chevron-down ml-2 mt-1 text-xs transition-transform text-gray-400"></span>';
                }
                $output .= '</button>';
            } else {
                // Regular link for items without children
                $atts = array();
                $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
                $atts['target'] = !empty($item->target) ? $item->target : '';
                $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
                $atts['href'] = !empty($item->url) ? $item->url : '';
                
                if ($depth == 0) {
                    $atts['class'] = 'hover:text-[#599bb8] transition-colors flex items-center gap-1 text-gray-100';
                } else {
                    $atts['class'] = 'block px-4 py-2 hover:bg-gray-700 transition-colors text-sm whitespace-nowrap w-full text-left text-gray-100 hover:text-[#599bb8]';
                }
                
                $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
                
                $attributes = '';
                foreach ($atts as $attr => $value) {
                    if (!empty($value)) {
                        $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                        $attributes .= ' ' . $attr . '="' . $value . '"';
                    }
                }
                
                $title = apply_filters('the_title', $item->title, $item->ID);
                $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
                
                $item_output = $args->before;
                $item_output .= '<a' . $attributes . '>';
                $item_output .= $args->link_before . $title . $args->link_after;
                $item_output .= '</a>';
                $item_output .= $args->after;
                
                $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
            }

        }

        function end_el(&$output, $item, $depth = 0, $args = null) {
            $output .= "</li>\n";
        }

    }

}


if( ! class_exists( 'KPT_Mobile_Nav_Walker' ) ) {

    // Custom Walker for Mobile Hierarchical Menu
    class KPT_Mobile_Nav_Walker extends Walker_Nav_Menu {
        function start_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            // Add more indentation for deeper levels
            $ml_class = 'ml-' . (4 * ($depth + 1));
            $output .= "\n$indent<ul class=\"submenu-mobile {$ml_class} mt-2 space-y-2 hidden\">\n";
        }
        

        function end_lvl(&$output, $depth = 0, $args = null) {
            $indent = str_repeat("\t", $depth);
            $output .= "$indent</ul>\n";
        }
        

        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
            $indent = ($depth) ? str_repeat("\t", $depth) : '';
            $classes = empty($item->classes) ? array() : (array) $item->classes;
            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));
            
            $has_children = in_array('menu-item-has-children', $classes);
            if ($has_children) {
                $class_names .= ' has-submenu';
            }
            
            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';
            
            $output .= $indent . '<li' . $class_names . '>';
            
            // Create container for parent items with children
            if ($has_children) {
                $output .= '<div class="flex items-center justify-between w-full">';
            }
            
            // Always create a link (whether it has children or not)
            $atts = array();
            $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = !empty($item->target) ? $item->target : '';
            $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
            $atts['href'] = !empty($item->url) ? $item->url : '';
            
            if ($has_children) {
                $atts['class'] = 'flex-1 block py-2 hover:text-[#599bb8] transition-colors';
            } else {
                $atts['class'] = 'block py-2 hover:text-[#599bb8] transition-colors w-full';
            }
            
            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
            
            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }
            
            $title = apply_filters('the_title', $item->title, $item->ID);
            $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
            
            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            $item_output .= $args->link_before . $title . $args->link_after;
            $item_output .= '</a>';
            $item_output .= $args->after;
            
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
            
            // Add toggle button for parent items
            if ($has_children) {
                $output .= '<button class="submenu-toggle p-2 hover:text-[#599bb8] transition-colors flex-shrink-0" aria-label="Toggle submenu for ' . esc_attr($title) . '" type="button">';
                $output .= '<span class="fa-solid fa-chevron-down transform transition-transform"></span>';
                $output .= '</button>';
                $output .= '</div>';
            }

        }

    }

}

if( ! class_exists( 'KPT_Top_Header_Nav_Walker' ) ) {

    // Custom Walker for Top Header Menu
    class KPT_Top_Header_Nav_Walker extends Walker_Nav_Menu {

        // Method to get FontAwesome icon for menu item
        private function get_menu_icon($item) {
            
            // Separate classes
            $classes = $item->classes;
            
            // Determine icon behavior
            $is_symbol_only = in_array('symbol-only', $classes);
            $symbol_position = in_array('symbol-left', $classes) ? 'left' : 'right';

            // Find explicit icon specification
            $explicit_icon_classes = array_filter($classes, function($class) {
                return strpos($class, 'icon-') === 0 
                    && $class !== 'symbol-only' 
                    && $class !== 'symbol-left' 
                    && $class !== 'symbol-right';
            });

            // Extract icon name, removing the 'icon-' prefix
            $icon = !empty($explicit_icon_classes) 
                ? str_replace('icon-', '', reset($explicit_icon_classes)) 
                : 'link';

            // Determine icon style from classes
            $icon_style = 'fa-regular';
            if (in_array('fa-brands', $classes)) {
                $icon_style = 'fa-brands';
            } elseif (in_array('fa-solid', $classes)) {
                $icon_style = 'fa-solid';
            }

            // Build icon classes
            $icon_class = 'inline-block w-4 h-4';

            return [
                'icon' => sprintf(
                    '<span class="%s fa-%s %s" aria-hidden="true"></span>', 
                    esc_attr($icon_style),
                    esc_attr($icon),
                    esc_attr($icon_class)
                ),
                'is_symbol_only' => $is_symbol_only,
                'symbol_position' => $symbol_position
            ];
        }

        function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {

            $indent = ($depth) ? str_repeat("\t", $depth) : '';
           
            $classes = empty($item->classes) ? array() : (array) $item->classes;

            // Remove icon-related classes from li
            $classes = array_filter($classes, function($class) {
                return strpos($class, 'icon-') !== 0 
                    && strpos($class, 'fa-') !== 0 
                    && $class !== 'symbol-only' 
                    && $class !== 'symbol-left' 
                    && $class !== 'symbol-right';
            });

            $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args, $depth));

            $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

            $output .= $indent . '<li' . $class_names . '>';
            
            // Create link attributes
            $atts = array();
            $atts['title'] = !empty($item->attr_title) ? $item->attr_title : '';
            $atts['target'] = !empty($item->target) ? $item->target : '';
            $atts['rel'] = !empty($item->xfn) ? $item->xfn : '';
            $atts['href'] = !empty($item->url) ? $item->url : '';
            
            // Add icon and styling
            $menu_icon_data = $this->get_menu_icon($item);
            
            $atts['class'] = 'hover:text-[#fd6a4f] transition-colors inline-flex items-center gap-1';
            
            $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args, $depth);
            
            $attributes = '';
            foreach ($atts as $attr => $value) {
                if (!empty($value)) {
                    $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                    $attributes .= ' ' . $attr . '="' . $value . '"';
                }
            }
            
            // For symbol-only, override the title to be empty
            $title = $menu_icon_data['is_symbol_only'] 
                ? '' 
                : apply_filters('the_title', $item->title, $item->ID);
            $title = apply_filters('nav_menu_item_title', $title, $item, $args, $depth);
            
            $item_output = $args->before;
            $item_output .= '<a' . $attributes . '>';
            
            // Determine rendering based on symbol behavior
            if ($menu_icon_data['is_symbol_only']) {
                $item_output .= $menu_icon_data['icon'];
            } elseif ($menu_icon_data['symbol_position'] === 'left') {
                $item_output .= $menu_icon_data['icon'] . $args->link_before . $title . $args->link_after;
            } else {
                $item_output .= $args->link_before . $title . $args->link_after . $menu_icon_data['icon'];
            }
            
            $item_output .= '</a>';
            $item_output .= $args->after;
            
            $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
        }

        function end_el(&$output, $item, $depth = 0, $args = null) {
            $output .= "</li>\n";
        }
        
    }
}