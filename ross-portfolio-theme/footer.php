<?php
/**
 * Footer Template
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$profile = ross_portfolio_get_profile_details();
?>
</main><!-- #main-content -->

<footer id="colophon" class="site-footer">
	<div class="footer-grid">
		<!-- Column 1: Brand & Bio -->
		<div class="footer-brand">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-branding" rel="home">
				<span class="brand-symbol"><?php echo esc_html( substr( $profile['display_name'], 0, 1 ) ); ?></span>
				<span class="site-title">
					<?php echo esc_html( $profile['display_name'] ); ?><span>.dev</span>
				</span>
			</a>
			<p>
				<?php echo esc_html( $profile['title'] ); ?>. <?php echo esc_html( wp_trim_words( $profile['bio'], 22 ) ); ?>
			</p>
		</div>

		<!-- Column 2: Quick Links -->
		<div>
			<h4 class="footer-title"><?php esc_html_e( 'Quick Navigation', 'ross-portfolio' ); ?></h4>
			<ul class="footer-links">
				<li><a href="<?php echo esc_url( home_url( '/#about' ) ); ?>"><?php esc_html_e( 'About Experience', 'ross-portfolio' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/#skills' ) ); ?>"><?php esc_html_e( 'Technical Skills', 'ross-portfolio' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/#projects' ) ); ?>"><?php esc_html_e( 'Selected Work', 'ross-portfolio' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/#faq' ) ); ?>"><?php esc_html_e( 'FAQs', 'ross-portfolio' ); ?></a></li>
				<li><a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>"><?php esc_html_e( 'Direct Consultation', 'ross-portfolio' ); ?></a></li>
			</ul>
		</div>

		<!-- Column 3: Contact Info -->
		<div>
			<h4 class="footer-title"><?php esc_html_e( 'Direct Contact', 'ross-portfolio' ); ?></h4>
			<ul class="footer-contact-list">
				<?php if ( ! empty( $profile['email'] ) ) : ?>
					<li class="footer-contact-item">
						<?php echo wp_kses( ross_portfolio_get_social_svg( 'email' ), ross_portfolio_get_allowed_svg_tags() ); ?>
						<a href="<?php echo esc_url( 'mailto:' . $profile['email'] ); ?>"><?php echo esc_html( $profile['email'] ); ?></a>
					</li>
				<?php endif; ?>

				<?php if ( ! empty( $profile['phone'] ) ) : ?>
					<li class="footer-contact-item">
						<?php echo wp_kses( ross_portfolio_get_social_svg( 'phone' ), ross_portfolio_get_allowed_svg_tags() ); ?>
						<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $profile['phone'] ) ); ?>"><?php echo esc_html( $profile['phone'] ); ?></a>
					</li>
				<?php endif; ?>

				<?php if ( ! empty( $profile['location'] ) ) : ?>
					<li class="footer-contact-item">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
						<span><?php echo esc_html( $profile['location'] ); ?></span>
					</li>
				<?php endif; ?>
			</ul>
		</div>
	</div>

	<div class="footer-bottom">
		<div class="copyright-text">
			&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php echo esc_html( $profile['display_name'] ); ?>. <?php esc_html_e( 'Built with pure WordPress standards and zero bloated dependencies.', 'ross-portfolio' ); ?>
		</div>

		<div class="social-links">
			<?php if ( ! empty( $profile['github'] ) ) : ?>
				<a href="<?php echo esc_url( $profile['github'] ); ?>" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'GitHub Profile', 'ross-portfolio' ); ?>">
					<?php echo wp_kses( ross_portfolio_get_social_svg( 'github' ), ross_portfolio_get_allowed_svg_tags() ); ?>
				</a>
			<?php endif; ?>

			<?php if ( ! empty( $profile['linkedin'] ) ) : ?>
				<a href="<?php echo esc_url( $profile['linkedin'] ); ?>" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'LinkedIn Profile', 'ross-portfolio' ); ?>">
					<?php echo wp_kses( ross_portfolio_get_social_svg( 'linkedin' ), ross_portfolio_get_allowed_svg_tags() ); ?>
				</a>
			<?php endif; ?>

			<?php if ( ! empty( $profile['twitter'] ) ) : ?>
				<a href="<?php echo esc_url( $profile['twitter'] ); ?>" class="social-link" target="_blank" rel="noopener noreferrer" aria-label="<?php esc_attr_e( 'Twitter Profile', 'ross-portfolio' ); ?>">
					<?php echo wp_kses( ross_portfolio_get_social_svg( 'twitter' ), ross_portfolio_get_allowed_svg_tags() ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
