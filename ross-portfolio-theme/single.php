<?php
/**
 * Single Post Template
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
		<article id="post-<?php the_ID(); ?>" <?php post_class( 'glass-card' ); ?> style="padding: 2.5rem;" itemscope itemtype="https://schema.org/BlogPosting">
			<header class="page-header" style="margin-bottom: 2rem;">
				<div class="glass-pill" style="margin-bottom: 1rem;">
					<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished"><?php echo esc_html( get_the_date() ); ?></time>
					<span>&bull;</span>
					<span itemprop="author" itemscope itemtype="https://schema.org/Person"><span itemprop="name"><?php the_author(); ?></span></span>
				</div>
				<h1 class="page-title" itemprop="headline"><?php the_title(); ?></h1>
			</header>

			<?php if ( has_post_thumbnail() ) : ?>
				<div style="margin-bottom: 2rem; border-radius: var(--radius-md); overflow: hidden;">
					<?php the_post_thumbnail( 'large', array( 'style' => 'width: 100%; height: auto; display: block;', 'itemprop' => 'image' ) ); ?>
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

			<footer style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--border-glass); display: flex; flex-wrap: wrap; gap: 0.5rem;">
				<?php the_tags( '<span class="glass-pill">', '</span> <span class="glass-pill">', '</span>' ); ?>
			</footer>
		</article>

		<?php
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;

	endwhile;
	?>
</div>

<?php
get_footer();
