<?php
/**
 * The sidebar containing the main widget area
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$profile = ross_portfolio_get_profile_details();
?>

<aside id="secondary" class="widget-area blog-sidebar" aria-label="<?php esc_attr_e( 'Blog Sidebar', 'ross-portfolio' ); ?>">
	<?php if ( is_active_sidebar( 'sidebar-1' ) ) : ?>
		<?php dynamic_sidebar( 'sidebar-1' ); ?>
	<?php else : ?>
		<!-- Default Fallback Glass Widgets -->
		<section class="glass-card widget widget_author_bio">
			<h3 class="widget-title"><?php esc_html_e( 'About The Author', 'ross-portfolio' ); ?></h3>
			<div class="author-bio-wrap" style="display: flex; gap: 1rem; align-items: center; margin-bottom: 1rem;">
				<?php if ( ! empty( $profile['avatar_url'] ) ) : ?>
					<img src="<?php echo esc_url( $profile['avatar_url'] ); ?>" alt="<?php echo esc_attr( $profile['display_name'] ); ?>" style="width: 54px; height: 54px; border-radius: 50%; object-fit: cover; border: 2px solid var(--accent-blue);" />
				<?php else : ?>
					<div class="brand-symbol" style="width: 54px; height: 54px; border-radius: 50%; font-size: 1.3rem;">
						<?php echo esc_html( strtoupper( substr( $profile['display_name'], 0, 1 ) ) ); ?>
					</div>
				<?php endif; ?>
				<div>
					<h4 style="color: #FFFFFF; font-size: 1.05rem; margin-bottom: 0.2rem;"><?php echo esc_html( $profile['display_name'] ); ?></h4>
					<p style="font-size: 0.85rem; color: var(--text-muted); line-height: 1.3;"><?php echo esc_html( $profile['title'] ); ?></p>
				</div>
			</div>
			<p style="font-size: 0.925rem; color: var(--text-muted); line-height: 1.6; margin-bottom: 1.25rem;">
				<?php echo esc_html( $profile['bio'] ); ?>
			</p>
			<a href="<?php echo esc_url( home_url( '/#contact' ) ); ?>" class="btn-secondary" style="width: 100%; text-align: center; justify-content: center;">
				<?php esc_html_e( 'Contact Directly', 'ross-portfolio' ); ?> &rarr;
			</a>
		</section>

		<section class="glass-card widget widget_search">
			<h3 class="widget-title"><?php esc_html_e( 'Search Articles', 'ross-portfolio' ); ?></h3>
			<?php get_search_form(); ?>
		</section>

		<section class="glass-card widget widget_recent_entries">
			<h3 class="widget-title"><?php esc_html_e( 'Recent Articles', 'ross-portfolio' ); ?></h3>
			<ul>
				<?php
				$recent_posts = wp_get_recent_posts(
					array(
						'numberposts' => 4,
						'post_status' => 'publish',
					)
				);
				if ( ! empty( $recent_posts ) ) :
					foreach ( $recent_posts as $post_item ) :
						?>
						<li>
							<a href="<?php echo esc_url( get_permalink( $post_item['ID'] ) ); ?>">
								<?php echo esc_html( $post_item['post_title'] ); ?>
							</a>
							<span class="post-date" style="display: block; font-size: 0.825rem; color: var(--text-subtle); margin-top: 0.2rem;">
								<?php echo esc_html( get_the_date( '', $post_item['ID'] ) ); ?>
							</span>
						</li>
						<?php
					endforeach;
					wp_reset_postdata();
				else :
					?>
					<li><span style="color: var(--text-muted);"><?php esc_html_e( 'No recent posts found.', 'ross-portfolio' ); ?></span></li>
				<?php endif; ?>
			</ul>
		</section>

		<section class="glass-card widget widget_categories">
			<h3 class="widget-title"><?php esc_html_e( 'Categories', 'ross-portfolio' ); ?></h3>
			<ul>
				<?php
				wp_list_categories(
					array(
						'orderby'    => 'count',
						'order'      => 'DESC',
						'show_count' => true,
						'title_li'   => '',
						'number'     => 6,
					)
				);
				?>
			</ul>
		</section>
	<?php endif; ?>
</aside>
