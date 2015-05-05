<?php
/**
 * Jetpack Compatibility File
 * See: http://jetpack.me/
 *
 * @package Goran
 */

function bjorn_jetpack_setup() {
	/**
	 * Add theme support for Logo upload.
	 */
	add_image_size( 'edin-logo', 314, 192 );
}
add_action( 'after_setup_theme', 'bjorn_jetpack_setup', 11 );

/**
 * Load Jetpack scripts.
 */
function bjorn_jetpack_scripts() {
	if ( is_post_type_archive( 'jetpack-portfolio' ) || is_tax( 'jetpack-portfolio-type' ) || is_tax( 'jetpack-portfolio-tag' ) || is_page_template( 'page-templates/portfolio-page.php' ) ) {
		wp_enqueue_script( 'bjorn-portfolio', get_stylesheet_directory_uri() . '/js/portfolio.js', array( 'jquery', 'jquery-masonry' ), '20140325', true );
	}
	if ( is_singular() && 'jetpack-portfolio' == get_post_type() ) {
		wp_enqueue_script( 'bjorn-portfolio-single', get_stylesheet_directory_uri() . '/js/portfolio-single.js', array( 'jquery', 'underscore' ), '20140328', true );
	}
	if ( is_page_template( 'page-templates/portfolio-page.php' ) ) {
		wp_enqueue_script( 'bjorn-portfolio-page', get_stylesheet_directory_uri() . '/js/portfolio-page.js', array( 'jquery' ), '20140402', true );
	}
}
add_action( 'wp_enqueue_scripts', 'bjorn_jetpack_scripts' );