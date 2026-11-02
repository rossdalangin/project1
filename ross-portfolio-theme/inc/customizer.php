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
			'description' => __( 'Manage curated color palettes, profile details, homepage sections, CTAs, skills, and FAQ items without JSON.', 'ross-portfolio' ),
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
			'sanitize_callback' => 'ross_portfolio_sanitize_select',
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
			'title'    => __( 'Owner Profile & Contact Info', 'ross-portfolio' ),
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
			'description' => __( 'Displayed in the header, contact cards, and mobile drawer.', 'ross-portfolio' ),
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

	// Section 4: Hero Section Content & Headlines
	$wp_customize->add_section(
		'ross_portfolio_hero_section',
		array(
			'title'    => __( 'Homepage: Hero Section', 'ross-portfolio' ),
			'panel'    => 'ross_portfolio_panel',
			'priority' => 30,
		)
	);

	$wp_customize->add_setting(
		'hero_badge_text',
		array(
			'default'           => 'Available for Q1 / Q2 Contracts & Architecture Advisory',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'hero_badge_text',
		array(
			'label'   => __( 'Availability Badge Text', 'ross-portfolio' ),
			'section' => 'ross_portfolio_hero_section',
			'type'    => 'text',
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
			'label'   => __( 'Primary Call to Action Button Text', 'ross-portfolio' ),
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
			'label'   => __( 'Primary Call to Action URL', 'ross-portfolio' ),
			'section' => 'ross_portfolio_hero_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hero_secondary_cta_text',
		array(
			'default'           => 'Get in Touch',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'hero_secondary_cta_text',
		array(
			'label'   => __( 'Secondary Call to Action Button Text', 'ross-portfolio' ),
			'section' => 'ross_portfolio_hero_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'hero_secondary_cta_url',
		array(
			'default'           => '#contact',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'hero_secondary_cta_url',
		array(
			'label'   => __( 'Secondary Call to Action URL', 'ross-portfolio' ),
			'section' => 'ross_portfolio_hero_section',
			'type'    => 'text',
		)
	);

	// Hero Key Highlights / Metric Chips
	for ( $m = 1; $m <= 3; $m++ ) {
		$default_stats = array(
			1 => array( 'value' => '100/100', 'label' => 'Core Web Vitals' ),
			2 => array( 'value' => '10+ Yrs', 'label' => 'Enterprise Architecture' ),
			3 => array( 'value' => '0 Deps', 'label' => 'Pure Vanilla Standards' ),
		);
		$wp_customize->add_setting(
			"hero_stat_{$m}_value",
			array(
				'default'           => $default_stats[ $m ]['value'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"hero_stat_{$m}_value",
			array(
				'label'   => sprintf( __( 'Hero Metric #%d: Value', 'ross-portfolio' ), $m ),
				'section' => 'ross_portfolio_hero_section',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"hero_stat_{$m}_label",
			array(
				'default'           => $default_stats[ $m ]['label'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"hero_stat_{$m}_label",
			array(
				'label'   => sprintf( __( 'Hero Metric #%d: Label', 'ross-portfolio' ), $m ),
				'section' => 'ross_portfolio_hero_section',
				'type'    => 'text',
			)
		);
	}

	// Section 5: Skills & Technical Expertise Section (No JSON, Text & Image / Icon Fields)
	$wp_customize->add_section(
		'ross_portfolio_skills_section',
		array(
			'title'       => __( 'Homepage: Skills & Expertise Section', 'ross-portfolio' ),
			'panel'       => 'ross_portfolio_panel',
			'priority'    => 35,
			'description' => __( 'Manage section headings and individual skill cards with text and images.', 'ross-portfolio' ),
		)
	);

	$wp_customize->add_setting(
		'skills_section_tag',
		array(
			'default'           => 'Core Capabilities',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'skills_section_tag',
		array(
			'label'   => __( 'Section Tag / Badge', 'ross-portfolio' ),
			'section' => 'ross_portfolio_skills_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'skills_section_title',
		array(
			'default'           => 'Technical Excellence & Architecture',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'skills_section_title',
		array(
			'label'   => __( 'Section Title', 'ross-portfolio' ),
			'section' => 'ross_portfolio_skills_section',
			'type'    => 'text',
		)
	);

	$default_skills = array(
		1 => array(
			'title' => 'Zero-Dependency Vanilla JS',
			'desc'  => 'Pure ES6+ JavaScript engineered for maximum execution speed, zero third-party dependencies, and zero render-blocking assets.',
			'icon'  => 'terminal',
		),
		2 => array(
			'title' => '100/100 Core Web Vitals',
			'desc'  => 'Native system font stacks, optimized critical CSS rendering, zero layout shift (CLS), and sub-100ms Largest Contentful Paint (LCP).',
			'icon'  => 'bolt',
		),
		3 => array(
			'title' => 'WCAG 2.2 AA Accessibility',
			'desc'  => 'Full keyboard focus trapping, ARIA live regions, explicit :focus-visible outlines, and screen reader semantic landmarks.',
			'icon'  => 'target',
		),
		4 => array(
			'title' => 'Enterprise Security',
			'desc'  => 'Strict ABSPATH protection, comprehensive sanitization, SVG whitelisting, and strict security HTTP headers.',
			'icon'  => 'shield',
		),
		5 => array(
			'title' => 'AEO & GEO Optimization',
			'desc'  => 'Deep JSON-LD structured schema integration for AI answer engines (Perplexity, ChatGPT) and search graphs.',
			'icon'  => 'search',
		),
		6 => array(
			'title' => 'Modern Glassmorphism UI',
			'desc'  => 'Multi-layered backdrop-filters, subtle high-contrast borders, ambient radial glows, and 6 curated color themes.',
			'icon'  => 'layers',
		),
	);

	$icon_choices = array(
		'terminal' => __( 'Terminal / Code Prompt', 'ross-portfolio' ),
		'bolt'     => __( 'Lightning Bolt / Speed', 'ross-portfolio' ),
		'target'   => __( 'Target / Accessibility', 'ross-portfolio' ),
		'shield'   => __( 'Shield / Security', 'ross-portfolio' ),
		'search'   => __( 'Search / AEO SEO', 'ross-portfolio' ),
		'layers'   => __( 'Layers / Modern Glass UI', 'ross-portfolio' ),
	);

	for ( $i = 1; $i <= 6; $i++ ) {
		// Skill Title
		$wp_customize->add_setting(
			"skill_{$i}_title",
			array(
				'default'           => $default_skills[ $i ]['title'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"skill_{$i}_title",
			array(
				'label'       => sprintf( __( 'Skill #%d: Title', 'ross-portfolio' ), $i ),
				'section'     => 'ross_portfolio_skills_section',
				'type'        => 'text',
			)
		);

		// Skill Description
		$wp_customize->add_setting(
			"skill_{$i}_desc",
			array(
				'default'           => $default_skills[ $i ]['desc'],
				'sanitize_callback' => 'sanitize_textarea_field',
			)
		);
		$wp_customize->add_control(
			"skill_{$i}_desc",
			array(
				'label'       => sprintf( __( 'Skill #%d: Description', 'ross-portfolio' ), $i ),
				'section'     => 'ross_portfolio_skills_section',
				'type'        => 'textarea',
			)
		);

		// Skill Icon Choice
		$wp_customize->add_setting(
			"skill_{$i}_icon",
			array(
				'default'           => $default_skills[ $i ]['icon'],
				'sanitize_callback' => 'ross_portfolio_sanitize_select',
			)
		);
		$wp_customize->add_control(
			"skill_{$i}_icon",
			array(
				'label'       => sprintf( __( 'Skill #%d: Standard Icon', 'ross-portfolio' ), $i ),
				'section'     => 'ross_portfolio_skills_section',
				'type'        => 'select',
				'choices'     => $icon_choices,
			)
		);

		// Skill Custom Image / Badge
		$wp_customize->add_setting(
			"skill_{$i}_image",
			array(
				'default'           => '',
				'sanitize_callback' => 'esc_url_raw',
			)
		);
		$wp_customize->add_control(
			new WP_Customize_Image_Control(
				$wp_customize,
				"skill_{$i}_image",
				array(
					'label'       => sprintf( __( 'Skill #%d: Custom Image / Icon (Optional)', 'ross-portfolio' ), $i ),
					'description' => __( 'Upload a custom PNG/SVG image icon to override the default SVG icon.', 'ross-portfolio' ),
					'section'     => 'ross_portfolio_skills_section',
				)
			)
		);
	}

	// Section 6: Featured Portfolio Projects Section
	$wp_customize->add_section(
		'ross_portfolio_projects_section',
		array(
			'title'       => __( 'Homepage: Featured Projects Section', 'ross-portfolio' ),
			'panel'       => 'ross_portfolio_panel',
			'priority'    => 40,
			'description' => __( 'Manage section headings and project count displayed on the homepage.', 'ross-portfolio' ),
		)
	);

	$wp_customize->add_setting(
		'projects_section_tag',
		array(
			'default'           => 'Featured Work',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'projects_section_tag',
		array(
			'label'   => __( 'Section Tag / Badge', 'ross-portfolio' ),
			'section' => 'ross_portfolio_projects_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'projects_section_title',
		array(
			'default'           => 'Engineered Case Studies',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'projects_section_title',
		array(
			'label'   => __( 'Section Title', 'ross-portfolio' ),
			'section' => 'ross_portfolio_projects_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'projects_count',
		array(
			'default'           => 6,
			'sanitize_callback' => 'absint',
		)
	);
	$wp_customize->add_control(
		'projects_count',
		array(
			'label'   => __( 'Number of Projects to Display', 'ross-portfolio' ),
			'section' => 'ross_portfolio_projects_section',
			'type'    => 'number',
		)
	);

	$wp_customize->add_setting(
		'projects_empty_text',
		array(
			'default'           => 'No portfolio projects found.',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'projects_empty_text',
		array(
			'label'   => __( 'Empty State Text', 'ross-portfolio' ),
			'section' => 'ross_portfolio_projects_section',
			'type'    => 'text',
		)
	);

	// Section 7: The Best High-Converting Standout Call To Action (CTA) Section
	$wp_customize->add_section(
		'ross_portfolio_standout_cta_section',
		array(
			'title'       => __( 'Homepage: Standout Call To Action (Best CTA)', 'ross-portfolio' ),
			'panel'       => 'ross_portfolio_panel',
			'priority'    => 42,
			'description' => __( 'Configure the standout, high-converting Call To Action banner featured on the homepage.', 'ross-portfolio' ),
		)
	);

	$wp_customize->add_setting(
		'standout_cta_tag',
		array(
			'default'           => 'Ready to Scale?',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'standout_cta_tag',
		array(
			'label'   => __( 'CTA Badge / Pill Tag', 'ross-portfolio' ),
			'section' => 'ross_portfolio_standout_cta_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'standout_cta_heading',
		array(
			'default'           => 'Transform Your Web Architecture into a High-Converting Engine',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'standout_cta_heading',
		array(
			'label'   => __( 'CTA Main Headline', 'ross-portfolio' ),
			'section' => 'ross_portfolio_standout_cta_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'standout_cta_desc',
		array(
			'default'           => 'Stop losing revenue and users to bloated plugins and sluggish load times. Partner directly with an elite frontend architect to build custom, ultra-fast WordPress applications.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'standout_cta_desc',
		array(
			'label'   => __( 'CTA Subtitle / Value Proposition', 'ross-portfolio' ),
			'section' => 'ross_portfolio_standout_cta_section',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'standout_cta_primary_btn_text',
		array(
			'default'           => 'Schedule Architecture Review',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'standout_cta_primary_btn_text',
		array(
			'label'   => __( 'Primary CTA Button Text', 'ross-portfolio' ),
			'section' => 'ross_portfolio_standout_cta_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'standout_cta_primary_btn_url',
		array(
			'default'           => '#contact',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'standout_cta_primary_btn_url',
		array(
			'label'   => __( 'Primary CTA Button URL', 'ross-portfolio' ),
			'section' => 'ross_portfolio_standout_cta_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'standout_cta_secondary_btn_text',
		array(
			'default'           => 'Explore Case Studies',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'standout_cta_secondary_btn_text',
		array(
			'label'   => __( 'Secondary CTA Button Text', 'ross-portfolio' ),
			'section' => 'ross_portfolio_standout_cta_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'standout_cta_secondary_btn_url',
		array(
			'default'           => '#projects',
			'sanitize_callback' => 'esc_url_raw',
		)
	);
	$wp_customize->add_control(
		'standout_cta_secondary_btn_url',
		array(
			'label'   => __( 'Secondary CTA Button URL', 'ross-portfolio' ),
			'section' => 'ross_portfolio_standout_cta_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'standout_cta_trust_note',
		array(
			'default'           => 'Guaranteed 95+ Core Web Vitals score • Strict WCAG 2.2 AA accessibility • Zero dependency guarantee',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'standout_cta_trust_note',
		array(
			'label'   => __( 'Trust Badges / Guarantee Note', 'ross-portfolio' ),
			'section' => 'ross_portfolio_standout_cta_section',
			'type'    => 'text',
		)
	);

	// Section 8: Direct Contact Showcase Section
	$wp_customize->add_section(
		'ross_portfolio_contact_section',
		array(
			'title'       => __( 'Homepage: Direct Contact Showcase Section', 'ross-portfolio' ),
			'panel'       => 'ross_portfolio_panel',
			'priority'    => 45,
			'description' => __( 'Manage all headings, copy, and buttons for the homepage direct contact showcase.', 'ross-portfolio' ),
		)
	);

	$wp_customize->add_setting(
		'contact_section_tag',
		array(
			'default'           => 'Initiate Contact',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'contact_section_tag',
		array(
			'label'   => __( 'Section Tag / Badge', 'ross-portfolio' ),
			'section' => 'ross_portfolio_contact_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'contact_section_headline',
		array(
			'default'           => "Let's Architect Something Exceptional Together",
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'contact_section_headline',
		array(
			'label'   => __( 'Section Headline', 'ross-portfolio' ),
			'section' => 'ross_portfolio_contact_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'contact_section_desc',
		array(
			'default'           => 'Available for technical consultations, bespoke WordPress theme engineering, performance optimizations, and accessible enterprise design systems.',
			'sanitize_callback' => 'sanitize_textarea_field',
		)
	);
	$wp_customize->add_control(
		'contact_section_desc',
		array(
			'label'   => __( 'Section Description / Copy', 'ross-portfolio' ),
			'section' => 'ross_portfolio_contact_section',
			'type'    => 'textarea',
		)
	);

	$wp_customize->add_setting(
		'contact_email_btn_text',
		array(
			'default'           => 'Send Direct Email',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'contact_email_btn_text',
		array(
			'label'   => __( 'Email Button Text', 'ross-portfolio' ),
			'section' => 'ross_portfolio_contact_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'contact_phone_btn_text',
		array(
			'default'           => 'Call Direct',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'contact_phone_btn_text',
		array(
			'label'   => __( 'Phone Button Text', 'ross-portfolio' ),
			'section' => 'ross_portfolio_contact_section',
			'type'    => 'text',
		)
	);

	// Section 9: FAQ Accordion Section (No JSON, 4 Individual Question & Answer Controls)
	$wp_customize->add_section(
		'ross_portfolio_faq_section',
		array(
			'title'       => __( 'Homepage: FAQ Accordion Section', 'ross-portfolio' ),
			'panel'       => 'ross_portfolio_panel',
			'priority'    => 50,
			'description' => __( 'Manage FAQ section titles and questions directly with text controls (no JSON required).', 'ross-portfolio' ),
		)
	);

	$wp_customize->add_setting(
		'faq_section_tag',
		array(
			'default'           => 'FAQ',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'faq_section_tag',
		array(
			'label'   => __( 'Section Tag / Badge', 'ross-portfolio' ),
			'section' => 'ross_portfolio_faq_section',
			'type'    => 'text',
		)
	);

	$wp_customize->add_setting(
		'faq_section_title',
		array(
			'default'           => 'Frequently Asked Questions',
			'sanitize_callback' => 'sanitize_text_field',
		)
	);
	$wp_customize->add_control(
		'faq_section_title',
		array(
			'label'   => __( 'Section Title', 'ross-portfolio' ),
			'section' => 'ross_portfolio_faq_section',
			'type'    => 'text',
		)
	);

	$default_faqs = array(
		1 => array(
			'q' => 'How is high performance achieved without external dependencies?',
			'a' => 'By utilizing native browser features, CSS custom properties, system font stacks, and zero external JS/CSS libraries. Assets are lightweight and render-blocking requests are completely avoided.',
		),
		2 => array(
			'q' => 'Is this theme fully WCAG 2.2 AA accessible?',
			'a' => 'Yes. It features explicit focus management, full keyboard navigation traps for mobile menus, clear :focus-visible indicators, skip navigation links, and sufficient color contrast.',
		),
		3 => array(
			'q' => 'Can page content and profile details be edited without coding?',
			'a' => 'Absolutely. All owner profile details, social links, hero headlines, skills, call to action, and FAQ items are manageable via native WordPress Customizer controls.',
		),
		4 => array(
			'q' => 'Does this theme support WordPress Gutenberg blocks?',
			'a' => 'Yes. Full block alignment, editor stylesheets, and native color palette tokens are specified via theme.json and setup.php.',
		),
	);

	for ( $j = 1; $j <= 4; $j++ ) {
		$wp_customize->add_setting(
			"faq_{$j}_question",
			array(
				'default'           => $default_faqs[ $j ]['q'],
				'sanitize_callback' => 'sanitize_text_field',
			)
		);
		$wp_customize->add_control(
			"faq_{$j}_question",
			array(
				'label'   => sprintf( __( 'FAQ #%d: Question', 'ross-portfolio' ), $j ),
				'section' => 'ross_portfolio_faq_section',
				'type'    => 'text',
			)
		);

		$wp_customize->add_setting(
			"faq_{$j}_answer",
			array(
				'default'           => $default_faqs[ $j ]['a'],
				'sanitize_callback' => 'sanitize_textarea_field',
			)
		);
		$wp_customize->add_control(
			"faq_{$j}_answer",
			array(
				'label'   => sprintf( __( 'FAQ #%d: Answer', 'ross-portfolio' ), $j ),
				'section' => 'ross_portfolio_faq_section',
				'type'    => 'textarea',
			)
		);
	}
}
/**
 * Strict select sanitizer callback validating against control choices.
 *
 * @param string               $input   User input value.
 * @param WP_Customize_Setting $setting Setting instance.
 * @return string Sanitized input or default if invalid.
 */
function ross_portfolio_sanitize_select( $input, $setting ) {
	$input   = sanitize_key( $input );
	$control = $setting->manager->get_control( $setting->id );
	if ( $control && array_key_exists( $input, $control->choices ) ) {
		return $input;
	}
	return $setting->default;
}

add_action( 'customize_register', 'ross_portfolio_customize_register' );
