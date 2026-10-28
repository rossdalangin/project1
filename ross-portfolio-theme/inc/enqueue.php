<?php
/**
 * Theme Enqueue Scripts and Styles
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
