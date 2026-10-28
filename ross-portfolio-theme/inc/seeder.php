<?php
/**
 * Theme Content & Settings Seeder
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Seed Theme Settings and Demo Content securely.
 */
function ross_portfolio_seed_content() {
	// Security check: only users with manage_options capability can execute content seeding.
	if ( is_admin() && ! current_user_can( 'manage_options' ) ) {
		return;
	}

	if ( get_option( 'ross_portfolio_seeded_v1' ) ) {
		return;
	}

	set_theme_mod( 'profile_display_name', 'Ross' );
	set_theme_mod( 'profile_title', 'Principal Theme Architect & Front-End Performance Lead' );
	set_theme_mod( 'profile_location', 'San Francisco, CA' );
	set_theme_mod( 'profile_email', 'ross@example.com' );
	set_theme_mod( 'profile_bio', 'Passionate software engineer focused on ultra-performant, accessible web architectures, custom WordPress systems, and modern glassmorphism design.' );
	set_theme_mod( 'hero_headline', 'Building Modern, Performant Digital Experiences' );
	set_theme_mod( 'hero_subhead', 'Classic WordPress engineering without bloated plugins or dependencies.' );
	set_theme_mod( 'hero_cta_text', 'View Portfolio Projects' );
	set_theme_mod( 'hero_cta_url', '#projects' );

	$demo_projects = array(
		array(
			'title'   => 'High-Speed Glassmorphism Engine',
			'content' => 'An enterprise WordPress framework delivering 100/100 Lighthouse performance scores without external dependencies or heavy scripts.',
			'excerpt' => 'Enterprise WP architecture with zero third-party dependencies and native dark mode glassmorphism.',
		),
		array(
			'title'   => 'Accessible Headless CMS Gateway',
			'content' => 'A decoupled content management pipeline built with WCAG 2.2 AA standards, automated keyboard focus traps, and screen reader optimizations.',
			'excerpt' => 'WCAG 2.2 AA compliant frontend gateway optimized for screen readers and keyboard navigation.',
		),
		array(
			'title'   => 'Zero-Dependency E-Commerce Core',
			'content' => 'A lightweight custom checkout architecture eliminating traditional plugin overhead and speeding up time-to-interactive by 300%.',
			'excerpt' => 'Ultra-fast checkout pipeline delivering instantaneous page rendering and reduced bounce rate.',
		),
	);

	foreach ( $demo_projects as $project ) {
		$existing = get_page_by_title( $project['title'], OBJECT, 'post' );
		if ( ! $existing ) {
			wp_insert_post(
				array(
					'post_title'   => $project['title'],
					'post_content' => $project['content'],
					'post_excerpt' => $project['excerpt'],
					'post_status'  => 'publish',
					'post_type'    => 'post',
				)
			);
		}
	}

	update_option( 'ross_portfolio_seeded_v1', true );
}
add_action( 'after_switch_theme', 'ross_portfolio_seed_content' );
add_action( 'admin_init', 'ross_portfolio_seed_content' );
