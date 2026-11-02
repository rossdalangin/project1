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

/**
 * Get Available Color Presets
 *
 * @return array
 */
function ross_portfolio_get_style_presets() {
	return array(
		'obsidian-cyber' => array(
			'name'            => __( 'Obsidian Cyber (Default Electric Blue & Emerald)', 'ross-portfolio' ),
			'bg_dark'         => '#070A0E',
			'bg_gradient_1'   => 'rgba(96, 165, 250, 0.08)',
			'bg_gradient_2'   => 'rgba(52, 211, 153, 0.05)',
			'surface_glass'   => 'rgba(18, 25, 35, 0.65)',
			'accent_blue'     => '#60A5FA',
			'accent_blue_hover' => '#3B82F6',
			'accent_emerald'  => '#34D399',
		),
		'midnight-violet' => array(
			'name'            => __( 'Midnight Violet & Neon Cyan', 'ross-portfolio' ),
			'bg_dark'         => '#0B0A12',
			'bg_gradient_1'   => 'rgba(168, 85, 247, 0.10)',
			'bg_gradient_2'   => 'rgba(56, 189, 248, 0.06)',
			'surface_glass'   => 'rgba(23, 19, 36, 0.70)',
			'accent_blue'     => '#A855F7',
			'accent_blue_hover' => '#9333EA',
			'accent_emerald'  => '#38BDF8',
		),
		'emerald-matrix' => array(
			'name'            => __( 'Emerald Matrix & Forest Glass', 'ross-portfolio' ),
			'bg_dark'         => '#05100B',
			'bg_gradient_1'   => 'rgba(16, 185, 129, 0.10)',
			'bg_gradient_2'   => 'rgba(110, 231, 183, 0.05)',
			'surface_glass'   => 'rgba(11, 28, 20, 0.70)',
			'accent_blue'     => '#10B981',
			'accent_blue_hover' => '#059669',
			'accent_emerald'  => '#6EE7B7',
		),
		'sunset-ember' => array(
			'name'            => __( 'Sunset Ember & Cyberpunk Orange', 'ross-portfolio' ),
			'bg_dark'         => '#0F0C0B',
			'bg_gradient_1'   => 'rgba(249, 115, 22, 0.10)',
			'bg_gradient_2'   => 'rgba(251, 113, 133, 0.06)',
			'surface_glass'   => 'rgba(30, 20, 18, 0.70)',
			'accent_blue'     => '#F97316',
			'accent_blue_hover' => '#EA580C',
			'accent_emerald'  => '#FB7185',
		),
		'royal-indigo' => array(
			'name'            => __( 'Royal Indigo & Cobalt Glow', 'ross-portfolio' ),
			'bg_dark'         => '#080B16',
			'bg_gradient_1'   => 'rgba(99, 102, 241, 0.10)',
			'bg_gradient_2'   => 'rgba(56, 189, 248, 0.06)',
			'surface_glass'   => 'rgba(17, 22, 42, 0.70)',
			'accent_blue'     => '#6366F1',
			'accent_blue_hover' => '#4F46E5',
			'accent_emerald'  => '#38BDF8',
		),
		'minimal-titanium' => array(
			'name'            => __( 'Minimal Titanium & Frosted Silver', 'ross-portfolio' ),
			'bg_dark'         => '#0D0E10',
			'bg_gradient_1'   => 'rgba(226, 232, 240, 0.07)',
			'bg_gradient_2'   => 'rgba(96, 165, 250, 0.05)',
			'surface_glass'   => 'rgba(24, 26, 31, 0.75)',
			'accent_blue'     => '#E2E8F0',
			'accent_blue_hover' => '#CBD5E1',
			'accent_emerald'  => '#60A5FA',
		),
	);
}

function ross_portfolio_get_profile_details() {
	return array(
		'display_name'           => ross_portfolio_get_option( 'profile_display_name', 'Ross' ),
		'title'                  => ross_portfolio_get_option( 'profile_title', 'Principal Theme Architect & Front-End Performance Lead' ),
		'location'               => ross_portfolio_get_option( 'profile_location', 'San Francisco, CA' ),
		'email'                  => ross_portfolio_get_option( 'profile_email', 'ross@example.com' ),
		'phone'                  => ross_portfolio_get_option( 'profile_phone', '+1 (555) 019-2834' ),
		'github'                 => ross_portfolio_get_option( 'profile_github', 'https://github.com' ),
		'linkedin'               => ross_portfolio_get_option( 'profile_linkedin', 'https://linkedin.com' ),
		'twitter'                => ross_portfolio_get_option( 'profile_twitter', 'https://twitter.com' ),
		'avatar_url'             => ross_portfolio_get_option( 'profile_avatar_url', '' ),
		'bio'                    => ross_portfolio_get_option( 'profile_bio', 'Passionate software engineer focused on ultra-performant, accessible web architectures, custom WordPress systems, and modern glassmorphism design.' ),
		'hero_badge_text'        => ross_portfolio_get_option( 'hero_badge_text', 'Available for Q1 / Q2 Contracts & Architecture Advisory' ),
		'hero_headline'          => ross_portfolio_get_option( 'hero_headline', 'Building Modern, Performant Digital Experiences' ),
		'hero_subhead'           => ross_portfolio_get_option( 'hero_subhead', 'Classic WordPress engineering without bloated plugins or dependencies.' ),
		'hero_cta_text'          => ross_portfolio_get_option( 'hero_cta_text', 'View Portfolio Projects' ),
		'hero_cta_url'           => ross_portfolio_get_option( 'hero_cta_url', '#projects' ),
		'hero_secondary_cta_text'=> ross_portfolio_get_option( 'hero_secondary_cta_text', 'Get in Touch' ),
		'hero_secondary_cta_url' => ross_portfolio_get_option( 'hero_secondary_cta_url', '#contact' ),
		'header_cta_text'        => ross_portfolio_get_option( 'header_cta_text', "Let's Talk" ),
		'header_cta_url'         => ross_portfolio_get_option( 'header_cta_url', '#contact' ),
		'style_preset'           => ross_portfolio_get_option( 'theme_style_preset', 'obsidian-cyber' ),
	);
}

