<?php
/**
 * Page Template
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
			<h1 class="page-title"><?php the_title(); ?></h1>
		</div>

		<article id="post-<?php the_ID(); ?>" <?php post_class( 'glass-card' ); ?> style="padding: clamp(1.75rem, 5vw, 3.5rem);">
			<?php if ( has_post_thumbnail() ) : ?>
				<div style="margin-bottom: 2.5rem; border-radius: var(--radius-md); overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.5);">
					<?php the_post_thumbnail( 'large', array( 'style' => 'width: 100%; height: auto; display: block;' ) ); ?>
				</div>
			<?php endif; ?>

			<div class="entry-content">
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
