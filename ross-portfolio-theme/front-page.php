<?php
/**
 * Front Page Template
 *
 * Displays Hero profile section, portfolio projects grid, and interactive FAQ accordion.
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$profile = ross_portfolio_get_profile_details();
$faqs    = ross_portfolio_get_faqs();
?>

<!-- Hero Section -->
<section id="about" class="hero-section">
	<div class="hero-grid">
		<div class="hero-content">
			<div class="glass-pill hero-badge">
				<span class="hero-badge-dot"></span>
				<span><?php echo esc_html( $profile['title'] ); ?></span>
			</div>

			<h1 class="hero-title">
				<?php echo esc_html( $profile['hero_headline'] ); ?>
			</h1>

			<p class="hero-subtitle">
				<?php echo esc_html( $profile['hero_subhead'] ); ?>
			</p>

			<div class="hero-bio">
				<?php echo wp_kses_post( wpautop( $profile['bio'] ) ); ?>
			</div>

			<div class="hero-meta">
				<?php if ( ! empty( $profile['location'] ) ) : ?>
					<div class="hero-meta-item">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
						<span><?php echo esc_html( $profile['location'] ); ?></span>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $profile['email'] ) ) : ?>
					<div class="hero-meta-item">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
						<span><?php echo esc_html( $profile['email'] ); ?></span>
					</div>
				<?php endif; ?>
			</div>

			<div class="hero-actions">
				<?php if ( ! empty( $profile['hero_cta_text'] ) && ! empty( $profile['hero_cta_url'] ) ) : ?>
					<a href="<?php echo esc_url( $profile['hero_cta_url'] ); ?>" class="btn btn-primary">
						<?php echo esc_html( $profile['hero_cta_text'] ); ?>
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $profile['github'] ) ) : ?>
					<a href="<?php echo esc_url( $profile['github'] ); ?>" class="btn btn-secondary" target="_blank" rel="noopener noreferrer">
						<?php echo wp_kses( ross_portfolio_get_social_svg( 'github' ), ross_portfolio_get_allowed_svg_tags() ); ?>
						<span>GitHub</span>
					</a>
				<?php endif; ?>
			</div>
		</div>

		<div class="hero-avatar-wrap">
			<div class="hero-avatar-frame">
				<?php if ( ! empty( $profile['avatar_url'] ) ) : ?>
					<img src="<?php echo esc_url( $profile['avatar_url'] ); ?>" alt="<?php echo esc_attr( $profile['display_name'] ); ?>" class="hero-avatar">
				<?php else : ?>
					<div class="hero-avatar" style="display: flex; align-items: center; justify-content: center; background: rgba(96, 165, 250, 0.1); color: var(--accent-blue); font-size: 4rem; font-weight: 800;">
						<?php echo esc_html( substr( $profile['display_name'], 0, 1 ) ); ?>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>
</section>

<!-- Portfolio Projects Section -->
<section id="projects" class="section-wrapper">
	<div class="section-header">
		<span class="section-tag"><?php esc_html_e( 'Selected Work', 'ross-portfolio' ); ?></span>
		<h2 class="section-title"><?php esc_html_e( 'Featured Projects & Case Studies', 'ross-portfolio' ); ?></h2>
	</div>

	<?php
	$projects_query = new WP_Query(
		array(
			'post_type'      => 'post',
			'posts_per_page' => 6,
			'ignore_sticky_posts' => true,
		)
	);

	if ( $projects_query->have_posts() ) :
		?>
		<div class="projects-grid">
			<?php
			while ( $projects_query->have_posts() ) :
				$projects_query->the_post();
				?>
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'glass-card project-card' ); ?>>
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="project-thumbnail">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'medium_large' ); ?>
							</a>
						</div>
					<?php else : ?>
						<div class="project-thumbnail" style="display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(96, 165, 250, 0.05), rgba(52, 211, 153, 0.05));">
							<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.2)" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
						</div>
					<?php endif; ?>

					<div class="project-body">
						<h3 class="project-title">
							<a href="<?php the_permalink(); ?>"><?php the_title(); ?></a>
						</h3>

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
			wp_reset_postdata();
			?>
		</div>
	<?php else : ?>
		<div class="glass-card" style="padding: 3rem; text-align: center;">
			<p><?php esc_html_e( 'No portfolio projects found.', 'ross-portfolio' ); ?></p>
		</div>
	<?php endif; ?>
</section>

<!-- Interactive FAQ Accordion Section -->
<?php if ( ! empty( $faqs ) ) : ?>
<section id="faq" class="section-wrapper">
	<div class="faq-section">
		<div class="section-header" style="text-align: center;">
			<span class="section-tag"><?php esc_html_e( 'Questions & Answers', 'ross-portfolio' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Frequently Asked Questions', 'ross-portfolio' ); ?></h2>
		</div>

		<div class="faq-list">
			<?php foreach ( $faqs as $index => $faq ) : ?>
				<?php
				$question = isset( $faq['question'] ) ? $faq['question'] : '';
				$answer   = isset( $faq['answer'] ) ? $faq['answer'] : '';
				$panel_id = 'faq-panel-' . $index;
				$trigger_id = 'faq-trigger-' . $index;
				if ( empty( $question ) || empty( $answer ) ) {
					continue;
				}
				?>
				<div class="glass-card faq-item">
					<button id="<?php echo esc_attr( $trigger_id ); ?>" class="faq-trigger" aria-expanded="false" aria-controls="<?php echo esc_attr( $panel_id ); ?>">
						<span><?php echo esc_html( $question ); ?></span>
						<svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
					</button>
					<div id="<?php echo esc_attr( $panel_id ); ?>" class="faq-panel" hidden aria-labelledby="<?php echo esc_attr( $trigger_id ); ?>">
						<p><?php echo esc_html( $answer ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<?php
get_footer();
