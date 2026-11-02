<?php
/**
 * Theme Setup Configuration, Sidebars & Security Hardening Hooks
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
 * Register Widget Areas / Sidebars
 */
function ross_portfolio_widgets_init() {
	register_sidebar(
		array(
			'name'          => esc_html__( 'Blog Right Sidebar', 'ross-portfolio' ),
			'id'            => 'sidebar-1',
			'description'   => esc_html__( 'Add widgets here to appear in the right sidebar of blog posts and blog archives.', 'ross-portfolio' ),
			'before_widget' => '<section id="%1$s" class="glass-card widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h3 class="widget-title">',
			'after_title'   => '</h3>',
		)
	);
}
add_action( 'widgets_init', 'ross_portfolio_widgets_init' );

/**
 * Security Hardening: Remove WP version generator, discovery tags, and disable pingbacks.
 */
function ross_portfolio_security_cleanup() {
	// Remove WordPress generator version tag from wp_head and RSS feeds
	remove_action( 'wp_head', 'wp_generator' );
	add_filter( 'the_generator', '__return_empty_string' );

	// Remove Really Simple Discovery (RSD) link tag
	remove_action( 'wp_head', 'rsd_link' );

	// Remove Windows Live Writer manifest link tag
	remove_action( 'wp_head', 'wlwmanifest_link' );

	// Remove shortlink tag
	remove_action( 'wp_head', 'wp_shortlink_wp_head' );

	// Disable XML-RPC pingback methods (common DDoS vector)
	add_filter(
		'xmlrpc_methods',
		function( $methods ) {
			unset( $methods['pingback.ping'] );
			unset( $methods['pingback.extensions.getPingbacks'] );
			return $methods;
		}
	);

	// Remove x-pingback HTTP header
	add_filter(
		'wp_headers',
		function( $headers ) {
			unset( $headers['X-Pingback'] );
			return $headers;
		}
	);
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
		header( 'Permissions-Policy: camera=(), microphone=(), geolocation=()' );
		header( 'X-Permitted-Cross-Domain-Policies: none' );
		header( 'Cross-Origin-Opener-Policy: same-origin' );
		header( 'Cross-Origin-Resource-Policy: same-origin' );
		if ( is_ssl() ) {
			header( 'Strict-Transport-Security: max-age=31536000; includeSubDomains; preload' );
		}
	}
}
add_action( 'send_headers', 'ross_portfolio_add_security_headers' );

/**
 * Security Hardening: Block User Enumeration via ?author=N queries
 */
function ross_portfolio_block_user_enumeration() {
	if ( ! is_admin() && isset( $_REQUEST['author'] ) && ( is_numeric( $_REQUEST['author'] ) || '' === $_REQUEST['author'] ) ) {
		wp_safe_redirect( home_url( '/' ), 301 );
		exit;
	}
}
add_action( 'template_redirect', 'ross_portfolio_block_user_enumeration' );

/**
 * Security Hardening: Block REST API User Enumeration
 * Restricts /wp/v2/users endpoints to authenticated administrators or users with 'list_users' capability.
 */
function ross_portfolio_restrict_rest_users( $endpoints ) {
	if ( ! is_user_logged_in() || ! current_user_can( 'list_users' ) ) {
		if ( isset( $endpoints['/wp/v2/users'] ) ) {
			unset( $endpoints['/wp/v2/users'] );
		}
		if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
			unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
		}
	}
	return $endpoints;
}
add_filter( 'rest_endpoints', 'ross_portfolio_restrict_rest_users' );

/**
 * Security Hardening: Obfuscate Login Errors to Prevent Username Harvesting
 */
function ross_portfolio_obfuscate_login_errors() {
	return esc_html__( 'Invalid username or password. Please try again.', 'ross-portfolio' );
}
add_filter( 'login_errors', 'ross_portfolio_obfuscate_login_errors' );

/**
 * Security Hardening: Disable Core XML User / Author Sitemaps
 * Prevents enumeration of administrative usernames via wp-sitemap-users-1.xml.
 */
function ross_portfolio_disable_users_sitemap( $provider, $name ) {
	if ( 'users' === $name ) {
		return false;
	}
	return $provider;
}
add_filter( 'wp_sitemaps_add_provider', 'ross_portfolio_disable_users_sitemap', 10, 2 );

/**
 * Security Hardening: Enforce Comment Length and Sanitization
 */
function ross_portfolio_limit_comment_length( $commentdata ) {
	// Restrict comment content length to prevent payload abuse
	if ( ! empty( $commentdata['comment_content'] ) && mb_strlen( $commentdata['comment_content'] ) > 4000 ) {
		wp_die( esc_html__( 'Error: Your comment is too long. Please limit your comment to 4,000 characters.', 'ross-portfolio' ), 400 );
	}
	return $commentdata;
}
add_filter( 'preprocess_comment', 'ross_portfolio_limit_comment_length' );

/**
 * Security Hardening: Sanitize Comment Links with rel="nofollow noopener noreferrer"
 */
function ross_portfolio_harden_comment_links( $text ) {
	return preg_replace_callback(
		'/<a\s+([^>]+)>/i',
		function( $matches ) {
			$attrs = $matches[1];
			// Remove any pre-existing rel attribute
			$attrs = preg_replace( '/\brel=([\'"])[^\'"]*\\1/i', '', $attrs );
			return '<a ' . trim( $attrs ) . ' rel="nofollow noopener noreferrer">';
		},
		$text
	);
}
add_filter( 'comment_text', 'ross_portfolio_harden_comment_links', 20 );
