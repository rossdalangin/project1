<?php
/**
 * The template for displaying the Homepage / Front Page
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

get_header();

$profile = ross_portfolio_get_profile_details();
$skills  = ross_portfolio_get_skills();
$faqs    = ross_portfolio_get_faqs();

// Dynamic Customizer Settings for Sections
$skills_tag        = ross_portfolio_get_option( 'skills_section_tag', __( 'Core Capabilities', 'ross-portfolio' ) );
$skills_title      = ross_portfolio_get_option( 'skills_section_title', __( 'Technical Excellence & Architecture', 'ross-portfolio' ) );

$projects_tag      = ross_portfolio_get_option( 'projects_section_tag', __( 'Featured Work', 'ross-portfolio' ) );
$projects_title    = ross_portfolio_get_option( 'projects_section_title', __( 'Engineered Case Studies', 'ross-portfolio' ) );
$projects_count    = absint( ross_portfolio_get_option( 'projects_count', 6 ) );
$projects_empty    = ross_portfolio_get_option( 'projects_empty_text', __( 'No portfolio projects found.', 'ross-portfolio' ) );

// Standout High-Converting CTA Section Controls
$cta_tag           = ross_portfolio_get_option( 'standout_cta_tag', __( 'Ready to Scale?', 'ross-portfolio' ) );
$cta_heading       = ross_portfolio_get_option( 'standout_cta_heading', __( 'Transform Your Web Architecture into a High-Converting Engine', 'ross-portfolio' ) );
$cta_desc          = ross_portfolio_get_option( 'standout_cta_desc', __( 'Stop losing revenue and users to bloated plugins and sluggish load times. Partner directly with an elite frontend architect to build custom, ultra-fast WordPress applications.', 'ross-portfolio' ) );
$cta_primary_btn   = ross_portfolio_get_option( 'standout_cta_primary_btn_text', __( 'Schedule Architecture Review', 'ross-portfolio' ) );
$cta_primary_url   = ross_portfolio_get_option( 'standout_cta_primary_btn_url', '#contact' );
$cta_second_btn    = ross_portfolio_get_option( 'standout_cta_secondary_btn_text', __( 'Explore Case Studies', 'ross-portfolio' ) );
$cta_second_url    = ross_portfolio_get_option( 'standout_cta_secondary_btn_url', '#projects' );
$cta_trust_note    = ross_portfolio_get_option( 'standout_cta_trust_note', __( 'Guaranteed 95+ Core Web Vitals score • Strict WCAG 2.2 AA accessibility • Zero dependency guarantee', 'ross-portfolio' ) );

// Direct Contact Showcase Controls
$contact_tag       = ross_portfolio_get_option( 'contact_section_tag', __( 'Initiate Contact', 'ross-portfolio' ) );
$contact_headline  = ross_portfolio_get_option( 'contact_section_headline', __( "Let's Architect Something Exceptional Together", 'ross-portfolio' ) );
$contact_desc      = ross_portfolio_get_option( 'contact_section_desc', __( 'Available for technical consultations, bespoke WordPress theme engineering, performance optimizations, and accessible enterprise design systems.', 'ross-portfolio' ) );
$contact_email_btn = ross_portfolio_get_option( 'contact_email_btn_text', __( 'Send Direct Email', 'ross-portfolio' ) );
$contact_phone_btn = ross_portfolio_get_option( 'contact_phone_btn_text', __( 'Call Direct', 'ross-portfolio' ) );

// FAQ Accordion Controls
$faq_tag           = ross_portfolio_get_option( 'faq_section_tag', __( 'FAQ', 'ross-portfolio' ) );
$faq_title         = ross_portfolio_get_option( 'faq_section_title', __( 'Frequently Asked Questions', 'ross-portfolio' ) );
?>

<!-- 1. Hero Section -->
<section id="hero" class="hero-section">
	<div class="hero-grid">
		<div class="hero-content">
			<div class="hero-badge-wrap">
				<span class="glass-pill">
					<span class="hero-badge-dot" aria-hidden="true"></span>
					<?php echo esc_html( $profile['hero_badge_text'] ); ?>
				</span>
			</div>

			<h1 class="hero-title">
				<?php echo esc_html( $profile['hero_headline'] ); ?>
			</h1>

			<p class="hero-subtitle">
				<?php echo esc_html( $profile['hero_subhead'] ); ?>
			</p>

			<div class="hero-actions">
				<a href="<?php echo esc_url( $profile['hero_cta_url'] ); ?>" class="btn btn-primary">
					<span><?php echo esc_html( $profile['hero_cta_text'] ); ?></span>
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
				</a>

				<a href="<?php echo esc_url( $profile['hero_secondary_cta_url'] ); ?>" class="btn btn-secondary">
					<span><?php echo esc_html( $profile['hero_secondary_cta_text'] ); ?></span>
				</a>
			</div>

			<!-- Hero Performance & Architecture Metric Badges -->
			<div class="hero-metrics-bar">
				<?php
				for ( $m = 1; $m <= 3; $m++ ) {
					$default_values = array( 1 => '100/100', 2 => '10+ Yrs', 3 => '0 Deps' );
					$default_labels = array( 1 => 'Core Web Vitals', 2 => 'Enterprise Architecture', 3 => 'Pure Vanilla Standards' );
					$stat_val = ross_portfolio_get_option( "hero_stat_{$m}_value", $default_values[ $m ] );
					$stat_lbl = ross_portfolio_get_option( "hero_stat_{$m}_label", $default_labels[ $m ] );
					if ( ! empty( $stat_val ) ) :
						?>
						<div class="hero-metric-item">
							<span class="hero-metric-value"><?php echo esc_html( $stat_val ); ?></span>
							<span class="hero-metric-label"><?php echo esc_html( $stat_lbl ); ?></span>
						</div>
						<?php
					endif;
				}
				?>
			</div>
		</div>

		<div class="hero-card-column">
			<!-- Glass Profile / Identity Card -->
			<div class="glass-card hero-profile-card">
				<div class="hero-avatar-wrap">
					<?php if ( ! empty( $profile['avatar_url'] ) ) : ?>
						<img src="<?php echo esc_url( $profile['avatar_url'] ); ?>" alt="<?php echo esc_attr( $profile['display_name'] ); ?>" class="hero-avatar" />
					<?php else : ?>
						<div class="hero-avatar-placeholder" aria-hidden="true">
							<?php echo esc_html( strtoupper( substr( $profile['display_name'], 0, 1 ) ) ); ?>
						</div>
					<?php endif; ?>
				</div>

				<h2 class="hero-profile-name"><?php echo esc_html( $profile['display_name'] ); ?></h2>
				<p class="hero-profile-role"><?php echo esc_html( $profile['title'] ); ?></p>
				<p class="hero-profile-bio"><?php echo esc_html( $profile['bio'] ); ?></p>

				<div class="hero-meta-list">
					<?php if ( ! empty( $profile['location'] ) ) : ?>
						<span class="hero-meta-item">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
							<?php echo esc_html( $profile['location'] ); ?>
						</span>
					<?php endif; ?>

					<?php if ( ! empty( $profile['email'] ) ) : ?>
						<span class="hero-meta-item">
							<svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
							<?php echo esc_html( $profile['email'] ); ?>
						</span>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</section>

<!-- 2. Skills & Technical Expertise Section (Direct text and image customizer controls) -->
<section id="skills" class="section-wrapper">
	<div class="section-header">
		<span class="section-tag"><?php echo esc_html( $skills_tag ); ?></span>
		<h2 class="section-title"><?php echo esc_html( $skills_title ); ?></h2>
	</div>

	<div class="skills-grid">
		<?php foreach ( $skills as $skill ) : ?>
			<?php
			$skill_title = isset( $skill['title'] ) ? $skill['title'] : '';
			$skill_desc  = isset( $skill['desc'] ) ? $skill['desc'] : '';
			$skill_icon  = isset( $skill['icon'] ) ? $skill['icon'] : 'layers';
			$skill_image = isset( $skill['image'] ) ? $skill['image'] : '';
			if ( empty( $skill_title ) ) {
				continue;
			}
			?>
			<div class="glass-card skill-card">
				<div class="skill-icon-wrap">
					<?php if ( ! empty( $skill_image ) ) : ?>
						<img src="<?php echo esc_url( $skill_image ); ?>" alt="<?php echo esc_attr( $skill_title ); ?>" style="width: 28px; height: 28px; object-fit: contain;" />
					<?php else : ?>
						<?php echo ross_portfolio_get_icon_svg( $skill_icon ); ?>
					<?php endif; ?>
				</div>
				<h3 class="skill-title"><?php echo esc_html( $skill_title ); ?></h3>
				<p class="skill-desc"><?php echo esc_html( $skill_desc ); ?></p>
			</div>
		<?php endforeach; ?>
	</div>
</section>

<!-- 3. Featured Portfolio Projects Section -->
<section id="projects" class="section-wrapper">
	<div class="section-header">
		<span class="section-tag"><?php echo esc_html( $projects_tag ); ?></span>
		<h2 class="section-title"><?php echo esc_html( $projects_title ); ?></h2>
	</div>

	<?php
	$projects_query = new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'      => $projects_count > 0 ? $projects_count : 6,
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
				<article id="post-<?php the_ID(); ?>" <?php post_class( 'glass-card project-card' ); ?> itemscope itemtype="https://schema.org/CreativeWork">
					<?php if ( has_post_thumbnail() ) : ?>
						<div class="project-thumbnail">
							<a href="<?php the_permalink(); ?>">
								<?php the_post_thumbnail( 'medium_large', array( 'itemprop' => 'image' ) ); ?>
							</a>
						</div>
					<?php else : ?>
						<div class="project-thumbnail" style="display: flex; align-items: center; justify-content: center; background: linear-gradient(135deg, rgba(96, 165, 250, 0.08), rgba(52, 211, 153, 0.06));">
							<svg width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" style="color: var(--accent-blue); opacity: 0.7;" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
						</div>
					<?php endif; ?>

					<div class="project-body">
						<h3 class="project-title" itemprop="name">
							<a href="<?php the_permalink(); ?>" itemprop="url"><?php the_title(); ?></a>
						</h3>

						<div class="project-excerpt" itemprop="description">
							<?php the_excerpt(); ?>
						</div>

						<div class="project-footer">
							<time datetime="<?php echo esc_attr( get_the_date( 'c' ) ); ?>" itemprop="datePublished"><?php echo esc_html( get_the_date() ); ?></time>
							<a href="<?php the_permalink(); ?>" class="btn-secondary" style="padding: 0.4rem 1rem; font-size: 0.875rem;">
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
			<p><?php echo esc_html( $projects_empty ); ?></p>
		</div>
	<?php endif; ?>
</section>

<!-- 4. The Best Standout Call to Action (CTA) Section -->
<section id="cta" class="section-wrapper standout-cta-section">
	<div class="glass-card standout-cta-box">
		<div class="standout-cta-glow" aria-hidden="true"></div>
		<div class="standout-cta-inner">
			<span class="glass-pill standout-cta-badge"><?php echo esc_html( $cta_tag ); ?></span>
			<h2 class="standout-cta-title"><?php echo esc_html( $cta_heading ); ?></h2>
			<p class="standout-cta-desc"><?php echo esc_html( $cta_desc ); ?></p>

			<div class="standout-cta-actions">
				<a href="<?php echo esc_url( $cta_primary_url ); ?>" class="btn btn-primary standout-btn-pulse">
					<span><?php echo esc_html( $cta_primary_btn ); ?></span>
					<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
				</a>
				<a href="<?php echo esc_url( $cta_second_url ); ?>" class="btn btn-secondary">
					<span><?php echo esc_html( $cta_second_btn ); ?></span>
				</a>
			</div>

			<?php if ( ! empty( $cta_trust_note ) ) : ?>
				<div class="standout-cta-trust">
					<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color: var(--accent-emerald);" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
					<span><?php echo esc_html( $cta_trust_note ); ?></span>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<!-- 5. Interactive FAQ Accordion Section (Individual Question & Answer controls) -->
<?php if ( ! empty( $faqs ) ) : ?>
<section id="faq" class="section-wrapper" itemscope itemtype="https://schema.org/FAQPage">
	<div class="faq-section">
		<div class="section-header text-center">
			<span class="section-tag"><?php echo esc_html( $faq_tag ); ?></span>
			<h2 class="section-title"><?php echo esc_html( $faq_title ); ?></h2>
		</div>

		<div class="faq-list">
			<?php foreach ( $faqs as $index => $faq ) : ?>
				<?php
				$question   = isset( $faq['question'] ) ? $faq['question'] : '';
				$answer     = isset( $faq['answer'] ) ? $faq['answer'] : '';
				$panel_id   = 'faq-panel-' . $index;
				$trigger_id = 'faq-trigger-' . $index;
				if ( empty( $question ) || empty( $answer ) ) {
					continue;
				}
				?>
				<div class="glass-card faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
					<button id="<?php echo esc_attr( $trigger_id ); ?>" class="faq-trigger" aria-expanded="false" aria-controls="<?php echo esc_attr( $panel_id ); ?>">
						<span itemprop="name"><?php echo esc_html( $question ); ?></span>
						<svg class="faq-icon" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"></polyline></svg>
					</button>
					<div id="<?php echo esc_attr( $panel_id ); ?>" class="faq-panel" hidden aria-labelledby="<?php echo esc_attr( $trigger_id ); ?>" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
						<p itemprop="text"><?php echo esc_html( $answer ); ?></p>
					</div>
				</div>
			<?php endforeach; ?>
		</div>
	</div>
</section>
<?php endif; ?>

<!-- 6. Direct Contact Showcase Section -->
<section id="contact" class="section-wrapper">
	<div class="glass-card contact-section-inner">
		<div class="contact-content">
			<span class="section-tag"><?php echo esc_html( $contact_tag ); ?></span>
			<h2><?php echo esc_html( $contact_headline ); ?></h2>
			<p><?php echo esc_html( $contact_desc ); ?></p>

			<div class="hero-actions">
				<?php if ( ! empty( $profile['email'] ) ) : ?>
					<a href="<?php echo esc_url( 'mailto:' . $profile['email'] ); ?>" class="btn btn-primary">
						<?php echo wp_kses( ross_portfolio_get_social_svg( 'email' ), ross_portfolio_get_allowed_svg_tags() ); ?>
						<span><?php echo esc_html( $contact_email_btn ); ?></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $profile['phone'] ) ) : ?>
					<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $profile['phone'] ) ); ?>" class="btn btn-secondary">
						<?php echo wp_kses( ross_portfolio_get_social_svg( 'phone' ), ross_portfolio_get_allowed_svg_tags() ); ?>
						<span><?php echo esc_html( $contact_phone_btn ); ?></span>
					</a>
				<?php endif; ?>
			</div>
		</div>

		<div class="contact-methods">
			<?php if ( ! empty( $profile['email'] ) ) : ?>
				<a href="<?php echo esc_url( 'mailto:' . $profile['email'] ); ?>" class="glass-card contact-method-card">
					<div class="contact-method-icon">
						<?php echo wp_kses( ross_portfolio_get_social_svg( 'email' ), ross_portfolio_get_allowed_svg_tags() ); ?>
					</div>
					<div class="contact-method-info">
						<span class="contact-method-label"><?php esc_html_e( 'Direct Email', 'ross-portfolio' ); ?></span>
						<span class="contact-method-value"><?php echo esc_html( $profile['email'] ); ?></span>
					</div>
				</a>
			<?php endif; ?>

			<?php if ( ! empty( $profile['phone'] ) ) : ?>
				<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $profile['phone'] ) ); ?>" class="glass-card contact-method-card">
					<div class="contact-method-icon">
						<?php echo wp_kses( ross_portfolio_get_social_svg( 'phone' ), ross_portfolio_get_allowed_svg_tags() ); ?>
					</div>
					<div class="contact-method-info">
						<span class="contact-method-label"><?php esc_html_e( 'Phone Consultation', 'ross-portfolio' ); ?></span>
						<span class="contact-method-value"><?php echo esc_html( $profile['phone'] ); ?></span>
					</div>
				</a>
			<?php endif; ?>

			<?php if ( ! empty( $profile['location'] ) ) : ?>
				<div class="glass-card contact-method-card">
					<div class="contact-method-icon">
						<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
					</div>
					<div class="contact-method-info">
						<span class="contact-method-label"><?php esc_html_e( 'Headquarters', 'ross-portfolio' ); ?></span>
						<span class="contact-method-value"><?php echo esc_html( $profile['location'] ); ?></span>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
</section>

<?php
get_footer();