/**
 * Get Skills Section Configuration and List
 */
function ross_portfolio_get_skills() {
	$skills_json = get_theme_mod( 'portfolio_skills_json', '' );
	if ( ! empty( $skills_json ) ) {
		$decoded = json_decode( $skills_json, true );
		if ( is_array( $decoded ) && ! empty( $decoded ) ) {
			return $decoded;
		}
	}

	return array(
		array(
			'icon'  => 'terminal',
			'title' => __( 'Zero-Dependency Vanilla JS', 'ross-portfolio' ),
			'desc'  => __( 'Pure ES6+ JavaScript engineered for maximum execution speed, zero third-party dependencies, and zero render-blocking assets.', 'ross-portfolio' ),
		),
		array(
			'icon'  => 'bolt',
			'title' => __( '100/100 Core Web Vitals', 'ross-portfolio' ),
			'desc'  => __( 'Native system font stacks, optimized critical CSS rendering, zero layout shift (CLS), and sub-100ms Largest Contentful Paint (LCP).', 'ross-portfolio' ),
		),
		array(
			'icon'  => 'target',
			'title' => __( 'WCAG 2.2 AA Accessibility', 'ross-portfolio' ),
			'desc'  => __( 'Full keyboard focus trapping, ARIA live regions, explicit :focus-visible outlines, and screen reader semantic landmarks.', 'ross-portfolio' ),
		),
		array(
			'icon'  => 'shield',
			'title' => __( 'Enterprise Security', 'ross-portfolio' ),
			'desc'  => __( 'Strict ABSPATH protection, comprehensive sanitization, SVG whitelisting, and strict security HTTP headers.', 'ross-portfolio' ),
		),
		array(
			'icon'  => 'search',
			'title' => __( 'AEO & GEO Optimization', 'ross-portfolio' ),
			'desc'  => __( 'Deep JSON-LD structured schema integration for AI answer engines (Perplexity, ChatGPT) and search graphs.', 'ross-portfolio' ),
		),
		array(
			'icon'  => 'layers',
			'title' => __( 'Modern Glassmorphism UI', 'ross-portfolio' ),
			'desc'  => __( 'Multi-layered backdrop-filters, subtle high-contrast borders, ambient radial glows, and 6 curated color themes.', 'ross-portfolio' ),
		),
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

function ross_portfolio_get_allowed_svg_tags() {
	return array(
		'svg'      => array(
			'width'          => true,
			'height'         => true,
			'viewbox'        => true,
			'fill'           => true,
			'stroke'         => true,
			'stroke-width'   => true,
			'stroke-linecap' => true,
			'stroke-linejoin'=> true,
			'aria-hidden'    => true,
			'class'          => true,
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

function ross_portfolio_get_icon_svg( $icon ) {
	$raw_svg = '';
	switch ( strtolower( $icon ) ) {
		case 'terminal':
			$raw_svg = '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="4 17 10 11 4 5"></polyline><line x1="12" y1="19" x2="20" y2="19"></line></svg>';
			break;
		case 'bolt':
			$raw_svg = '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="13 2 3 14 12 14 11 22 21 10 12 10 13 2"></polygon></svg>';
			break;
		case 'target':
			$raw_svg = '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><circle cx="12" cy="12" r="6"></circle><circle cx="12" cy="12" r="2"></circle></svg>';
			break;
		case 'shield':
			$raw_svg = '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>';
			break;
		case 'search':
			$raw_svg = '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>';
			break;
		case 'layers':
		default:
			$raw_svg = '<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>';
			break;
	}

	return wp_kses( $raw_svg, ross_portfolio_get_allowed_svg_tags() );
}

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
		case 'phone':
			$raw_svg = '<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>';
			break;
		default:
			$raw_svg = '<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>';
			break;
	}

	return wp_kses( $raw_svg, ross_portfolio_get_allowed_svg_tags() );
}
