<?php
/**
 * Custom functions that act independently of the theme templates
 *
 * Eventually, some of the functionality here could be replaced by core features
 *
 * @package Goran
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
function bjorn_body_classes( $classes ) {
	// Adds a class of hero-image to pages with featured image.
	if ( ( is_page() && has_post_thumbnail() ) || ( '' != get_header_image() && ( ( is_page() && ! has_post_thumbnail() ) || is_404() || is_search() || is_archive() ) ) ) {
		$classes[] = 'hero-image';
	}

	// Adds a class of has-quinary to blogs with front page widgets
	if ( is_active_sidebar( 'sidebar-5' ) || is_active_sidebar( 'sidebar-6' ) || is_active_sidebar( 'sidebar-7' ) )  {
		$classes[] = 'has-quinary';
	}
	// Adds a class of hide-portfolio-page-content to blogs if Theme Option hide portfolio page content is ticked and page is using the Portfolio Template
	if ( get_theme_mod( 'bjorn_hide_portfolio_page_content' ) && is_page_template( 'page-templates/portfolio-page.php' ) ) {
		$classes[] = 'hide-portfolio-page-content';
	}

	return $classes;
}
add_filter( 'body_class', 'bjorn_body_classes' );

/**
 * Adds custom classes to the array of post classes.
 *
 * @param array $classes Classes for the post element.
 * @return array
 */
function bjorn_post_classes( $classes ) {

	// Adds a class of empty-entry-meta to pages/projects without any entry meta.
	$comments_status = false;
	$tags_list = false;
	if ( ! post_password_required() && ( comments_open() || '0' != get_comments_number() ) ) {
		$comments_status = true;
	}
	if ( 'jetpack-portfolio' == get_post_type() ) {
		$tags_list = get_the_term_list( get_the_ID(), 'jetpack-portfolio-tag' );
	}
	if ( ! current_user_can( 'edit_posts' ) && 'post' != get_post_type() && ! $comments_status && ! $tags_list ) {
		$classes[] = 'empty-entry-meta';
	}
	// Adds a class of portfolio-entry to portfolio projects.
	if ( 'jetpack-portfolio' == get_post_type() ) {
		$classes[] = 'portfolio-entry';
	}

	return $classes;
}
add_filter( 'post_class', 'bjorn_post_classes' );

/**
 * Wrap more link
 */
function bjorn_more_link( $link ) {
	return '<p>' . $link . '</p>';
}
add_filter( 'the_content_more_link', 'bjorn_more_link' );
