<?php
/**
 * SEO, AEO (Answer Engine Optimization), GEO (Generative Engine Optimization) & JSON-LD Module
 *
 * Provides comprehensive meta tags, OpenGraph, Twitter Cards, canonical links,
 * and structured JSON-LD schemas (Person, ProfilePage, FAQPage, Article)
 * to maximize visibility across search engines, AI answer engines (ChatGPT, Perplexity, Claude),
 * and generative knowledge graphs.
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Output SEO, AEO & GEO Meta Tags in wp_head
 */
function ross_portfolio_seo_meta_tags() {
	$profile     = ross_portfolio_get_profile_details();
	$site_name   = get_bloginfo( 'name' );
	$description = '';
	$title       = '';
	$url         = '';
	$image       = ! empty( $profile['avatar_url'] ) ? $profile['avatar_url'] : '';

	if ( is_front_page() || is_home() ) {
		$title       = $profile['display_name'] . ' - ' . $profile['title'];
		$description = wp_strip_all_tags( $profile['bio'] );
		$url         = home_url( '/' );
	} elseif ( is_singular() ) {
		$title       = get_the_title() . ' - ' . $site_name;
		$description = has_excerpt() ? wp_strip_all_tags( get_the_excerpt() ) : wp_strip_all_tags( wp_trim_words( get_the_content(), 30 ) );
		$url         = get_permalink();
		if ( has_post_thumbnail() ) {
			$image = get_the_post_thumbnail_url( get_the_ID(), 'large' );
		}
	} else {
		$title       = wp_get_document_title();
		$description = wp_strip_all_tags( get_bloginfo( 'description' ) );
		$url         = home_url( $_SERVER['REQUEST_URI'] ?? '/' );
	}

	if ( empty( $description ) ) {
		$description = wp_strip_all_tags( $profile['bio'] );
	}

	?>
	<!-- SEO / Meta Tags -->
	<meta name="description" content="<?php echo esc_attr( $description ); ?>">
	<link rel="canonical" href="<?php echo esc_url( $url ); ?>">
	<meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">

	<!-- AEO & GEO Knowledge Graph Helpers -->
	<meta name="author" content="<?php echo esc_attr( $profile['display_name'] ); ?>">
	<meta name="geo.region" content="US">
	<?php if ( ! empty( $profile['location'] ) ) : ?>
		<meta name="geo.placename" content="<?php echo esc_attr( $profile['location'] ); ?>">
	<?php endif; ?>

	<!-- OpenGraph / Facebook -->
	<meta property="og:locale" content="<?php echo esc_attr( get_locale() ); ?>">
	<meta property="og:type" content="<?php echo is_singular() ? 'article' : 'profile'; ?>">
	<meta property="og:title" content="<?php echo esc_attr( $title ); ?>">
	<meta property="og:description" content="<?php echo esc_attr( $description ); ?>">
	<meta property="og:url" content="<?php echo esc_url( $url ); ?>">
	<meta property="og:site_name" content="<?php echo esc_attr( $site_name ); ?>">
	<?php if ( ! empty( $image ) ) : ?>
		<meta property="og:image" content="<?php echo esc_url( $image ); ?>">
	<?php endif; ?>

	<!-- Twitter Cards -->
	<meta name="twitter:card" content="summary_large_image">
	<meta name="twitter:title" content="<?php echo esc_attr( $title ); ?>">
	<meta name="twitter:description" content="<?php echo esc_attr( $description ); ?>">
	<?php if ( ! empty( $image ) ) : ?>
		<meta name="twitter:image" content="<?php echo esc_url( $image ); ?>">
	<?php endif; ?>
	<?php
}
add_action( 'wp_head', 'ross_portfolio_seo_meta_tags', 1 );

/**
 * Output JSON-LD Structured Data Schema for Person, ProfilePage, FAQPage, & Article
 */
