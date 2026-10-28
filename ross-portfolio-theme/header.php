<?php
/**
 * Header Template
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$profile = ross_portfolio_get_profile_details();
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="profile" href="https://gmpg.org/xfn/11">
	<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<a class="skip-link screen-reader-text" href="#main-content">
	<?php esc_html_e( 'Skip to main content', 'ross-portfolio' ); ?>
</a>

<header id="masthead" class="site-header" itemscope itemtype="https://schema.org/WPHeader">
	<div class="header-container">
		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-branding" rel="home">
			<?php
			if ( has_custom_logo() ) {
				the_custom_logo();
			} else {
				?>
				<span class="site-title">
					<?php echo esc_html( $profile['display_name'] ); ?><span>.dev</span>
				</span>
				<?php
			}
			?>
		</a>

		<button id="primary-nav-toggle" class="nav-toggle" aria-controls="primary-nav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'ross-portfolio' ); ?>">
			<span></span>
			<span></span>
			<span></span>
		</button>

		<nav id="primary-nav" class="primary-nav" aria-label="<?php esc_attr_e( 'Primary Menu', 'ross-portfolio' ); ?>" itemscope itemtype="https://schema.org/SiteNavigationElement">
			<?php
			if ( has_nav_menu( 'primary' ) ) {
				wp_nav_menu(
					array(
						'theme_location' => 'primary',
						'menu_id'        => 'primary-menu',
						'container'      => false,
						'menu_class'     => 'nav-menu',
					)
				);
			} else {
				?>
				<ul id="primary-menu" class="nav-menu">
					<li><a href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'About', 'ross-portfolio' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#projects' ) ); ?>"><?php esc_html_e( 'Projects', 'ross-portfolio' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>"><?php esc_html_e( 'FAQ', 'ross-portfolio' ); ?></a></li>
					<li><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Contact', 'ross-portfolio' ); ?></a></li>
				</ul>
				<?php
			}
			?>
		</nav>
	</div>
</header>

<main id="main-content" class="main-content" tabindex="-1" role="main">
