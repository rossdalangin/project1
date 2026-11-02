<?php
/**
 * Theme Enqueue Scripts, Styles and Dynamic Presets
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function ross_portfolio_scripts() {
	wp_enqueue_style(
		'ross-portfolio-style',
		get_stylesheet_uri(),
		array(),
		ROSS_PORTFOLIO_VERSION
	);

	// Inject dynamic style preset CSS variables
	$chosen_preset = ross_portfolio_get_option( 'theme_style_preset', 'obsidian-cyber' );
	$presets       = ross_portfolio_get_style_presets();

	if ( isset( $presets[ $chosen_preset ] ) ) {
		$preset = $presets[ $chosen_preset ];
		$custom_css = "
		:root {
			--bg-dark: {$preset['bg_dark']};
			--bg-gradient-1: {$preset['bg_gradient_1']};
			--bg-gradient-2: {$preset['bg_gradient_2']};
			--surface-glass: {$preset['surface_glass']};
			--accent-blue: {$preset['accent_blue']};
			--accent-blue-hover: {$preset['accent_blue_hover']};
			--accent-emerald: {$preset['accent_emerald']};
		}";
		wp_add_inline_style( 'ross-portfolio-style', $custom_css );
	}

	wp_enqueue_script(
		'ross-portfolio-navigation',
		ROSS_PORTFOLIO_URI . '/assets/js/navigation.js',
		array(),
		ROSS_PORTFOLIO_VERSION,
		true
	);

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'ross_portfolio_scripts' );
