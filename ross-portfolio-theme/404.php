<?php
/**
 * 404 Error Page Template
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>

<div class="content-container">
	<div class="glass-card" style="padding: 4rem 2rem; text-align: center; max-width: 600px; margin: 4rem auto;">
		<div style="font-size: 5rem; font-weight: 900; line-height: 1; color: var(--accent-blue); margin-bottom: 1rem;">
			404
		</div>
		<h1 class="page-title" style="font-size: 2rem; margin-bottom: 1rem;">
			<?php esc_html_e( 'Page Not Found', 'ross-portfolio' ); ?>
		</h1>
		<p style="color: var(--text-muted); margin-bottom: 2rem;">
			<?php esc_html_e( 'It looks like nothing was found at this location. Maybe try a search?', 'ross-portfolio' ); ?>
		</p>

		<div style="margin-bottom: 2rem;">
			<?php get_search_form(); ?>
		</div>

		<a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="btn btn-primary">
			<?php esc_html_e( 'Return to Homepage', 'ross-portfolio' ); ?>
		</a>
	</div>
</div>

<?php
get_footer();
