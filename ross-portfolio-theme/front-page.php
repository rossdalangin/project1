<?php
/**
 * Front Page Template
 *
 * Displays Hero profile section, Stats Bar, Skills Grid, Portfolio Projects,
 * Interactive FAQ Accordion, and Contact Showcase Section.
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

<!-- 1. Hero Section -->
<section id="about" class="hero-section" itemscope itemtype="https://schema.org/Person" itemprop="mainEntity">
	<div class="hero-grid">
		<div class="hero-content">
			<div class="hero-badge-wrap">
				<div class="glass-pill">
					<span class="hero-badge-dot"></span>
					<span itemprop="jobTitle"><?php echo esc_html( $profile['title'] ); ?></span>
				</div>
			</div>

			<h1 class="hero-title">
				<?php
				$headline = esc_html( $profile['hero_headline'] );
				// Add gradient span to first two words if present
				$words = explode( ' ', $headline );
				if ( count( $words ) > 2 ) {
					$lead = array_shift( $words ) . ' ' . array_shift( $words );
					echo '<span class="gradient-text">' . esc_html( $lead ) . '</span> ' . esc_html( implode( ' ', $words ) );
				} else {
					echo '<span class="gradient-text">' . esc_html( $headline ) . '</span>';
				}
				?>
			</h1>

			<p class="hero-subtitle">
				<?php echo esc_html( $profile['hero_subhead'] ); ?>
			</p>

			<div class="hero-bio" itemprop="description">
				<?php echo wp_kses_post( wpautop( $profile['bio'] ) ); ?>
			</div>

			<div class="hero-meta">
				<?php if ( ! empty( $profile['location'] ) ) : ?>
					<div class="hero-meta-item" itemprop="workLocation" itemscope itemtype="https://schema.org/Place">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
						<span itemprop="name"><?php echo esc_html( $profile['location'] ); ?></span>
					</div>
				<?php endif; ?>

				<?php if ( ! empty( $profile['email'] ) ) : ?>
					<div class="hero-meta-item">
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
						<a href="<?php echo esc_url( 'mailto:' . $profile['email'] ); ?>" style="color: inherit; text-decoration: none;" itemprop="email"><?php echo esc_html( $profile['email'] ); ?></a>
					</div>
				<?php endif; ?>
			</div>

			<div class="hero-actions">
				<?php if ( ! empty( $profile['hero_cta_text'] ) && ! empty( $profile['hero_cta_url'] ) ) : ?>
					<a href="<?php echo esc_url( $profile['hero_cta_url'] ); ?>" class="btn btn-primary">
						<?php echo esc_html( $profile['hero_cta_text'] ); ?>
						<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="5" y1="12" x2="19" y2="12"></line><polyline points="12 5 19 12 12 19"></polyline></svg>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $profile['github'] ) ) : ?>
					<a href="<?php echo esc_url( $profile['github'] ); ?>" class="btn btn-secondary" target="_blank" rel="noopener noreferrer" itemprop="sameAs">
						<?php echo wp_kses( ross_portfolio_get_social_svg( 'github' ), ross_portfolio_get_allowed_svg_tags() ); ?>
						<span>GitHub</span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $profile['linkedin'] ) ) : ?>
					<a href="<?php echo esc_url( $profile['linkedin'] ); ?>" class="btn btn-secondary" target="_blank" rel="noopener noreferrer" itemprop="sameAs">
						<?php echo wp_kses( ross_portfolio_get_social_svg( 'linkedin' ), ross_portfolio_get_allowed_svg_tags() ); ?>
						<span>LinkedIn</span>
					</a>
				<?php endif; ?>
			</div>
		</div>

		<div class="hero-avatar-wrap">
			<div class="hero-avatar-frame">
				<?php if ( ! empty( $profile['avatar_url'] ) ) : ?>
					<img src="<?php echo esc_url( $profile['avatar_url'] ); ?>" alt="<?php echo esc_attr( $profile['display_name'] ); ?>" class="hero-avatar" itemprop="image">
				<?php else : ?>
					<div class="hero-avatar" style="display: flex; flex-direction: column; align-items: center; justify-content: center; background: rgba(96, 165, 250, 0.08); color: var(--accent-blue); text-align: center;">
						<span style="font-size: 4.5rem; font-weight: 850; line-height: 1;"><?php echo esc_html( substr( $profile['display_name'], 0, 1 ) ); ?></span>
						<span style="font-size: 0.85rem; font-weight: 600; text-transform: uppercase; letter-spacing: 0.1em; color: var(--accent-emerald); margin-top: 0.5rem;"><?php esc_html_e( 'Architect', 'ross-portfolio' ); ?></span>
					</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<!-- Stats & Impact Highlights Bar -->
	<div class="stats-bar">
		<div class="glass-card stat-item">
			<div class="stat-number">100/100</div>
			<div class="stat-label"><?php esc_html_e( 'Lighthouse Speed', 'ross-portfolio' ); ?></div>
		</div>
		<div class="glass-card stat-item">
			<div class="stat-number">&lt; 0.5s</div>
			<div class="stat-label"><?php esc_html_e( 'Time-to-Interactive', 'ross-portfolio' ); ?></div>
		</div>
		<div class="glass-card stat-item">
			<div class="stat-number">WCAG 2.2</div>
			<div class="stat-label"><?php esc_html_e( 'Level AA Accessible', 'ross-portfolio' ); ?></div>
		</div>
		<div class="glass-card stat-item">
			<div class="stat-number">0 KB</div>
			<div class="stat-label"><?php esc_html_e( 'Third-Party Bloat', 'ross-portfolio' ); ?></div>
		</div>
	</div>
</section>

<!-- 2. Skills & Technical Expertise Section -->
<section id="skills" class="section-wrapper">
	<div class="section-header text-center">
		<span class="section-tag"><?php esc_html_e( 'Engineering Stack', 'ross-portfolio' ); ?></span>
		<h2 class="section-title"><?php esc_html_e( 'Specialized Competencies', 'ross-portfolio' ); ?></h2>
		<p class="section-subtitle" style="margin: 0.75rem auto 0;"><?php esc_html_e( 'Handcrafted architecture engineered for ultra-low latency, strict accessibility, and enterprise scale.', 'ross-portfolio' ); ?></p>
	</div>

	<div class="skills-grid">
		<div class="glass-card skill-card">
			<div class="skill-icon-wrap">
				<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polygon points="12 2 2 7 12 12 22 7 12 2"></polygon><polyline points="2 17 12 22 22 17"></polyline><polyline points="2 12 12 17 22 12"></polyline></svg>
			</div>
			<h3 class="skill-title"><?php esc_html_e( 'Classic Theme Architecture', 'ross-portfolio' ); ?></h3>
			<p class="skill-desc"><?php esc_html_e( 'Lean, standalone PHP template hierarchy adhering to WPCS with zero page builders or plugin lock-in.', 'ross-portfolio' ); ?></p>
		</div>

		<div class="glass-card skill-card">
			<div class="skill-icon-wrap">
				<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 14 14"></polyline></svg>
			</div>
			<h3 class="skill-title"><?php esc_html_e( 'Front-End Performance', 'ross-portfolio' ); ?></h3>
			<p class="skill-desc"><?php esc_html_e( 'System font stacks, CSS custom properties, and zero external blocking JS/CSS frameworks for instantaneous rendering.', 'ross-portfolio' ); ?></p>
		</div>

		<div class="glass-card skill-card">
			<div class="skill-icon-wrap">
				<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path></svg>
			</div>
			<h3 class="skill-title"><?php esc_html_e( 'WCAG 2.2 AA Accessibility', 'ross-portfolio' ); ?></h3>
			<p class="skill-desc"><?php esc_html_e( 'Keyboard focus trapping, ARIA live regions, explicit :focus-visible outlines, and screen reader semantic landmarks.', 'ross-portfolio' ); ?></p>
		</div>

		<div class="glass-card skill-card">
			<div class="skill-icon-wrap">
				<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
			</div>
			<h3 class="skill-title"><?php esc_html_e( 'Enterprise Security', 'ross-portfolio' ); ?></h3>
			<p class="skill-desc"><?php esc_html_e( 'Strict ABSPATH protection, comprehensive sanitization, SVG whitelisting, and strict security HTTP headers.', 'ross-portfolio' ); ?></p>
		</div>

		<div class="glass-card skill-card">
			<div class="skill-icon-wrap">
				<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line></svg>
			</div>
			<h3 class="skill-title"><?php esc_html_e( 'AEO & GEO Optimization', 'ross-portfolio' ); ?></h3>
			<p class="skill-desc"><?php esc_html_e( 'Deep JSON-LD structured schema integration for AI answer engines (Perplexity, ChatGPT) and search graphs.', 'ross-portfolio' ); ?></p>
		</div>

		<div class="glass-card skill-card">
			<div class="skill-icon-wrap">
				<svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="2" y="3" width="20" height="14" rx="2" ry="2"></rect><line x1="8" y1="21" x2="16" y2="21"></line><line x1="12" y1="17" x2="12" y2="21"></line></svg>
			</div>
			<h3 class="skill-title"><?php esc_html_e( 'Modern Glassmorphism UI', 'ross-portfolio' ); ?></h3>
			<p class="skill-desc"><?php esc_html_e( 'Multi-layered backdrop-filters, subtle high-contrast borders, ambient radial glows, and 6 curated color themes.', 'ross-portfolio' ); ?></p>
		</div>
	</div>
</section>

<!-- 3. Featured Portfolio Projects Section -->
<section id="projects" class="section-wrapper">
	<div class="section-header">
		<span class="section-tag"><?php esc_html_e( 'Featured Work', 'ross-portfolio' ); ?></span>
		<h2 class="section-title"><?php esc_html_e( 'Engineered Case Studies', 'ross-portfolio' ); ?></h2>
	</div>

	<?php
	$projects_query = new WP_Query(
		array(
			'post_type'           => 'post',
			'posts_per_page'      => 6,
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
			<p><?php esc_html_e( 'No portfolio projects found.', 'ross-portfolio' ); ?></p>
		</div>
	<?php endif; ?>
</section>

<!-- 4. Interactive FAQ Accordion Section -->
<?php if ( ! empty( $faqs ) ) : ?>
<section id="faq" class="section-wrapper" itemscope itemtype="https://schema.org/FAQPage">
	<div class="faq-section">
		<div class="section-header text-center">
			<span class="section-tag"><?php esc_html_e( 'FAQ', 'ross-portfolio' ); ?></span>
			<h2 class="section-title"><?php esc_html_e( 'Frequently Asked Questions', 'ross-portfolio' ); ?></h2>
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

<!-- 5. Direct Contact Showcase Section -->
<section id="contact" class="section-wrapper">
	<div class="glass-card contact-section-inner">
		<div class="contact-content">
			<span class="section-tag"><?php esc_html_e( 'Initiate Contact', 'ross-portfolio' ); ?></span>
			<h2><?php esc_html_e( 'Let\'s Architect Something Exceptional Together', 'ross-portfolio' ); ?></h2>
			<p><?php esc_html_e( 'Available for technical consultations, bespoke WordPress theme engineering, performance optimizations, and accessible enterprise design systems.', 'ross-portfolio' ); ?></p>

			<div class="hero-actions">
				<?php if ( ! empty( $profile['email'] ) ) : ?>
					<a href="<?php echo esc_url( 'mailto:' . $profile['email'] ); ?>" class="btn btn-primary">
						<?php echo wp_kses( ross_portfolio_get_social_svg( 'email' ), ross_portfolio_get_allowed_svg_tags() ); ?>
						<span><?php esc_html_e( 'Send Direct Email', 'ross-portfolio' ); ?></span>
					</a>
				<?php endif; ?>

				<?php if ( ! empty( $profile['phone'] ) ) : ?>
					<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $profile['phone'] ) ); ?>" class="btn btn-secondary">
						<?php echo wp_kses( ross_portfolio_get_social_svg( 'phone' ), ross_portfolio_get_allowed_svg_tags() ); ?>
						<span><?php esc_html_e( 'Call Direct', 'ross-portfolio' ); ?></span>
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
