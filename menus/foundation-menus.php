<?php
/**
 * Plugin Name: Foundation Menu Functions and Walkers
 * Plugin URI:  https://github.com/PeterBooker/wp-foundation-utils
 * Description: A custom WordPress Menu Walker compatible with the Foundation 6 Menus and related helper functions. Can be used as a Must Use (MU) plugin or included in a Theme directly.
 * Version:     1.0
 * Author:      Peter Booker
 * Author URI:  https://www.peterbooker.com/
 * License:     GPLv3
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	die( 'We\'re sorry, but you can not directly access this file.' );
}

if ( ! function_exists( 'wpfu_responsive_menu' ) ) {
    /**
     * Outputs a Foundation Top Bar Menu
     * https://foundation.zurb.com/sites/docs/top-bar.html
     * 
     * @return void
     */
    function wpfu_responsive_menu( $title = 'Title', $id = 'responsive-menu', $left_menu = array(), $right_menu = array() ) {
        $defaults = array(
            'container'      => false,
            'menu_class'     => 'dropdown menu',
            'items_wrap'     => '<ul id="%1$s" class="%2$s" data-dropdown-menu>%3$s</ul>',
            'depth'          => 3,
            'fallback_cb'    => false,
            'walker'         => new WPFU_Menu_Walker(),
        );

        $left_args = wp_parse_args( $left_menu, $defaults );
        $right_args = wp_parse_args( $right_menu, $defaults );

        ?>
        <div class="title-bar" data-responsive-toggle="<?php echo esc_attr( $id ); ?>" data-hide-for="medium">
            <button class="menu-icon" type="button" data-toggle="<?php echo esc_attr( $id ); ?>"></button>
            <div class="title-bar-title"><?php echo esc_html( $title ); ?></div>
        </div>
        <div class="top-bar" id="<?php echo esc_attr( $id ); ?>">
            <div class="top-bar-left">
                <?php wp_nav_menu( $left_args ); ?>
            </div>
            <div class="top-bar-right">
                <?php wp_nav_menu( $right_args ); ?>
            </div>
        </div>
        <?php
    }
}

if ( ! function_exists( 'wpfu_top_bar_menu' ) ) {
    /**
     * Outputs a Foundation Top Bar Menu
     * https://foundation.zurb.com/sites/docs/top-bar.html
     * 
     * @return void
     */
    function wpfu_top_bar_menu( $id = 'top-bar-menu', $left_menu = array(), $right_menu = array() ) {

        $defaults = array(
            'container'      => false,
            'menu_class'     => 'dropdown menu',
            'items_wrap'     => '<ul id="%1$s" class="%2$s" data-dropdown-menu>%3$s</ul>',
            'depth'          => 3,
            'fallback_cb'    => false,
            'walker'         => new WPFU_Menu_Walker(),
        );

        $left_args = wp_parse_args( $left_menu, $defaults );
        $right_args = wp_parse_args( $right_menu, $defaults );

        ?>
        <div class="top-bar" id="<?php echo esc_attr( $id ); ?>">
            <div class="top-bar-left">
                <?php wp_nav_menu( $left_args ); ?>
            </div>
            <div class="top-bar-right">
                <?php wp_nav_menu( $right_args ); ?>
            </div>
        </div>
        <?php
    }

}

if ( ! function_exists( 'wpfu_menu' ) ) {
    /**
     * Outputs a Foundation Menu
     * https://foundation.zurb.com/sites/docs/menu.html
     * 
     * @return void
     */
    function wpfu_menu( $args = array() ) {
        $defaults = array(
            'container'      => false,
            'menu_class'     => 'menu',
            'items_wrap'     => '<ul id="%1$s" class="%2$s">%3$s</ul>',
            'depth'          => 3,
            'fallback_cb'    => false,
            'walker'         => new WPFU_Menu_Walker()
        );

        $args = wp_parse_args( $args, $defaults );

        wp_nav_menu( $args );
    }
}

if ( ! class_exists( 'WPFU_Menu_Walker' ) ) {
    class WPFU_Menu_Walker extends Walker_Nav_Menu {

        /**
         * Classes used inside Foundation Menus
         */
        private static $active = 'is-active';
        private static $has_submenu = 'has-submenu';

        /**
         * Add Top Bar specific CSS classes to menu items
         */
        function display_element( $element, &$children_elements, $max_depth, $depth = 0, $args, &$output ) {
            $element->has_children = ! empty( $children_elements[ $element->ID ] );
            if ( ! empty( $element->classes ) ) {
                $element->classes[] = ( $element->current || $element->current_item_ancestor ) ? $this->active_class : '';
                $element->classes[] = ( $element->has_children ) ? $this->has_submenu : '';
            }
            parent::display_element( $element, $children_elements, $max_depth, $depth, $args, $output );
        }

        /**
         * Start new Menu level
         */
        function start_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat("\t", $depth);
            $output .= "\n" . $indent . "<ul class=\"submenu menu vertical\">\n";
        }

        /**
         * End new Menu level
         */
        function end_lvl( &$output, $depth = 0, $args = array() ) {
            $indent = str_repeat( "\t", $depth );
            $output .= $indent . "</ul>\n";
        }

        /**
         * Build attributes string
         */
        private function build_attributes( $item ) {
            $attributes = '';
            $attributes .= ! empty( $item->attr_title ) ? ' title="' . esc_attr( $item->attr_title ) . '"' : '';
            $attributes .= ! empty( $item->target ) ? ' target="' . esc_attr( $item->target ) . '"' : '';
            $attributes .= ! empty( $item->xfn ) ? ' rel="' . esc_attr( $item->xfn ) . '"' : '';
            $attributes .= ! empty( $item->url ) ? ' href="' . esc_attr( $item->url ) . '"' : '';
            return $attributes;
        }

        /**
         * Provide fallback output incase no Menu is selected.
         */
        public static function fallback( $args = array() ) {
            /**
             * No content for left side Fallback
             */
            $home_url = esc_url( site_url( '/' ) );
            $admin_menu_url = esc_url( admin_url( '/nav-menus.php' ) );
            $output = "<ul class=\"dropdown menu\">\n";
            $output .= "<li>\n";
            $output .= "<a href=\"{$home_url}\">Home</a>\n";
            $output .= "</li>\n";
            if ( current_user_can( 'manage_options' ) ) {
                $output .= "<li>\n";
                $output .= "<a href=\"{$admin_menu_url}\">Customize Menu</a>\n";
                $output .= "</li>\n";
            }
            $output .= "</ul>";
            echo $output;
        }

        /**
         * Filter Menu Args relevant for this Walker
         */
        public static function menu_args( $args ) {
            if ( $args['walker'] instanceof WPFU_Menu_Walker ) {
                $args['container'] = false;
                $args['fallback_cb'] = 'WPFU_Menu_Walker::fallback';
            }
            return $args;
        }
    }

    // Force Certain Args for Compatibility
    add_filter( 'wp_nav_menu_args', array( 'WPFU_Menu_Walker', 'menu_args' ) );
}