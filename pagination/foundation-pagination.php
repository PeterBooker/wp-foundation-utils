<?php
/**
 * Plugin Name: Foundation Pagination Functions
 * Plugin URI:  https://github.com/PeterBooker/wp-foundation-utils
 * Description: TODO
 * Version:     1.0
 * Author:      Peter Booker
 * Author URI:  https://www.peterbooker.com/
 * License:     GPLv3
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	die( 'We\'re sorry, but you can not directly access this file.' );
}

if ( ! function_exists( 'wpfu_pagination' ) ) {
    /**
     * Outputs Foundation Pagination
     * https://foundation.zurb.com/sites/docs/pagination.html
     * 
     * @return void
     */
    function wpfu_pagination() {
        global $wp_query;

		$big = PHP_INT_MAX;

		$paginate_links = paginate_links(
			array(
				'base'      => str_replace( $big, '%#%', html_entity_decode( get_pagenum_link( $big ) ) ),
				'current'   => max( 1, get_query_var( 'paged' ) ),
				'total'     => $wp_query->max_num_pages,
				'mid_size'  => 5,
				'prev_next' => true,
				'prev_text' => __( '&laquo; Previous' ),
				'next_text' => __( 'Next &raquo;' ),
				'type'      => 'list',
			)
        );

        // Setup wrapper
        $before = '<nav aria-label="Pagination">';
        $after  = '</nav>';

        // Replace relevant parts to match Foundation code
        // TODO: Rewrite to remove need for search/replace
		$paginate_links = str_replace( "<ul class='page-numbers'>", "<ul class='pagination text-center' role='navigation' aria-label='Pagination'>", $paginate_links );
		$paginate_links = str_replace( '<li><span class="page-numbers dots">', "<li><a href='#'>", $paginate_links );
		$paginate_links = str_replace( '</span>', '</a>', $paginate_links );
		$paginate_links = str_replace( "<li><span aria-current='page' class='page-numbers current'>", "<li class='current'>", $paginate_links );
		$paginate_links = str_replace( "<li><a href='#'>&hellip;</a></li>", "<li><span class='dots'>&hellip;</span></li>", $paginate_links );
		$paginate_links = preg_replace( '/\s*page-numbers/', '', $paginate_links );

		// Display the pagination if more than one page is found.
		if ( $paginate_links ) {
			echo $before . $paginate_links . $after;
		}
    }
}

