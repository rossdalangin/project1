<?php
/**
 * Theme Customizer Settings & Controls
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function ross_portfolio_customize_register( $wp_customize ) {

	$wp_customize->add_panel(
		'ross_portfolio_panel',
		array(
			'priority'    => 10,
			'title'       => __( 'Portfolio & Theme Styling', 'ross-portfolio' ),
			'description' => __( 'Manage curated color palettes, owner profile details, mobile CTA, phone number, and FAQ items.', 'ross-portfolio' ),
		)
	);

	// Section 0: Curated Style & Color Presets
	$wp_customize->add_section(
		'ross_portfolio_styling_section',
		array(
			'title'       => __( 'Theme Styling & Color Themes', 'ross-portfolio' ),
			'panel'       => 'ross_portfolio_panel',
			'priority'    => 5,
			'description' => __( 'Select from 6 popular and modern dark glassmorphism styling presets.', 'ross-portfolio' ),
		)
	);

	$presets = ross_portfolio_get_style_presets();
	$preset_choices = array();
	foreach ( $presets as $key => $preset_data ) {
		$preset_choices[ $key ] = $preset_data['name'];
	}

	$wp_customize->add_setting(
		'theme_style_preset',
		array(
			'default'           => 'obsidian-cyber',
			'sanitize_callback' => 'sanitize_key',
		)
	);
	$wp_customize->add_control(
		'theme_style_preset',
		array(
			'label'       => __( 'Preset Color Combination & Style', 'ross-portfolio' ),
			'description' => __( 'Choose a modern preset to instantly restyle your header, cards, buttons, backgrounds, and accents.', 'ross-portfolio' ),
			'section'     => 'ross_portfolio_styling_section',
			'type'        => 'select',
			'choices'     => $preset_choices,
		)
	);

	// Section 1: Profile Details & Contact Info
	$wp_customize->add_section(
		'ross_portfolio_profile_section',
		array(
			'title'    => __( 'Owner Profile & Direct Contact', 'ross-portfolio' ),
			'panel'    => 'ross_portfolio_panel',
			'priority' => 10,
		)
	);

	$wp_customize->add_setting(
		'profile_display_name',
		array(
			'default'           => 'Ross',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'profile_display_name',
		array(
			'label'   => __( 'Display Name', 'ross-portfolio' ),
			'section' => 'ross_portfolio_profile_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'profile_title',
		array(
			'default'           => 'Principal Theme Architect & Front-End Performance Lead',
			'sanitize_callback' => 'sanitize_text_field',
			'transport'         => 'postMessage',
		)
	);
	$wp_customize->add_control(
		'profile_title',
		array(
			'label'   => __( 'Job Title / Role', 'ross-portfolio' ),
			'section' => 'ross_portfolio_profile_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'profile_location',
		array(
			'default'           => 'San Francisco, CA',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'profile_location',
		array(
			'label'   => __( 'Location', 'ross-portfolio' ),
			'section' => 'ross_portfolio_profile_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'profile_email',
		array(
			'default'           => 'ross@example.com',
			'sanitize_callback' => 'sanitize_email',
		)
	);
	$wp_customize->add_control(
		'profile_email',
		array(
			'label'   => __( 'Contact Email', 'ross-portfolio' ),
			'section' => 'ross_portfolio_profile_section',
			'type'    => 'email',
		)
	);

	// Phone Number Control
	$wp_customize->add_setting(
		'profile_phone',
		array(
			'default'           => '+1 (555) 019-2834',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'profile_phone',
		array(
			'label'       => __( 'Direct Phone Number', 'ross-portfolio' ),
			'description' => __( 'Displayed in the header and mobile navigation drawer for immediate calls.', 'ross-portfolio' ),
			'section'     => 'ross_portfolio_profile_section',
			'type'        => 'text',
		)
	);

	$wp_customize->add_setting(
		'profile_avatar_url',
		array(
			'default'           => '',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		new WP_Customize_Image_Control(
			$wp_customize,
			'profile_avatar_url',
			array(
				'label'   => __( 'Profile Avatar Image', 'ross-portfolio' ),
				'section' => 'ross_portfolio_profile_section',
			)
		)
	);

	$wp_customize->add_setting(
		'profile_bio',
		array(
			'default'           => 'Passionate software engineer focused on ultra-performant, accessible web architectures, custom WordPress systems, and modern glassmorphism design.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'profile_bio',
		array(
			'label'   => __( 'Bio / Summary', 'ross-portfolio' ),
			'section' => 'ross_portfolio_profile_section',
			'type'    => 'textarea',
		)
	);

	// Section 2: Header & Mobile Call to Action
	$wp_customize->add_section(
		'ross_portfolio_header_cta_section',
		array(
			'title'    => __( 'Header & Mobile Call To Action', 'ross-portfolio' ),
			'panel'    => 'ross_portfolio_panel',
			'priority' => 15,
		)
	);

	$wp_customize->add_setting(
		'header_cta_text',
		array(
			'default'           => "Let's Talk",
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'header_cta_text',
		array(
			'label'   => __( 'Header / Mobile CTA Button Text', 'ross-portfolio' ),
			'section' => 'ross_portfolio_header_cta_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'header_cta_url',
		array(
			'default'           => '#contact',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'header_cta_url',
		array(
			'label'   => __( 'Header / Mobile CTA Button URL', 'ross-portfolio' ),
			'section' => 'ross_portfolio_header_cta_section',
			'type'    => 'text',
		)
	);

	// Section 3: Social Links
	$wp_customize->add_section(
		'ross_portfolio_social_section',
		array(
			'title'    => __( 'Social Media Links', 'ross-portfolio' ),
			'panel'    => 'ross_portfolio_panel',
			'priority' => 20,
		)
	);

	$wp_customize->add_setting(
		'profile_github',
		array(
			'default'           => 'https://github.com',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'profile_github',
		array(
			'label'   => __( 'GitHub URL', 'ross-portfolio' ),
			'section' => 'ross_portfolio_social_section',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting(
		'profile_linkedin',
		array(
			'default'           => 'https://linkedin.com',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'profile_linkedin',
		array(
			'label'   => __( 'LinkedIn URL', 'ross-portfolio' ),
			'section' => 'ross_portfolio_social_section',
			'type'    => 'url',
		)
	);

	$wp_customize->add_setting(
		'profile_twitter',
		array(
			'default'           => 'https://twitter.com',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'profile_twitter',
		array(
			'label'   => __( 'Twitter / X URL', 'ross-portfolio' ),
			'section' => 'ross_portfolio_social_section',
			'type'    => 'url',
		)
	);

	// Section 4: Hero Headlines & CTA
	$wp_customize->add_section(
		'ross_portfolio_hero_section',
		array(
			'title'    => __( 'Hero Headlines & CTA', 'ross-portfolio' ),
			'panel'    => 'ross_portfolio_panel',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'hero_headline',
		array(
			'default'           => 'Building Modern, Performant Digital Experiences',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'hero_headline',
		array(
			'label'   => __( 'Hero Headline', 'ross-portfolio' ),
			'section' => 'ross_portfolio_hero_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hero_subhead',
		array(
			'default'           => 'Classic WordPress engineering without bloated plugins or dependencies.',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'hero_subhead',
		array(
			'label'   => __( 'Hero Subheadline', 'ross-portfolio' ),
			'section' => 'ross_portfolio_hero_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hero_cta_text',
		array(
			'default'           => 'View Portfolio Projects',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'hero_cta_text',
		array(
			'label'   => __( 'Call to Action Button Text', 'ross-portfolio' ),
			'section' => 'ross_portfolio_hero_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hero_cta_url',
		array(
			'default'           => '#projects',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'hero_cta_url',
		array(
			'label'   => __( 'Call to Action URL', 'ross-portfolio' ),
			'section' => 'ross_portfolio_hero_section',
			'type'    => 'text',
		)
	);

	// Section 5: FAQ Items
	$wp_customize->add_section(
		'ross_portfolio_faq_section',
		array(
			'title'       => __( 'FAQ Accordion Items', 'ross-portfolio' ),
			'panel'       => 'ross_portfolio_panel',
			'priority'    => 40,
			'description' => __( 'Custom JSON format array of FAQ objects: [{"question":"...", "answer":"..."}]', 'ross-portfolio' ),
		)
	);

	$wp_customize->add_setting(
		'portfolio_faqs_json',
		array(
			'default'           => '',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'portfolio_faqs_json',
		array(
			'label'       => __( 'FAQ Accordion Data (JSON)', 'ross-portfolio' ),
			'description' => __( 'Leave empty to use default FAQ items.', 'ross-portfolio' ),
			'section'     => 'ross_portfolio_faq_section',
			'type'        => 'textarea',
		)
	);
}
add_action( 'customize_register', 'ross_portfolio_customize_register' );
