<?php
/**
 * Search Results Template
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>

<div class="content-container">
	<header class="page-header">
		<h1 class="page-title">
			<?php
			/* translators: %s: search query. */
			printf( esc_html__( 'Search Results for: %s', 'ross-portfolio' ), '<span class="gradient-text">' . get_search_query() . '</span>' );
			?>
		</h1>
	</header>

	<?php if ( have_posts() ) : ?>
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
							<a href="<?php the_permalink(); ?>" class="btn-secondary" style="padding: 0.35rem 0.85rem; font-size: 0.875rem;">
								<?php esc_html_e( 'View Details', 'ross-portfolio' ); ?> &rarr;
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
		<div class="glass-card" style="padding: 3rem; text-align: center; max-width: 600px; margin: 0 auto;">
			<h2><?php esc_html_e( 'No Results Found', 'ross-portfolio' ); ?></h2>
			<p style="margin-bottom: 1.5rem;"><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'ross-portfolio' ); ?></p>
			<?php get_search_form(); ?>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();
