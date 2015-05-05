<?php
/**
 * Add background-image to hero area.
 */
function bjorn_hero_background() {
    global $portfolio_type_has_featured;
    if(is_post_type_archive('jetpack-portfolio')) {
        /**
         * @var \WP_Query $wp_query
         */
        global $wp_query;
        $cat_obj = $wp_query->get_queried_object();
        if($cat_obj){
            $args = array(
                'post_status' => 'inherit',
                'post_type'=> 'attachment',
                'taxonomy' => 'jetpack-portfolio-type',
                'term' => 'imageholder',
            );
            $queryimg = new WP_Query( $args );/**/
            if($queryimg->have_posts()) {
                $css = '.hero.with-featured-image { background-image: url(' . esc_url($queryimg->post->guid) . '); }';
                wp_add_inline_style('edin-style', $css);
                $portfolio_type_has_featured = true;
            }
        }
        wp_reset_postdata();
    } else if(is_tax( 'jetpack-portfolio-type' )) {
        /**
         * @var \WP_Query $wp_query
         */
        global $wp_query;
        $cat_obj = $wp_query->get_queried_object();
        if($cat_obj){/*
            echo '<pre>';
            var_dump($cat_obj);
            echo '</pre>';
            /**/
            $current_category = $cat_obj->slug;
            $args = array(
                'post_status' => 'inherit',
                'post_type'=> 'attachment',
                'taxonomy' => $cat_obj->taxonomy,
                'term' => $current_category,
            );
            $queryimg = new WP_Query( $args );/**//*
            echo '<pre>';
            var_dump($queryimg);
            echo '</pre>';*/

            if($queryimg->have_posts()) {
                $css = '.hero.with-featured-image { background-image: url(' . esc_url($queryimg->post->guid) . '); }';
                wp_add_inline_style('edin-style', $css);
                $portfolio_type_has_featured = true;
            }
        }
        wp_reset_postdata();
    } else if ( ( is_page() && has_post_thumbnail() ) || ( '' != get_header_image() && ( ( is_page() && ! has_post_thumbnail() ) || is_404() || is_search() || is_archive() ) ) ) {
		$css = '.hero.without-featured-image { background-image: url(' . esc_url( get_header_image() ) . '); }';
		wp_add_inline_style( 'edin-style', $css );
        $portfolio_type_has_featured=true;
    } else {
        $portfolio_type_has_featured=false;
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

/**
 * Change the class of the hero area depending on featured image.
 */
function bjorn_additional_class() {
    global $portfolio_type_has_featured;
	if (! $portfolio_type_has_featured){
        if(! is_archive() || is_search() || is_404() || '' == get_the_post_thumbnail() ) {
            $additional_class = 'without-featured-image';
        } else {
            $additional_class =  'with-featured-image';
        }
	} else {
		$additional_class =  'with-featured-image';
	}

	return $additional_class;
}

/**
 * Add background-image to hero area.
 *//*
function bjorn_hero_background() {
	if ( is_archive() || is_search() || is_404() || '' == get_the_post_thumbnail() ) {
		return;
	} else {
		$thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( get_the_ID() ), 'edin-hero' );
		$css = '.hero.with-featured-image { background-image: url(' . esc_url( $thumbnail[0] ) . '); }';
		wp_add_inline_style( 'bjorn-style', $css );
	}
}*/
remove_action('wp_enqueue_scripts', 'edin_hero_background' );
//add_action( 'wp_enqueue_scripts', 'bjorn_hero_background' );

    function bjorn_featured_areas() {
        get_sidebar( 'featured-areas' );
    }