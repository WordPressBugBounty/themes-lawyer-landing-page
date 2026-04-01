<?php
/**
 * Default Theme Option.
 *
 * @package Lawyer_Landing_Page
 */
 
function lawyer_landing_page_customize_register_default( $wp_customize ) {
	
    /** Default Settings*/
    $wp_customize->add_panel(
	'wp_default_panel',
	array( 
		'priority'      => 10,
		'capability'    => 'edit_theme_options',
		'theme_support' => '',
		'title'         => __( 'Default Settings', 'lawyer-landing-page' ),
		'description'   => __( 'Default section provided by WordPress customizer', 'lawyer-landing-page' ),
		)
	);

		$wp_customize->add_section(
		'lawyer_landing_page_typography_section',
		array(
			'title' => __( 'Typography Settings', 'lawyer-landing-page' ),
			'priority' => 80,
		)
	);

	$wp_customize->add_setting(
		'ed_localgoogle_fonts',
		array(
			'default'           => false,
			'sanitize_callback' => 'lawyer_landing_page_sanitize_checkbox',
		)
	);
	
	$wp_customize->add_control(
		'ed_localgoogle_fonts',
		array(
			'label'   => __( 'Load Google Fonts Locally', 'lawyer-landing-page' ),
			'section' => 'lawyer_landing_page_typography_section',
			'type'    => 'checkbox',
		)
	);

	$wp_customize->add_setting(
		'ed_preload_local_fonts',
		array(
			'default'           => false,
			'sanitize_callback' => 'lawyer_landing_page_sanitize_checkbox',
		)
	);
	
	$wp_customize->add_control(
		'ed_preload_local_fonts',
		array(
			'label'           => __( 'Preload Local Fonts', 'lawyer-landing-page' ),
			'section'         => 'lawyer_landing_page_typography_section',
			'type'            => 'checkbox',
			'active_callback' => 'lawyer_landing_page_flush_fonts_callback'
		)
	);
	

	$wp_customize->add_setting(
		'flush_google_fonts',
		array(
			'default'           => '',
			'sanitize_callback' => 'wp_kses',
		)
	);

	$wp_customize->add_control(
		'flush_google_fonts',
		array(
			'label'       => __( 'Flush Local Fonts Cache', 'lawyer-landing-page' ),
			'description' => __( 'Click the button to reset the local fonts cache.', 'lawyer-landing-page' ),
			'type'        => 'button',
			'settings'    => array(),
			'section'     => 'lawyer_landing_page_typography_section',
			'input_attrs' => array(
				'value' => __( 'Flush Local Fonts Cache', 'lawyer-landing-page' ),
				'class' => 'button button-primary flush-it',
			),
			'active_callback' => 'lawyer_landing_page_flush_fonts_callback'
		)
	);

    $wp_customize->get_section( 'title_tagline' )->panel                          = 'wp_default_panel';
    $wp_customize->get_section( 'colors' )->panel                                 = 'wp_default_panel';
    $wp_customize->get_section( 'background_image' )->panel                       = 'wp_default_panel';
    $wp_customize->get_section( 'static_front_page' )->panel                      = 'wp_default_panel';
    $wp_customize->get_section( 'lawyer_landing_page_typography_section' )->panel = 'wp_default_panel';

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
	$wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
	$wp_customize->get_setting( 'background_color' )->transport = 'refresh';
    $wp_customize->get_setting( 'background_image' )->transport = 'refresh';

	/** Default Settings Ends */
}
add_action( 'customize_register', 'lawyer_landing_page_customize_register_default' );

function lawyer_landing_page_flush_fonts_callback( $control ){
    $ed_localgoogle_fonts   = $control->manager->get_setting( 'ed_localgoogle_fonts' )->value();
    $control_id   = $control->id;
    
    if ( $control_id == 'flush_google_fonts' && $ed_localgoogle_fonts ) return true;
    if ( $control_id == 'ed_preload_local_fonts' && $ed_localgoogle_fonts ) return true;
    return false;
}