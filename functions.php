<?php
/**
 * Goran functions and definitions
 *
 * @package Goran
 */

/**
 * Set the content width based on the theme's design and stylesheet.
 */
$content_width = 700; /* pixels */

/**
 * Adjust the content width for Front Page, Full Width and Grid Page Template.
 */
function edin_content_width() {
	global $content_width;

	if ( is_page_template( 'page-templates/front-page.php' ) || is_page_template( 'page-templates/full-width-page.php' ) || is_page_template( 'page-templates/grid-page.php' ) ) {
		$content_width = 1086;
	}
}

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function bjorn_setup() {

	/*
	 * Declare textdomain for this child theme.
	 */
	load_child_theme_textdomain( 'bjorn', get_stylesheet_directory() . '/languages' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_image_size( 'edin-thumbnail-landscape', 314, 228, true );
	add_image_size( 'edin-thumbnail-square', 314, 314, true );
	add_image_size( 'edin-featured-image', 772, 9999 );
	add_image_size( 'edin-hero', 1230, 1230 );

	/*
	 * Unregister nav menu.
	 */
	unregister_nav_menu( 'secondary' );

	/*
	 * Editor styles.
	 */
	add_editor_style( array( 'editor-style.css', bjorn_noto_sans_font_url(), bjorn_noto_serif_font_url(), bjorn_droid_sans_mono_font_url() ) );

	/**
	 * Add support for Eventbrite.
	 * See: https://wordpress.org/plugins/eventbrite-api/
	 */
	add_theme_support( 'eventbrite' );

    /**
     * Add theme support for Portfolio Custom Post Type.
     */
    add_theme_support( 'jetpack-portfolio' );
}
add_action( 'after_setup_theme', 'bjorn_setup', 11 );

function bjorn_widgets_init() {
    register_sidebar( array(
        'name'          => __( 'Featured Area One', 'edin' ),
        'id'            => 'featured-1',
        'description'   => __( 'Use this widget area to display widgets in the first column of your Front Page', 'edin' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Featured Area Two', 'edin' ),
        'id'            => 'featured-2',
        'description'   => __( 'Use this widget area to display widgets in the second column of your Front Page', 'edin' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
    register_sidebar( array(
        'name'          => __( 'Featured Area Three', 'edin' ),
        'id'            => 'featured-3',
        'description'   => __( 'Use this widget area to display widgets in the third column of your Front Page', 'edin' ),
        'before_widget' => '<aside id="%1$s" class="widget %2$s">',
        'after_widget'  => '</aside>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ) );
}
add_action( 'widgets_init', 'bjorn_widgets_init' );

// add categories to attachments
function bjorn_add_jetpack_portfolio_type_to_attachments() {
    register_taxonomy_for_object_type( 'jetpack-portfolio-type', 'attachment' );
}
add_action( 'init' , 'bjorn_add_jetpack_portfolio_type_to_attachments' );

function bjorn_jetpack_portfolio_rewrites() {
    add_rewrite_rule('^projects/tagged/(.+)/?', 'index.php?post_type=portfolio&jetpack-portfolio-tag=$matches[1]', 'top');
    add_rewrite_rule('^projects/(.+)/?', 'index.php?post_type=portfolio&jetpack-portfolio-type=$matches[1]', 'top');
    add_rewrite_rule('^projects/?$', 'index.php?post_type=jetpack-portfolio', 'top');
    add_rewrite_rule('^project/(.+)/?', 'index.php?post_type=portfolio&portfolio=$matches[1]', 'top');
    remove_action( 'wp_head', 'rel_canonical' );
    add_action( 'wp_head', 'bjorn_rel_canonical' );
}
add_action('init', 'bjorn_jetpack_portfolio_rewrites');

// this is slightly modified from the original
// rel_canonical function in /wp-includes/link-template.php
//
// assumes we have a custom post_meta property
// called 'my_canonical'
function bjorn_rel_canonical() {
    // original code
    if ( !is_singular() )
        return;
    global $wp_the_query;
    if ( !$id = $wp_the_query->get_queried_object_id() )
        return;
    // original code
    $link = get_permalink( $id );
    if ( $page = get_query_var('cpage') )
        $link = get_comments_pagenum_link( $page );
    $path=parse_url($link,PHP_URL_PATH);
    if(strpos($path,'portfolio') ===1)
        $link=str_replace($path,'/project'.substr($path,10), $link);
    echo "<link rel='canonical' href='$link' />\n";
}
function bjorn_redirect_jetpack_portfolios() {
    if(strpos($_SERVER['REQUEST_URI'], 'project-type')===1)
        wp_redirect(str_replace('project-type', 'projects', $_SERVER['REQUEST_URI']));
    elseif(strpos($_SERVER['REQUEST_URI'], 'portfolio')===1)
        wp_redirect(str_replace('portfolio', 'project', $_SERVER['REQUEST_URI']));
    elseif(strpos($_SERVER['REQUEST_URI'], 'project-tag')===1)
        wp_redirect(str_replace('project-tag', 'projects/tagged/', $_SERVER['REQUEST_URI']));
}
add_action('template_redirect', 'bjorn_redirect_jetpack_portfolios');

function bjorn_post_link($permalink, $post, $leavename) {
    if($post->post_type=='jetpack-portfolio')
        return str_replace('portfolio', 'project', $permalink);
    return $permalink;
}
add_filter('post_type_link', 'bjorn_post_link', 10,3);
/*
 * Setup the WordPress core custom background feature.
 */
function bjorn_custom_background_args( $args ) {
    return array( 'default-color' => 'e1dfdf' );
}
add_filter( 'edin_custom_background_args', 'bjorn_custom_background_args' );

/**
 * Register Noto Sans font.
 *
 * @return string
 */
function bjorn_noto_sans_font_url() {
	$noto_sans_font_url = '';

	/* translators: If there are characters in your language that are not supported
	 * by Noto Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Sans font: on or off', 'bjorn' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Noto Sans character subset specific to your language, translate this to 'cyrillic', 'greek', 'devanagari' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Noto Sans font: add new subset (cyrillic, greek, devanagari or vietnamese)', 'bjorn' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic-ext,cyrillic';
		} else if ( 'greek' == $subset ) {
			$subsets .= ',greek-ext,greek';
		} else if ( 'devanagari' == $subset ) {
			$subsets .= ',devanagari';
		} else if ( 'vietnamese' == $subset ) {
			$subsets .= ',vietnamese';
		}

		$query_args = array(
			'family' => urlencode( 'Noto Sans:400,700,400italic,700italic' ),
			'subset' => urlencode( $subsets ),
		);

		$noto_sans_font_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $noto_sans_font_url;
}

/**
 * Register Noto Serif font.
 *
 * @return string
 */
function bjorn_noto_serif_font_url() {
	$noto_serif_font_url = '';

	/* translators: If there are characters in your language that are not supported
	 * by Noto Serif, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Noto Serif font: on or off', 'bjorn' ) ) {
		$subsets = 'latin,latin-ext';

		/* translators: To add an additional Noto Serif character subset specific to your language, translate this to 'cyrillic', 'greek' or 'vietnamese'. Do not translate into your own language. */
		$subset = _x( 'no-subset', 'Noto Serif font: add new subset (cyrillic, greek, vietnamese)', 'bjorn' );

		if ( 'cyrillic' == $subset ) {
			$subsets .= ',cyrillic-ext,cyrillic';
		} else if ( 'greek' == $subset ) {
			$subsets .= ',greek-ext,greek';
		} else if ( 'vietnamese' == $subset ) {
			$subsets .= ',vietnamese';
		}

		$query_args = array(
			'family' => urlencode( 'Noto Serif:400,700,400italic,700italic' ),
			'subset' => urlencode( $subsets ),
		);

		$noto_serif_font_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $noto_serif_font_url;
}

/**
 * Register Droid Sans Mono font.
 *
 * @return string
 */
function bjorn_droid_sans_mono_font_url() {
	$droid_sans_mono_font_url = '';

	/* translators: If there are characters in your language that are not supported
	 * by Droid Mono Sans, translate this to 'off'. Do not translate into your own language.
	 */
	if ( 'off' !== _x( 'on', 'Droid Sans Mono font: on or off', 'bjorn' ) ) {
		$query_args = array(
			'family' => urlencode( 'Droid Sans Mono' ),
		);

		$droid_sans_mono_font_url = add_query_arg( $query_args, '//fonts.googleapis.com/css' );
	}

	return $droid_sans_mono_font_url;
}


/**
 * Enqueue scripts and styles.
 */
function bjorn_scripts() {
	wp_dequeue_style( 'edin-pt-sans' );

	wp_dequeue_style( 'edin-pt-serif' );

	wp_dequeue_style( 'edin-pt-mono' );

	wp_dequeue_style( 'edin-edincon' );

	wp_dequeue_script( 'edin-navigation' );
	
	wp_dequeue_script( 'edin-script' );

	wp_enqueue_style( 'bjorn-noto-sans', bjorn_noto_sans_font_url(), array(), null );

	wp_enqueue_style( 'bjorn-noto-serif', bjorn_noto_serif_font_url(), array(), null );

	wp_enqueue_style( 'bjorn-droid-sans-mono', bjorn_droid_sans_mono_font_url(), array(), null );

	wp_enqueue_script( 'bjorn-navigation', get_stylesheet_directory_uri() . '/js/navigation.js', array( 'jquery' ), '20140807', true );

	wp_enqueue_script( 'bjorn-script', get_stylesheet_directory_uri() . '/js/bjorn.js', array( 'jquery' ), '20140808', true );
}
add_action( 'wp_enqueue_scripts', 'bjorn_scripts', 11 );

/**
 * Enqueue Google fonts style to admin screen for custom header display.
 *
 * @return void
 */
function bjorn_admin_fonts() {
	wp_dequeue_style( 'edin-pt-sans' );

	wp_dequeue_style( 'edin-pt-serif' );

	wp_dequeue_style( 'edin-pt-mono' );

	wp_enqueue_style( 'bjorn-noto-sans', bjorn_noto_sans_font_url(), array(), null );

	wp_enqueue_style( 'bjorn-noto-serif', bjorn_noto_serif_font_url(), array(), null );

	wp_enqueue_style( 'bjorn-droid-sans-mono', bjorn_droid_sans_mono_font_url(), array(), null );
}
add_action( 'admin_print_scripts-appearance_page_custom-header', 'bjorn_admin_fonts', 11 );

/**
 * Implement the Custom Header feature.
 */
require get_stylesheet_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_stylesheet_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_stylesheet_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_stylesheet_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_stylesheet_directory() . '/inc/jetpack.php';
