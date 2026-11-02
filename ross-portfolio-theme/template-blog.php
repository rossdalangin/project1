<?php
/**
 * Template Name: Blog Page Template
 *
 * A custom page template for displaying the blog archive with page navigation.
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$paged = ( get_query_var( 'paged' ) ) ? get_query_var( 'paged' ) : ( ( get_query_var( 'page' ) ) ? get_query_var( 'page' ) : 1 );

$blog_query = new WP_Query(
	array(
		'post_type'      => 'post',
		'post_status'    => 'publish',
		'paged'          => $paged,
		'posts_per_page' => get_option( 'posts_per_page', 6 ),
	)
);
?>

<div class="content-container">
	<header class="page-banner">
		<span class="glass-pill" style="margin-bottom: 1rem;"><?php esc_html_e( 'Engineering Journal', 'ross-portfolio' ); ?></span>
		<h1 class="page-title"><?php the_title(); ?></h1>
		<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
			<?php if ( get_the_content() ) : ?>
				<div class="page-lead-intro" style="color: var(--text-muted); font-size: 1.15rem; max-width: 720px; margin-top: 1rem; line-height: 1.7;">
					<?php the_content(); ?>
				</div>
			<?php endif; ?>
		<?php endwhile; endif; ?>
	</header>

	<?php if ( $blog_query->have_posts() ) : ?>
		<div class="projects-grid blog-grid">
			<?php
			while ( $blog_query->have_posts() ) :
				$blog_query->the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'glass-card project-card blog-post-card' ); ?> itemscope itemtype="https://schema.org/BlogPosting">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="project-thumbnail">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'medium_large', array( 'itemprop' => 'image' ) ); ?>
							</a>
						</div>
					<?php else : ?>
						<div class="project-thumbnail" style="display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(96, 165, 250, 0.08), rgba(52, 211, 153, 0.06));">
							<svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--accent-blue); opacity: 0.7;" aria-hidden="true"><path d="M4 19.5A2.5 2.5 0 0 1 6.5 17H20"></path><path d="M6.5 2H20v20H6.5A2.5 2.5 0 0 1 4 19.5v-15A2.5 2.5 0 0 1 6.5 2z"></path></svg>
						</div>
					<?php endif; ?>

					<div class="project-body">
						<div class="glass-pill" style="padding: 0.2rem 0.65rem; font-size: 0.8rem; margin-bottom: 0.75rem; align-self: flex-start;">
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished"><?php echo esc_html( get_the_date() ); ?></time>
						</div>

						<h2 class="project-title" itemprop="headline">
							<a href="<?php the_permalink(); ?>" itemprop="url"><?php the_title(); ?></a>
						</h2>

						<div class="project-excerpt" itemprop="description">
							<?php the_excerpt(); ?>
						</div>

						<div class="project-footer">
							<span style="font-size: 0.85rem; color: var(--text-subtle);">
								<?php the_author(); ?>
							</span>
							<a href="<?php the_permalink(); ?>" class="btn-secondary" style="padding: 0.4rem 1rem; font-size: 0.875rem;">
								<?php esc_html_e( 'Read Article', 'ross-portfolio' ); ?> &rarr;
							</a>
						</div>
					</div>
				</article>
				<?php
			endwhile;
			?>
		</div>

		<!-- Blog Page Navigation -->
		<nav class="pagination blog-pagination" aria-label="<?php esc_attr_e( 'Blog Pages', 'ross-portfolio' ); ?>">
			<?php
			echo wp_kses_post(
				paginate_links(
					array(
						'base'         => str_replace( 999999999, '%#%', esc_url( get_pagenum_link( 999999999 ) ) ),
						'total'        => $blog_query->max_num_pages,
						'current'      => max( 1, $paged ),
						'format'       => '?paged=%#%',
						'show_all'     => false,
						'type'         => 'plain',
						'end_size'     => 2,
						'mid_size'     => 1,
						'prev_next'    => true,
						'prev_text'    => sprintf( '&laquo; %s', esc_html__( 'Previous', 'ross-portfolio' ) ),
						'next_text'    => sprintf( '%s &raquo;', esc_html__( 'Next', 'ross-portfolio' ) ),
					)
				)
			);
			?>
		</nav>

		<?php
		wp_reset_postdata();
	else :
		?>
		<div class="glass-card" style="padding: 3.5rem; text-align: center;">
			<h2><?php esc_html_e( 'No Articles Published Yet', 'ross-portfolio' ); ?></h2>
			<p style="color: var(--text-muted); margin-top: 0.5rem;"><?php esc_html_e( 'Check back soon for upcoming technical essays and architecture case studies.', 'ross-portfolio' ); ?></p>
		</div>
	<?php endif; ?>
</div>

<?php
get_footer();
