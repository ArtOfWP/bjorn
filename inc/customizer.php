<?php
/**
 * Goran Theme Customizer
 *
 * @package Goran
 */

//remove_action( 'customize_register', 'edin_customize_register' );
/**
 * Add postMessage support for site title and description for the Theme Customizer.
 *
 * @param WP_Customize_Manager $wp_customize Theme Customizer object.
 */
function bjorn_customize_register( $wp_customize ) {
/*	$wp_customize->remove_setting( 'edin_menu_style' );
	$wp_customize->remove_control( 'edin_menu_style' );
	$wp_customize->remove_setting( 'edin_featured_image_remove_filter' );
	$wp_customize->remove_control( 'edin_featured_image_remove_filter' );*/
    $wp_customize->get_setting( 'header_textcolor' )->transport = 'postMessage';
    $wp_customize->remove_setting( 'edin_search_header' );
	$wp_customize->remove_control( 'edin_search_header' );
	$wp_customize->get_setting( 'site_logo' )->transport = 'refresh';

	/* Adds textarea support to the theme customizer */
	class Bjorn_WP_Customize_Control_Textarea extends WP_Customize_Control {
	    public $type = 'textarea';

	    public function render_content() {
	        ?>
	        	<label>
	                <span class="customize-control-title"><?php echo esc_html( $this->label ); ?></span>
	                <textarea cols="20" rows="5" style="width:100%;" <?php $this->link(); ?>><?php echo esc_textarea( $this->value() ); ?></textarea>
	            </label>
	        <?php
	    }
	}

	/* Top Area Content */
	$wp_customize->add_setting( 'bjorn_top_area_content', array(
		'default'           => '',
		'sanitize_callback' => 'wp_kses_post',
	) );
	$wp_customize->add_control( new Bjorn_WP_Customize_Control_Textarea( $wp_customize, 'bjorn_top_area_content', array(
		'label'             => __( 'Top Area Content', 'bjorn' ),
		'section'           => 'edin_theme_options',
		'priority'          => 3,
		'type'              => 'textarea',
	) ) );
    $wp_customize->add_setting('header_x_position_small', array(
        'default'           => 0,
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_control('header_x_position_small', array(
        'label'=> __('Horizontal position small screen', 'bjorn'),
        'description' => __('Move the header image horizontally for small screens.', 'bjorn'),
        'section' => 'header_image',
        'default'     => 0,
        'type'        => 'text',
        'settings'     => 'header_x_position_small'
    ));

    $wp_customize->add_setting('header_x_position_medium', array(
        'default'           => 0,
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_control('header_x_position_medium', array(
        'label'=> __('Horizontal position medium screen', 'bjorn'),
        'section' => 'header_image',
        'default'     => 0,
        'type'        => 'text',
        'settings'     => 'header_x_position_medium'
    ));

    $wp_customize->add_setting('header_x_position_large', array(
        'default'           => 0,
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_control('header_x_position_large', array(
        'label'=> __('Horizontal position large screen', 'bjorn'),
        'section' => 'header_image',
        'default'     => 0,
        'type'        => 'text',
        'settings'     => 'header_x_position_large'
    ));

    $wp_customize->add_setting('header_color', array(
        'default'           => '#b23d3c',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_control('header_color', array(
        'label'=> __('Site header color', 'bjorn'),
        'section' => 'colors',
        'default'     => '#b23d3c',
        'type'        => 'color',
        'settings'     => 'header_color'
    ));
    $wp_customize->add_setting('link_color', array(
        'default'           => '#b23d3c',
        'sanitize_callback' => 'sanitize_text_field',
        'transport' => 'postMessage'
    ));
    $wp_customize->add_control('link_color', array(
        'label'=> __('Link color', 'bjorn'),
        'section' => 'colors',
        'default'     => '#b23d3c',
        'type'        => 'color',
        'settings'     => 'link_color'
    ));

    $wp_customize->add_setting( 'bjorn_hide_portfolio_page_content', array(
        'default'           => '',
        'sanitize_callback' => 'bjorn_sanitize_checkbox',
    ) );

    $wp_customize->add_control( 'bjorn_hide_portfolio_page_content', array(
        'label'             => __( 'Hide title and content on Portfolio Page Template', 'bjorn' ),
        'section'           => 'edin_theme_options',
        'type'              => 'checkbox',
    ) );
}
add_action( 'customize_register', 'bjorn_customize_register', 11 );
/**
 * Sanitize the checkbox.
 *
 * @param boolean $input.
 * @return boolean true if portfolio page template displays title and content.
 */
function bjorn_sanitize_checkbox( $input ) {
    if ( 1 == $input ) {
        return true;
    } else {
        return false;
    }
}
/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function bjorn_customize_preview_js() {
	wp_dequeue_script( 'edin_customizer' );

	wp_enqueue_script( 'bjorn-customizer', get_stylesheet_directory_uri() . '/js/customizer.js', array( 'customize-preview' ), '20150503', true );
}
add_action( 'customize_preview_init', 'bjorn_customize_preview_js', 11 );
