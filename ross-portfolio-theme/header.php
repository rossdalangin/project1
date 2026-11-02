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

		<!-- Desktop Quick Contact & CTA -->
		<div class="header-desktop-actions">
			<?php if ( ! empty( $profile['phone'] ) ) : ?>
				<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $profile['phone'] ) ); ?>" class="header-phone-link" aria-label="<?php esc_attr_e( 'Call directly', 'ross-portfolio' ); ?>">
					<?php echo wp_kses( ross_portfolio_get_social_svg( 'phone' ), ross_portfolio_get_allowed_svg_tags() ); ?>
					<span><?php echo esc_html( $profile['phone'] ); ?></span>
				</a>
			<?php endif; ?>

			<?php if ( ! empty( $profile['header_cta_text'] ) && ! empty( $profile['header_cta_url'] ) ) : ?>
				<a href="<?php echo esc_url( $profile['header_cta_url'] ); ?>" class="btn btn-primary header-cta-btn">
					<?php echo esc_html( $profile['header_cta_text'] ); ?>
				</a>
			<?php endif; ?>
		</div>

		<button id="primary-nav-toggle" class="nav-toggle" aria-controls="primary-nav" aria-expanded="false" aria-label="<?php esc_attr_e( 'Toggle navigation menu', 'ross-portfolio' ); ?>">
			<span></span>
			<span></span>
			<span></span>
		</button>

		<nav id="primary-nav" class="primary-nav" aria-label="<?php esc_attr_e( 'Primary Menu', 'ross-portfolio' ); ?>" itemscope itemtype="https://schema.org/SiteNavigationElement">
			<div class="mobile-drawer-header">
				<span class="mobile-drawer-title"><?php esc_html_e( 'Navigation', 'ross-portfolio' ); ?></span>
				<button id="mobile-nav-close" class="mobile-close-btn" aria-label="<?php esc_attr_e( 'Close navigation menu', 'ross-portfolio' ); ?>">
					&times;
				</button>
			</div>

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

			<!-- Mobile Drawer Direct Call & Action Buttons -->
			<div class="mobile-drawer-actions">
				<?php if ( ! empty( $profile['phone'] ) ) : ?>
					<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $profile['phone'] ) ); ?>" class="btn btn-secondary mobile-phone-btn">
						<?php echo wp_kses( ross_portfolio_get_social_svg( 'phone' ), ross_portfolio_get_allowed_svg_tags() ); ?>
						<span><?php echo esc_html( $profile['phone'] ); ?></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $profile['header_cta_text'] ) && ! empty( $profile['header_cta_url'] ) ) : ?>
					<a href="<?php echo esc_url( $profile['header_cta_url'] ); ?>" class="btn btn-primary mobile-cta-btn">
						<?php echo esc_html( $profile['header_cta_text'] ); ?>
					</a>
				<?php endif; ?>
			</div>
		</nav>
	</div>
</header>

<main id="main-content" class="main-content" tabindex="-1" role="main">
