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
	<div class="footer-container">
		<div class="copyright-text">
			&copy; <?php echo esc_html( date_i18n( 'Y' ) ); ?> <?php echo esc_html( $profile['display_name'] ); ?>. <?php esc_html_e( 'All rights reserved.', 'ross-portfolio' ); ?>
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

			<?php if ( ! empty( $profile['email'] ) ) : ?>
				<a href="<?php echo esc_url( 'mailto:' . $profile['email'] ); ?>" class="social-link" aria-label="<?php esc_attr_e( 'Send Email', 'ross-portfolio' ); ?>">
					<?php echo wp_kses( ross_portfolio_get_social_svg( 'email' ), ross_portfolio_get_allowed_svg_tags() ); ?>
				</a>
			<?php endif; ?>
		</div>
	</div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
