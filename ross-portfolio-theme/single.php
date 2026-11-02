<?php
/**
 * Single Post Template with Right Sidebar
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();
?>

<div class="content-container">
	<?php
	while ( have_posts() ) :
		the_post();
		?>
		<div class="page-banner">
			<div class="glass-pill" style="margin-bottom: 1.25rem;">
				<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished"><?php echo esc_html( get_the_date() ); ?></time>
				<span>&bull;</span>
				<span itemprop="author" itemscope itemtype="https://schema.org/Person"><span itemprop="name"><?php the_author(); ?></span></span>
				<?php if ( has_category() ) : ?>
					<span>&bull;</span>
					<span><?php the_category( ', ' ); ?></span>
				<?php endif; ?>
			</div>
			<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
		</div>

		<!-- Two-column responsive layout: Post content left, Blog sidebar right -->
		<div class="single-post-layout">
			<main class="single-post-main">
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'glass-card single-post-article' ); ?> itemscope itemtype="https://schema.org/BlogPosting">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="single-post-hero-image">
							<?php the_post_thumbnail( 'large', array( 'itemprop' => 'image' ) ); ?>
						</div>
					<?php endif; ?>

					<div class="entry-content" itemprop="articleBody">
						<?php
						the_content();

						wp_link_pages(
							array(
								'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'ross-portfolio' ),
								'after'  => '</div>',
							)
						);
						?>
					</div>

					<footer class="single-post-footer">
						<div class="single-post-tags">
							<?php the_tags( '<span class="glass-pill">', '</span> <span class="glass-pill">', '</span>' ); ?>
						</div>
					</footer>
				</article>

				<!-- Post Navigation (Next / Previous Post) -->
				<nav class="glass-card post-navigation" aria-label="<?php esc_attr_e( 'Posts', 'ross-portfolio' ); ?>">
					<div class="nav-links">
						<div class="nav-previous">
							<?php previous_post_link( '<div class="nav-meta">' . esc_html__( '&larr; Previous Article', 'ross-portfolio' ) . '</div>%link' ); ?>
						</div>
						<div class="nav-next">
							<?php next_post_link( '<div class="nav-meta">' . esc_html__( 'Next Article &rarr;', 'ross-portfolio' ) . '</div>%link' ); ?>
						</div>
					</div>
				</nav>

				<?php
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;
				?>
			</main>

			<!-- Right Sidebar Column -->
			<?php get_sidebar(); ?>
		</div>

		<?php
	endwhile;
	?>
</div>

<?php
get_footer();