function ross_portfolio_json_ld_schema() {
	$profile = ross_portfolio_get_profile_details();
	$faqs    = ross_portfolio_get_faqs();

	// Social Links Array for sameAs
	$same_as = array_values(
		array_filter(
			array(
				$profile['github'],
				$profile['linkedin'],
				$profile['twitter'],
			)
		)
	);

	// Base Person / Profile Schema
	$person_schema = array(
		'@context'     => 'https://schema.org',
		'@type'        => 'Person',
		'@id'          => home_url( '/#person' ),
		'name'         => $profile['display_name'],
		'jobTitle'     => $profile['title'],
		'description'  => wp_strip_all_tags( $profile['bio'] ),
		'url'          => home_url( '/' ),
		'sameAs'       => $same_as,
		'workLocation' => array(
			'@type' => 'Place',
			'name'  => $profile['location'],
		),
		'knowsAbout'   => array(
			'WordPress Theme Engineering',
			'Front-End Web Performance',
			'Web Accessibility (WCAG 2.2 AA)',
			'Glassmorphic Design Systems',
			'Zero-Dependency Web Architectures',
			'Search Engine Optimization (SEO)',
			'Answer Engine Optimization (AEO)',
			'Generative Engine Optimization (GEO)',
		),
	);

	if ( ! empty( $profile['avatar_url'] ) ) {
		$person_schema['image'] = $profile['avatar_url'];
	}

	if ( ! empty( $profile['email'] ) ) {
		$person_schema['email'] = 'mailto:' . $profile['email'];
	}

	$schemas = array();

	if ( is_front_page() || is_home() ) {
		// ProfilePage Schema
		$profile_page_schema = array(
			'@context'   => 'https://schema.org',
			'@type'      => 'ProfilePage',
			'mainEntity' => array(
				'@id' => home_url( '/#person' ),
			),
			'name'       => $profile['display_name'] . ' - Portfolio',
			'url'        => home_url( '/' ),
		);

		$schemas[] = $person_schema;
		$schemas[] = $profile_page_schema;

		// FAQPage Schema for AEO
		if ( ! empty( $faqs ) ) {
			$faq_items = array();
			foreach ( $faqs as $faq ) {
				if ( ! empty( $faq['question'] ) && ! empty( $faq['answer'] ) ) {
					$faq_items[] = array(
						'@type'          => 'Question',
						'name'           => $faq['question'],
						'acceptedAnswer' => array(
							'@type' => 'Answer',
							'text'  => $faq['answer'],
						),
					);
				}
			}

			if ( ! empty( $faq_items ) ) {
				$schemas[] = array(
					'@context'   => 'https://schema.org',
					'@type'      => 'FAQPage',
					'mainEntity' => $faq_items,
				);
			}
		}
	} elseif ( is_singular( 'post' ) ) {
		// Article / BlogPosting Schema
		global $post;
		$schemas[] = $person_schema;
		$article_schema = array(
			'@context'         => 'https://schema.org',
			'@type'            => 'BlogPosting',
			'headline'         => get_the_title(),
			'description'      => has_excerpt() ? wp_strip_all_tags( get_the_excerpt() ) : wp_strip_all_tags( wp_trim_words( get_the_content(), 30 ) ),
			'url'              => get_permalink(),
			'datePublished'    => get_the_date( 'c' ),
			'dateModified'     => get_the_modified_date( 'c' ),
			'author'           => array(
				'@type' => 'Person',
				'name'  => get_the_author(),
				'@id'   => home_url( '/#person' ),
			),
			'publisher'        => array(
				'@type' => 'Person',
				'name'  => $profile['display_name'],
			),
			'mainEntityOfPage' => array(
				'@type' => 'WebPage',
				'@id'   => get_permalink(),
			),
		);

		if ( has_post_thumbnail() ) {
			$article_schema['image'] = get_the_post_thumbnail_url( get_the_ID(), 'full' );
		}

		$schemas[] = $article_schema;
	} else {
		$schemas[] = $person_schema;
	}

	// Output encoded JSON-LD
	echo '<script type="application/ld+json">' . wp_json_encode( $schemas, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT ) . '</script>' . "\n";
}
add_action( 'wp_head', 'ross_portfolio_json_ld_schema', 2 );
