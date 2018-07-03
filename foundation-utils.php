<?php
/**
 * Plugin Name: Foundation Utils
 * Plugin URI:  https://github.com/PeterBooker/wp-foundation-utils
 * Description: Range of Classes and Function to aid using Foundation for Sites (v6) with WordPress.
 * Version:     1.0
 * Author:      Peter Booker
 * Author URI:  https://www.peterbooker.com/
 * License:     GPLv3
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	die( 'We\'re sorry, but you can not directly access this file.' );
}

require_once( dirname( __FILE__ ) . '/menus/foundation-menus.php' );
require_once( dirname( __FILE__ ) . '/pagination/foundation-pagination.php' );