<?php

/**
 * TailwindCSS Menu Walker for WordPress 6.8
 * Supports unlimited depth and modern TailwindCSS styling
 */
class Tailwind_Menu_Walker extends Walker_Nav_Menu {
    
    /**
     * Starts the list before the elements are added.
     */
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        
        // Different classes based on depth for better styling control
        $classes = [
            'sub-menu',
            'depth-' . $depth
        ];
        
        // Add Tailwind classes for dropdowns
        if ($depth === 0) {
            $classes[] = 'absolute left-0 top-full mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden group-hover:block';
        } else {
            $classes[] = 'absolute left-full top-0 ml-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden group-hover:block';
        }
        
        $class_names = implode(' ', $classes);
        $output .= "\n$indent<ul class=\"$class_names\">\n";
    }

    /**
     * Ends the list of after the elements are added.
     */
    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    /**
     * Starts the element output.
     */
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat("\t", $depth) : '';
        
        $classes = empty( $item->classes ) ? [] : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Add Tailwind classes based on depth and item properties
        $li_classes = [];
        
        if ($depth === 0) {
            $li_classes[] = 'relative group';
        } else {
            $li_classes[] = 'relative group';
        }
        
        if (in_array('menu-item-has-children', $classes)) {
            $li_classes[] = 'has-children';
        }
        
        if (in_array('current-menu-item', $classes)) {
            $li_classes[] = 'active';
        }
        
        $class_names = implode(' ', array_filter($li_classes));
        $output .= $indent . '<li class="' . $class_names . '">';

        // Link attributes
        $attributes = '';
        ! empty( $item->attr_title ) && $attributes .= ' title="' . esc_attr( $item->attr_title ) . '"';
        ! empty( $item->target ) && $attributes .= ' target="' . esc_attr( $item->target ) . '"';
        ! empty( $item->xfn ) && $attributes .= ' rel="' . esc_attr( $item->xfn ) . '"';
        ! empty( $item->url ) && $attributes .= ' href="' . esc_attr( $item->url ) . '"';
        
        // Link classes
        $link_classes = [];
        
        if ($depth === 0) {
            $link_classes = [
                'block',
                'px-4',
                'py-2',
                'text-gray-700',
                'hover:bg-blue-50',
                'hover:text-blue-600',
                'transition',
                'duration-150',
                'ease-in-out',
                'rounded-md'
            ];
        } else {
            $link_classes = [
                'block',
                'px-4',
                'py-2',
                'text-gray-600',
                'hover:bg-blue-50',
                'hover:text-blue-600',
                'transition',
                'duration-150',
                'ease-in-out'
            ];
        }
        
        // Active state
        if (in_array('current-menu-item', $classes)) {
            $link_classes[] = 'bg-blue-50 text-blue-600 font-medium';
        }
        
        $link_class_names = implode(' ', $link_classes);
        $attributes .= ' class="' . $link_class_names . '"';
        
        // Item output
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        
        // Add dropdown arrow for items with children
        if (in_array('menu-item-has-children', $classes)) {
            if ($depth === 0) {
                $item_output .= '<svg class="w-4 h-4 ml-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>';
            } else {
                $item_output .= '<svg class="w-4 h-4 ml-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>';
            }
        }
        
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * Ends the element output, if needed.
     */
    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}

/**
 * Alternative version with mobile-friendly responsive classes
 */
class Tailwind_Responsive_Menu_Walker extends Walker_Nav_Menu {
    
    /**
     * Starts the list before the elements are added.
     */
    public function start_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        
        $classes = [
            'sub-menu',
            'depth-' . $depth
        ];
        
        // Responsive classes - desktop vs mobile
        if ($depth === 0) {
            $classes[] = 'lg:absolute lg:left-0 lg:top-full lg:mt-2 lg:w-48 lg:bg-white lg:rounded-md lg:shadow-lg lg:py-1 lg:z-50 lg:hidden lg:group-hover:block';
            $classes[] = 'pl-4 mt-2 space-y-2 border-l-2 border-gray-200'; // Mobile styles
        } else {
            $classes[] = 'lg:absolute lg:left-full lg:top-0 lg:ml-2 lg:w-48 lg:bg-white lg:rounded-md lg:shadow-lg lg:py-1 lg:z-50 lg:hidden lg:group-hover:block';
            $classes[] = 'pl-4 mt-2 space-y-2 border-l-2 border-gray-200'; // Mobile styles
        }
        
