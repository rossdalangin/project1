<?php
/**
 * Helper Functions and Customizer Getters
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

function ross_portfolio_get_option( $setting_id, $default = '' ) {
	$value = get_theme_mod( $setting_id, $default );
	return ! empty( $value ) ? $value : $default;
}

function ross_portfolio_get_profile_details() {
	return array(
		'display_name'   => ross_portfolio_get_option( 'profile_display_name', 'Ross' ),
		'title'          => ross_portfolio_get_option( 'profile_title', 'Principal Theme Architect & Front-End Performance Lead' ),
		'location'       => ross_portfolio_get_option( 'profile_location', 'San Francisco, CA' ),
		'email'          => ross_portfolio_get_option( 'profile_email', 'ross@example.com' ),
		'github'         => ross_portfolio_get_option( 'profile_github', 'https://github.com' ),
		'linkedin'       => ross_portfolio_get_option( 'profile_linkedin', 'https://linkedin.com' ),
		'twitter'        => ross_portfolio_get_option( 'profile_twitter', 'https://twitter.com' ),
		'avatar_url'     => ross_portfolio_get_option( 'profile_avatar_url', '' ),
		'bio'            => ross_portfolio_get_option( 'profile_bio', 'Passionate software engineer focused on ultra-performant, accessible web architectures, custom WordPress systems, and modern glassmorphism design.' ),
		'hero_headline'  => ross_portfolio_get_option( 'hero_headline', 'Building Modern, Performant Digital Experiences' ),
		'hero_subhead'   => ross_portfolio_get_option( 'hero_subhead', 'Classic WordPress engineering without bloated plugins or dependencies.' ),
		'hero_cta_text'  => ross_portfolio_get_option( 'hero_cta_text', 'View Portfolio Projects' ),
		'hero_cta_url'   => ross_portfolio_get_option( 'hero_cta_url', '#projects' ),
	);
}

function ross_portfolio_get_faqs() {
	$faqs_json = get_theme_mod( 'portfolio_faqs_json', '' );
	if ( ! empty( $faqs_json ) ) {
		$decoded = json_decode( $faqs_json, true );
		if ( is_array( $decoded ) && ! empty( $decoded ) ) {
			return $decoded;
		}
	}

	return array(
		array(
			'question' => 'How is high performance achieved without external dependencies?',
			'answer'   => 'By utilizing native browser features, CSS custom properties, system font stacks, and zero external JS/CSS libraries. Assets are lightweight and render-blocking requests are completely avoided.',
		),
		array(
			'question' => 'Is this theme fully WCAG 2.2 AA accessible?',
			'answer'   => 'Yes. It features explicit focus management, full keyboard navigation traps for mobile menus, clear :focus-visible indicators, skip navigation links, and sufficient color contrast.',
		),
		array(
			'question' => 'Can page content and profile details be edited without coding?',
			'answer'   => 'Absolutely. All owner profile details, social links, hero headlines, and FAQ items are manageable via native WordPress Customizer controls.',
		),
		array(
			'question' => 'Does this theme support WordPress Gutenberg blocks?',
			'answer'   => 'Yes. Full block alignment, editor stylesheets, and native color palette tokens are specified via theme.json and setup.php.',
		),
	);
}

/**
 * Return allowed SVG tags for wp_kses.
 *
 * @return array
 */
function ross_portfolio_get_allowed_svg_tags() {
	return array(
		'svg'      => array(
			'width'       => true,
			'height'      => true,
			'viewbox'     => true,
			'fill'        => true,
			'stroke'      => true,
			'stroke-width' => true,
			'stroke-linecap' => true,
			'stroke-linejoin' => true,
			'aria-hidden' => true,
			'class'       => true,
		),
		'path'     => array(
			'd' => true,
		),
		'rect'     => array(
			'x'      => true,
			'y'      => true,
			'width'  => true,
			'height' => true,
			'rx'     => true,
			'ry'     => true,
		),
		'circle'   => array(
			'cx' => true,
			'cy' => true,
			'r'  => true,
		),
		'line'     => array(
			'x1' => true,
			'y1' => true,
			'x2' => true,
			'y2' => true,
		),
		'polyline' => array(
			'points' => true,
		),
	);
}

/**
 * Sanitize and output Social Media SVG
 *
 * @param string $service
 * @return string Safe SVG markup
 */
function ross_portfolio_get_social_svg( $service ) {
	$raw_svg = '';
	switch ( strtolower( $service ) ) {
		case 'github':
			$raw_svg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>';
			break;
		case 'linkedin':
			$raw_svg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>';
			break;
		case 'twitter':
		case 'x':
			$raw_svg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>';
			break;
		case 'email':
			$raw_svg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>';
			break;
		default:
			$raw_svg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>';
			break;
	}

	return wp_kses( $raw_svg, ross_portfolio_get_allowed_svg_tags() );
}
