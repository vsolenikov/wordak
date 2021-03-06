<?php
/**
 * General Settings
 *
 * Register General section, settings and controls for Theme Customizer
 *
 * @package Admiral
 */

/**
 * Adds all general settings to the Customizer
 *
 * @param object $wp_customize / Customizer Object.
 */
function admiral_customize_register_general_settings( $wp_customize ) {

	// Add Section for Theme Options.
	$wp_customize->add_section( 'admiral_section_general', array(
		'title'    => esc_html__( 'General Settings', 'admiral' ),
		'priority' => 10,
		'panel'    => 'admiral_options_panel',
		)
	);

	// Add Blog Title.
	$wp_customize->add_setting( 'admiral_theme_options[blog_title]', array(
		'default'           => wp_kses_post( get_bloginfo( 'description' ) ),
		'type'           	=> 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control( 'admiral_theme_options[blog_title]', array(
		'label'    => esc_html__( 'Blog Title', 'admiral' ),
		'section'  => 'admiral_section_general',
		'settings' => 'admiral_theme_options[blog_title]',
		'type'     => 'text',
		'priority' => 1,
		)
	);

	// Add Main Sidebar Title.
	$wp_customize->add_setting( 'admiral_theme_options[sidebar_main_title]', array(
		'default'           => esc_html__( 'Navigation', 'admiral' ),
		'type'           	=> 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control( 'admiral_theme_options[sidebar_main_title]', array(
		'label'    => esc_html__( 'Main Sidebar Title', 'admiral' ),
		'section'  => 'admiral_section_general',
		'settings' => 'admiral_theme_options[sidebar_main_title]',
		'type'     => 'text',
		'priority' => 2,
		)
	);

	// Add Small Sidebar Title.
	$wp_customize->add_setting( 'admiral_theme_options[sidebar_small_title]', array(
		'default'           => esc_html__( 'Sidebar', 'admiral' ),
		'type'           	=> 'option',
		'transport'         => 'postMessage',
		'sanitize_callback' => 'wp_kses_post',
		)
	);
	$wp_customize->add_control( 'admiral_theme_options[sidebar_small_title]', array(
		'label'    => esc_html__( 'Small Sidebar Title', 'admiral' ),
		'section'  => 'admiral_section_general',
		'settings' => 'admiral_theme_options[sidebar_small_title]',
		'type'     => 'text',
		'priority' => 3,
		)
	);

}
add_action( 'customize_register', 'admiral_customize_register_general_settings' );