        $class_names = implode(' ', $classes);
        $output .= "\n$indent<ul class=\"$class_names\">\n";
    }

    /**
     * Ends the list of after the elements are added.
     */
    public function end_lvl( &$output, $depth = 0, $args = null ) {
        $indent = str_repeat("\t", $depth);
        $output .= "$indent</ul>\n";
    }

    /**
     * Starts the element output.
     */
    public function start_el( &$output, $item, $depth = 0, $args = null, $id = 0 ) {
        $indent = ( $depth ) ? str_repeat("\t", $depth) : '';
        
        $classes = empty( $item->classes ) ? [] : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;
        
        // Responsive container classes
        $li_classes = ['relative'];
        
        if ($depth === 0) {
            $li_classes[] = 'lg:group';
        } else {
            $li_classes[] = 'lg:group';
        }
        
        if (in_array('menu-item-has-children', $classes)) {
            $li_classes[] = 'has-children';
        }
        
        if (in_array('current-menu-item', $classes)) {
            $li_classes[] = 'active';
        }
        
        $class_names = implode(' ', array_filter($li_classes));
        $output .= $indent . '<li class="' . $class_names . '">';

        // Link attributes
        $attributes = '';
        ! empty( $item->attr_title ) && $attributes .= ' title="' . esc_attr( $item->attr_title ) . '"';
        ! empty( $item->target ) && $attributes .= ' target="' . esc_attr( $item->target ) . '"';
        ! empty( $item->xfn ) && $attributes .= ' rel="' . esc_attr( $item->xfn ) . '"';
        ! empty( $item->url ) && $attributes .= ' href="' . esc_attr( $item->url ) . '"';
        
        // Responsive link classes
        $link_classes = [];
        
        if ($depth === 0) {
            $link_classes = [
                'block',
                'px-4',
                'py-3',
                'lg:py-2',
                'text-gray-700',
                'lg:hover:bg-blue-50',
                'lg:hover:text-blue-600',
                'hover:bg-gray-100',
                'transition',
                'duration-150',
                'ease-in-out',
                'rounded-md',
                'border-b',
                'border-gray-100',
                'lg:border-none'
            ];
        } else {
            $link_classes = [
                'block',
                'px-4',
                'py-2',
                'text-gray-600',
                'lg:hover:bg-blue-50',
                'lg:hover:text-blue-600',
                'hover:bg-gray-100',
                'transition',
                'duration-150',
                'ease-in-out'
            ];
        }
        
        // Active state
        if (in_array('current-menu-item', $classes)) {
            $link_classes[] = 'lg:bg-blue-50 lg:text-blue-600 font-medium bg-gray-50';
        }
        
        $link_class_names = implode(' ', $link_classes);
        $attributes .= ' class="' . $link_class_names . '"';
        
        // Item output
        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . apply_filters( 'the_title', $item->title, $item->ID ) . $args->link_after;
        
        // Responsive dropdown indicators
        if (in_array('menu-item-has-children', $classes)) {
            if ($depth === 0) {
                $item_output .= '<svg class="w-4 h-4 ml-1 inline-block lg:block hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>';
                $item_output .= '<svg class="w-4 h-4 ml-1 inline-block lg:hidden absolute right-4 top-1/2 transform -translate-y-1/2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>';
            } else {
                $item_output .= '<svg class="w-4 h-4 ml-1 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                </svg>';
            }
        }
        
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters( 'walker_nav_menu_start_el', $item_output, $item, $depth, $args );
    }

    /**
     * Ends the element output, if needed.
     */
    public function end_el( &$output, $item, $depth = 0, $args = null ) {
        $output .= "</li>\n";
    }
}