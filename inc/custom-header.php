<?php
/**
 * Sample implementation of the Custom Header feature
 * http://codex.wordpress.org/Custom_Headers
 *
 * @package Goran
 */

/**
 * Setup the WordPress core custom header feature.
 *
 * @uses edin_header_style()
 * @uses edin_admin_header_style()
 * @uses edin_admin_header_image()
 */
function bjorn_custom_header_setup() {
	add_theme_support( 'custom-header', apply_filters( 'edin_custom_header_args', array(
		'default-text-color'     => 'ffffff',
		'height'                 => 576,
		'wp-head-callback'       => 'edin_header_style',
		'admin-head-callback'    => 'edin_admin_header_style',
		'admin-preview-callback' => 'edin_admin_header_image',
	) ) );
}
add_action( 'after_setup_theme', 'bjorn_custom_header_setup' );
if ( ! function_exists( 'edin_header_style' ) ) :
    /**
     * Styles the header image and text displayed on the blog
     *
     * @see edin_custom_header_setup().
     */
    function edin_header_style() {
        $header_text_color = get_header_textcolor();
        $header_color = get_header_color();
        $link_color = get_link_color();
        $header_x_position_small = get_header_x_position('small');
        $header_x_position_medium = get_header_x_position('medium');
        $header_x_position_large = get_header_x_position('large');
        // If no custom options for text are set, let's bail
        // get_header_textcolor() options: HEADER_TEXTCOLOR is default, hide text (returns 'blank') or any hex value
        if ( HEADER_TEXTCOLOR == $header_text_color ) {
            return;
        }

        // If we get this far, we have custom styles. Let's do this.
        ?>
        <style type="text/css">
            <?php
                // Has the text been hidden?
                if ( 'blank' == $header_text_color ) :
            ?>
            .site-title,
            .site-description {
                position: absolute;
                clip: rect(1px, 1px, 1px, 1px);
            }
            <?php
                // If the user has set a custom color for the text use that
                else :
            ?>
            .site-title,
            .site-description {
                color: <?php echo $header_text_color; ?>;
            }
            <?php endif; ?>
            <?php
                // Has the text been hidden?
                if ( 'blank' != $header_color ) :
                // If the user has set a custom color for the text use that?>
            @media screen and (max-width: 1020px) {
                .site-header {
                    background-color: <?php echo $header_color; ?>;
                }
            }
            <?php endif; ?>
            <?php
    if ( $header_x_position_small ) :
    // If the user has set a custom color for the text use that?>
            @media screen and (max-width: 600px) {
                .hero.without-featured-image {
                    background-position-x: <?php echo $header_x_position_small; ?>;
                }
            }
            <?php endif; ?>

            <?php
if ( $header_x_position_medium ) :
// If the user has set a custom color for the text use that?>
            @media screen and (min-width: 768px) {
                .hero.without-featured-image {
                    background-position-x: <?php echo $header_x_position_medium; ?>;
                }
            }
            <?php endif; ?>
            <?php
if ($header_x_position_large ) :
// If the user has set a custom color for the text use that?>
            @media screen and (min-width: 1020px) {
                .hero.without-featured-image {
                    background-position-x: <?php echo $header_x_position_large; ?>;
                }
            }
            <?php endif; ?>
            <?php
                // Has the text been hidden?
                if ( 'blank' != $link_color ) :
                // If the user has set a custom color for the text use that?>
            .site-header {
                background-color: <?php echo $header_color; ?>;
            }
            <?php endif; ?>
        </style>
        <?php
    }
endif; // edin_header_style
/**
 * Styles the header image displayed on the Appearance > Header admin panel.
 *
 * @see bjorn_custom_header_setup().
 */
function edin_admin_header_style() {
?>
	<style type="text/css">
		.appearance_page_custom-header #headimg {
			position: relative;
			min-height: 96px;
			background-color: #b23d3c;
			background-position: 50% 50%;
			background-repeat: no-repeat;
			-moz-background-size: cover;
			-o-background-size: cover;
			-webkit-background-size: cover;
			background-size: cover;
			font-family: "Noto Sans", sans-serif;
		}
		.appearance_page_custom-header #headimg:before {
			content: '';
			display: block;
			position: absolute;
			top: 0;
			left: 0;
			width: 100%;
			height: 100%;
			background: rgba(0, 0, 0, 0.225);
		}
		#headimg h1 {
			position: relative;
			padding: 24px 72px;
			margin: 0;
			font-size: 36px;
			line-height: 48px;
			text-transform: uppercase;
		}
		#headimg h1 a {
			text-decoration: none;
		}
	</style>
<?php
}

/**
 * Custom header image markup displayed on the Appearance > Header admin panel.
 *
 * @see bjorn_custom_header_setup().
 */
function edin_admin_header_image() {
	$style = sprintf( ' style="color:#%s;"', get_header_textcolor() );
	$image = sprintf( ' style="background-image:none"', get_header_image() );
	if ( get_header_image() ) {
		$image = sprintf( ' style="background-image:url(%s)"', get_header_image() );
	}
?>
	<div id="headimg"<?php echo $image; ?>>
		<h1 class="displaying-header-text"><a id="name"<?php echo $style; ?> onclick="return false;" href="<?php echo esc_url( home_url( '/' ) ); ?>"><?php bloginfo( 'name' ); ?></a></h1>
	</div>
<?php
}

/**
 * Retrieve color for custom header.
 *
 * @since 2.1.0
 *
 * @return string
 */
function get_header_color() {
    return get_theme_mod('header_color', get_theme_support( 'custom-header', 'default-header-color' ) );
}

/**
 * Retrieve text color for links.
 *
 * @since 2.1.0
 *
 * @return string
 */
function get_link_color() {
    return get_theme_mod('link_color', get_theme_support( 'custom-header', 'default-link-color' ) );
}

/**
 * Retrieve x position for header backgrounds
 *
 * @since 2.1.0
 *
 * @param $screen
 * @return string
 */
function get_header_x_position($screen) {
    return get_theme_mod('header_x_position_'.$screen, get_theme_support( 'custom-header', 'default-screen-size' ) );
}