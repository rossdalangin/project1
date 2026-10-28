<?php
/**
 * Theme Setup Configuration & Security Hardening Hooks
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( ! function_exists( 'ross_portfolio_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 */
	function ross_portfolio_setup() {
		load_theme_textdomain( 'ross-portfolio', get_template_directory() . '/languages' );
		add_theme_support( 'automatic-feed-links' );
		add_theme_support( 'title-tag' );
		add_theme_support( 'post-thumbnails' );
		set_post_thumbnail_size( 800, 450, true );

		register_nav_menus(
			array(
				'primary' => esc_html__( 'Primary Menu', 'ross-portfolio' ),
				'footer'  => esc_html__( 'Footer Menu', 'ross-portfolio' ),
			)
		);

		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		add_theme_support(
			'custom-logo',
			array(
				'height'      => 100,
				'width'       => 100,
				'flex-width'  => true,
				'flex-height' => true,
			)
		);

		add_theme_support( 'customize-selective-refresh-widgets' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'editor-styles' );
	}
endif;
add_action( 'after_setup_theme', 'ross_portfolio_setup' );

/**
 * Security Hardening: Remove WP version generator and discovery tags.
 */
function ross_portfolio_security_cleanup() {
	// Remove WordPress generator version tag from wp_head and RSS feeds
	remove_action( 'wp_head', 'wp_generator' );

	// Remove Really Simple Discovery (RSD) link tag
	remove_action( 'wp_head', 'rsd_link' );

	// Remove Windows Live Writer manifest link tag
	remove_action( 'wp_head', 'wlwmanifest_link' );

	// Remove shortlink tag
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );
}
add_action( 'init', 'ross_portfolio_security_cleanup' );

/**
 * Security Hardening: Add Security HTTP Headers
 */
function ross_portfolio_add_security_headers() {
	if ( ! is_admin() ) {
		header( 'X-Content-Type-Options: nosniff' );
		header( 'X-Frame-Options: SAMEORIGIN' );
		header( 'X-XSS-Protection: 1; mode=block' );
		header( 'Referrer-Policy: strict-origin-when-cross-origin' );
	}
}
add_action( 'send_headers', 'ross_portfolio_add_security_headers' );
