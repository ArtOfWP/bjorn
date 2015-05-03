<?php
/**
 * Add background-image to hero area.
 */
function bjorn_hero_background() {
	if ( ( is_page() && has_post_thumbnail() ) || ( '' != get_header_image() && ( ( is_page() && ! has_post_thumbnail() ) || is_404() || is_search() || is_archive() ) ) ) {
		$css = '.hero.without-featured-image { background-image: url(' . esc_url( get_header_image() ) . '); }';
		wp_add_inline_style( 'edin-style', $css );
	}
}
add_action( 'wp_enqueue_scripts', 'bjorn_hero_background', 11 );

/**
 * Display navigation to next/previous post when applicable.
 */
function edin_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Post navigation', 'bjorn' ); ?></h1>
		<div class="nav-links">
			<?php
				if ( is_attachment() ) :
					previous_post_link( '%link', __( '<span class="meta-nav">Published In</span>%title', 'bjorn' ) );
				else :
					previous_post_link( '%link', __( '<span class="meta-nav">Previous Post</span>%title', 'bjorn' ) );
					next_post_link( '%link', __( '<span class="meta-nav">Next Post</span>%title', 'bjorn' ) );
				endif;
			?>
		</div><!-- .nav-links -->
	</nav><!-- .navigation -->
	<?php
}