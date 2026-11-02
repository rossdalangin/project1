<?php
/**
 * Main Fallback Index Template
 *
 * Required template file for standalone classic WordPress themes.
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>

<div class="content-container">
	<?php if ( have_posts() ) : ?>
		<div class="page-banner">
			<span class="section-tag"><?php esc_html_e( 'Archive', 'ross-portfolio' ); ?></span>
			<h1 class="page-title"><?php esc_html_e( 'Latest Articles & Updates', 'ross-portfolio' ); ?></h1>
		</div>

		<div class="projects-grid">
			<?php
			while ( have_posts() ) :
				the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'glass-card project-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="project-thumbnail">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'medium_large' ); ?>
							</a>
						</div>
					<?php else : ?>
						<div class="project-thumbnail" style="display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(96, 165, 250, 0.08), rgba(52, 211, 153, 0.06));">
							<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--accent-blue); opacity: 0.7;" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
						</div>
					<?php endif; ?>

					<div class="project-body">
						<h2 class="project-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h2>
						<div class="project-excerpt">
							<?php the_excerpt(); ?>
						</div>
						<div class="project-footer">
							<span><?php echo esc_html( get_the_date() ); ?></span>
							<a href="<?php the_permalink(); ?>" class="btn-secondary" style="padding: 0.4rem 1rem; font-size: 0.875rem;">
								<?php esc_html_e( 'Read More', 'ross-portfolio' ); ?> &rarr;
							</a>
						</div>
					</div>
				</article>
				<?php
			endwhile;
			?>
		</div>

		<div class="pagination">
			<?php
			the_posts_pagination(
				array(
					'mid_size'  => 2,
					'prev_text' => __( '&laquo; Prev', 'ross-portfolio' ),
					'next_text' => __( 'Next &raquo;', 'ross-portfolio' ),
				)
			);
			?>
		</div>

	<?php else : ?>
		<div class="glass-card" style="padding: 4rem 2rem; text-align: center; max-width: 650px; margin: 3rem auto;">
			<h2><?php esc_html_e( 'Nothing Found', 'ross-portfolio' ); ?></h2>
			<p style="color: var(--text-muted); margin: 1rem 0 2rem;"><?php esc_html_e( 'It seems we cannot find what you are looking for. Try a search below.', 'ross-portfolio' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();
