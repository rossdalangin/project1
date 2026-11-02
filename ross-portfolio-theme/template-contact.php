<?php
/**
 * Template Name: Contact Page Template
 *
 * A production-ready, accessible, standalone Contact Page Template.
 * Features built-in zero-dependency form handling, nonce verification,
 * honeypot spam protection, WCAG 2.2 AA alert states, and dark glassmorphic styling.
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

$form_errors  = array();
$form_success = false;
$posted_data  = array(
	'contact_name'    => '',
	'contact_email'   => '',
	'contact_subject' => '',
	'contact_service' => '',
	'contact_budget'  => '',
	'contact_message' => '',
);

// Process server-side form submission
if ( 'POST' === $_SERVER['REQUEST_METHOD'] && isset( $_POST['ross_portfolio_contact_submit'] ) ) {
	// 1. Verify Nonce
	if ( ! isset( $_POST['ross_portfolio_contact_nonce'] ) || ! wp_verify_nonce( sanitize_text_field( wp_unslash( $_POST['ross_portfolio_contact_nonce'] ) ), 'ross_portfolio_contact_action' ) ) {
		$form_errors[] = __( 'Security verification failed. Please refresh and try again.', 'ross-portfolio' );
	}

	// 2. Honeypot check (hidden field to trap spam bots)
	if ( ! empty( $_POST['contact_secondary_verification'] ) ) {
		// Bot detected: simulate success silently without processing
		$form_success = true;
	} else {
		// 3. Sanitize inputs
		$posted_data['contact_name']    = isset( $_POST['contact_name'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_name'] ) ) : '';
		$posted_data['contact_email']   = isset( $_POST['contact_email'] ) ? sanitize_email( wp_unslash( $_POST['contact_email'] ) ) : '';
		$posted_data['contact_subject'] = isset( $_POST['contact_subject'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_subject'] ) ) : '';
		$posted_data['contact_service'] = isset( $_POST['contact_service'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_service'] ) ) : '';
		$posted_data['contact_budget']  = isset( $_POST['contact_budget'] ) ? sanitize_text_field( wp_unslash( $_POST['contact_budget'] ) ) : '';
		$posted_data['contact_message'] = isset( $_POST['contact_message'] ) ? sanitize_textarea_field( wp_unslash( $_POST['contact_message'] ) ) : '';

		// 4. Validate inputs
		if ( empty( $posted_data['contact_name'] ) ) {
			$form_errors['contact_name'] = __( 'Please enter your name.', 'ross-portfolio' );
		}

		if ( empty( $posted_data['contact_email'] ) || ! is_email( $posted_data['contact_email'] ) ) {
			$form_errors['contact_email'] = __( 'Please provide a valid email address.', 'ross-portfolio' );
		}

		if ( empty( $posted_data['contact_message'] ) || strlen( $posted_data['contact_message'] ) < 10 ) {
			$form_errors['contact_message'] = __( 'Please enter a message of at least 10 characters.', 'ross-portfolio' );
		}

		// 5. Send Email if validation passes
		if ( empty( $form_errors ) ) {
			$recipient = get_theme_mod( 'profile_email', get_option( 'admin_email' ) );
			$subject   = sprintf(
				/* translators: 1: site name, 2: sender subject or name */
				__( '[%1$s Contact] %2$s', 'ross-portfolio' ),
				get_bloginfo( 'name' ),
				! empty( $posted_data['contact_subject'] ) ? $posted_data['contact_subject'] : $posted_data['contact_name']
			);

			$body  = "You have received a new consultation inquiry from the portfolio contact page:\n\n";
			$body .= "Name: " . $posted_data['contact_name'] . "\n";
			$body .= "Email: " . $posted_data['contact_email'] . "\n";
			if ( ! empty( $posted_data['contact_service'] ) ) {
				$body .= "Service Requested: " . $posted_data['contact_service'] . "\n";
			}
			if ( ! empty( $posted_data['contact_budget'] ) ) {
				$body .= "Estimated Scope / Budget: " . $posted_data['contact_budget'] . "\n";
			}
			$body .= "\nMessage:\n" . $posted_data['contact_message'] . "\n\n";
			$body .= "---\nSent from: " . home_url();

			$headers = array(
				'Content-Type: text/plain; charset=UTF-8',
				'From: ' . get_bloginfo( 'name' ) . ' <' . ( get_option( 'admin_email' ) ?: 'no-reply@' . wp_parse_url( home_url(), PHP_URL_HOST ) ) . '>',
				'Reply-To: ' . $posted_data['contact_name'] . ' <' . $posted_data['contact_email'] . '>',
			);

			$sent = wp_mail( $recipient, $subject, $body, $headers );

			if ( $sent ) {
				$form_success = true;
				// Reset form fields
				$posted_data = array_fill_keys( array_keys( $posted_data ), '' );
			} else {
				$form_errors['mail'] = __( 'There was an issue sending your message. Please try sending a direct email instead.', 'ross-portfolio' );
			}
		}
	}
}

// Retrieve profile & contact settings
$owner_name      = get_theme_mod( 'profile_display_name', 'Ross' );
$owner_title     = get_theme_mod( 'profile_title', 'Principal Theme Architect & Front-End Performance Lead' );
$owner_email     = get_theme_mod( 'profile_email', 'ross@example.com' );
$owner_phone     = get_theme_mod( 'profile_phone', '+1 (555) 019-2834' );
$owner_location  = get_theme_mod( 'profile_location', 'San Francisco, CA' );
$response_time   = get_theme_mod( 'contact_response_time', 'Usually responds within 24 hours' );
$contact_intro   = get_theme_mod( 'contact_page_intro', 'Have an ambitious web project, architectural consultation, or performance audit in mind? Drop a message below to connect directly.' );
$profile_github  = get_theme_mod( 'profile_github', 'https://github.com' );
$profile_linkedin= get_theme_mod( 'profile_linkedin', 'https://linkedin.com' );
$profile_twitter = get_theme_mod( 'profile_twitter', 'https://twitter.com' );

get_header();
?>

<div class="content-container contact-page-container">

	<!-- Header Banner -->
	<header class="page-banner contact-page-header">
		<span class="glass-pill"><?php esc_html_e( 'Direct Inquiries & Advisory', 'ross-portfolio' ); ?></span>
		<h1 class="page-title"><?php the_title(); ?></h1>
		<p class="contact-lead-intro">
			<?php echo esc_html( $contact_intro ); ?>
		</p>
	</header>

	<!-- WordPress Gutenberg Content (if added in admin) -->
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
		<?php if ( get_the_content() ) : ?>
			<div class="page-entry-content" style="margin-bottom: 2.5rem;">
				<?php the_content(); ?>
			</div>
		<?php endif; ?>
	<?php endwhile; endif; ?>

	<!-- Contact Layout Grid -->
	<div class="contact-grid">

		<!-- Left Column: Direct Profile Details & Channels -->
		<aside class="contact-info-col" aria-label="<?php esc_attr_e( 'Direct Contact Channels', 'ross-portfolio' ); ?>">
			<div class="glass-card contact-channel-card">
				<div class="contact-status-header">
					<span class="status-indicator-ping" aria-hidden="true"></span>
					<span class="contact-status-text"><?php esc_html_e( 'Available for Select Contracts', 'ross-portfolio' ); ?></span>
				</div>

				<h2 class="contact-channel-title"><?php echo esc_html( $owner_name ); ?></h2>
				<p class="contact-channel-subtitle"><?php echo esc_html( $owner_title ); ?></p>

				<div class="contact-meta-list">
					<!-- Email -->
					<div class="contact-meta-item">
						<div class="contact-meta-icon" aria-hidden="true">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path><polyline points="22,6 12,13 2,6"></polyline></svg>
						</div>
						<div class="contact-meta-content">
							<span class="contact-meta-label"><?php esc_html_e( 'Direct Email', 'ross-portfolio' ); ?></span>
							<a href="<?php echo esc_url( 'mailto:' . antispambot( $owner_email ) ); ?>" class="contact-meta-val">
								<?php echo esc_html( antispambot( $owner_email ) ); ?>
							</a>
						</div>
					</div>

					<!-- Phone -->
					<?php if ( ! empty( $owner_phone ) ) : ?>
						<div class="contact-meta-item">
							<div class="contact-meta-icon" aria-hidden="true">
								<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
							</div>
							<div class="contact-meta-content">
								<span class="contact-meta-label"><?php esc_html_e( 'Direct Phone', 'ross-portfolio' ); ?></span>
								<a href="<?php echo esc_url( 'tel:' . preg_replace( '/[^0-9+]/', '', $owner_phone ) ); ?>" class="contact-meta-val">
									<?php echo esc_html( $owner_phone ); ?>
								</a>
							</div>
						</div>
					<?php endif; ?>

					<!-- Location -->
					<div class="contact-meta-item">
						<div class="contact-meta-icon" aria-hidden="true">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"></path><circle cx="12" cy="10" r="3"></circle></svg>
						</div>
						<div class="contact-meta-content">
							<span class="contact-meta-label"><?php esc_html_e( 'Base of Operations', 'ross-portfolio' ); ?></span>
							<span class="contact-meta-val"><?php echo esc_html( $owner_location ); ?></span>
						</div>
					</div>

					<!-- Response Commitment -->
					<div class="contact-meta-item">
						<div class="contact-meta-icon" aria-hidden="true">
							<svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg>
						</div>
						<div class="contact-meta-content">
							<span class="contact-meta-label"><?php esc_html_e( 'Response Time', 'ross-portfolio' ); ?></span>
							<span class="contact-meta-val" style="color: var(--accent-emerald);"><?php echo esc_html( $response_time ); ?></span>
						</div>
					</div>
				</div>

				<!-- Social Links -->
				<div class="contact-social-footer">
					<span class="contact-social-label"><?php esc_html_e( 'Connect & Follow', 'ross-portfolio' ); ?></span>
					<div class="hero-social-links" style="margin-top: 0.5rem;">
						<?php if ( ! empty( $profile_github ) ) : ?>
							<a href="<?php echo esc_url( $profile_github ); ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="<?php esc_attr_e( 'GitHub Profile', 'ross-portfolio' ); ?>">
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 19c-5 1.5-5-2.5-7-3m14 6v-3.87a3.37 3.37 0 0 0-.94-2.61c3.14-.35 6.44-1.54 6.44-7A5.44 5.44 0 0 0 20 4.77 5.07 5.07 0 0 0 19.91 1S18.73.65 16 2.48a13.38 13.38 0 0 0-7 0C6.27.65 5.09 1 5.09 1A5.07 5.07 0 0 0 5 4.77a5.44 5.44 0 0 0-1.5 3.78c0 5.42 3.3 6.61 6.44 7A3.37 3.37 0 0 0 9 18.13V22"></path></svg>
							</a>
						<?php endif; ?>
						<?php if ( ! empty( $profile_linkedin ) ) : ?>
							<a href="<?php echo esc_url( $profile_linkedin ); ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="<?php esc_attr_e( 'LinkedIn Profile', 'ross-portfolio' ); ?>">
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 8a6 6 0 0 1 6 6v7h-4v-7a2 2 0 0 0-2-2 2 2 0 0 0-2 2v7h-4v-7a6 6 0 0 1 6-6z"></path><rect x="2" y="9" width="4" height="12"></rect><circle cx="4" cy="4" r="2"></circle></svg>
							</a>
						<?php endif; ?>
						<?php if ( ! empty( $profile_twitter ) ) : ?>
							<a href="<?php echo esc_url( $profile_twitter ); ?>" target="_blank" rel="noopener noreferrer" class="social-icon-btn" aria-label="<?php esc_attr_e( 'Twitter / X Profile', 'ross-portfolio' ); ?>">
								<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z"></path></svg>
							</a>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</aside>

		<!-- Right Column: Interactive Contact Form -->
		<main class="contact-form-col" aria-label="<?php esc_attr_e( 'Send a Message', 'ross-portfolio' ); ?>">
			<div class="glass-card contact-form-card">
				<h2 class="contact-form-title"><?php esc_html_e( 'Send a Direct Message', 'ross-portfolio' ); ?></h2>
				<p class="contact-form-desc"><?php esc_html_e( 'Fill out the form below. Zero spam, zero third-party trackers.', 'ross-portfolio' ); ?></p>

				<!-- Alert Messages -->
				<?php if ( $form_success ) : ?>
					<div class="form-alert form-alert-success" role="alert" tabindex="-1">
						<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
						<div>
							<strong><?php esc_html_e( 'Inquiry Transmitted Successfully!', 'ross-portfolio' ); ?></strong>
							<p style="margin: 0.25rem 0 0; font-size: 0.95rem;"><?php esc_html_e( 'Thank you for reaching out. I will review your message and reply promptly within 24 hours.', 'ross-portfolio' ); ?></p>
						</div>
					</div>
				<?php elseif ( ! empty( $form_errors ) ) : ?>
					<div class="form-alert form-alert-error" role="alert" tabindex="-1">
						<svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="12"></line><line x1="12" y1="16" x2="12.01" y2="16"></line></svg>
						<div>
							<strong><?php esc_html_e( 'Please correct the following errors:', 'ross-portfolio' ); ?></strong>
							<ul style="margin: 0.25rem 0 0; padding-left: 1.25rem; font-size: 0.95rem;">
								<?php foreach ( $form_errors as $error_item ) : ?>
									<li><?php echo esc_html( $error_item ); ?></li>
								<?php endforeach; ?>
							</ul>
						</div>
					</div>
				<?php endif; ?>

				<!-- Form Element -->
				<form method="post" action="<?php echo esc_url( get_permalink() ); ?>" class="ross-contact-form" novalidate>
					<?php wp_nonce_field( 'ross_portfolio_contact_action', 'ross_portfolio_contact_nonce' ); ?>

					<!-- Honeypot Field (Spam prevention without CAPTCHA) -->
					<div class="visually-hidden" aria-hidden="true" style="display:none !important; visibility:hidden !important;">
						<label for="contact_secondary_verification"><?php esc_html_e( 'Leave this field blank', 'ross-portfolio' ); ?></label>
						<input type="text" name="contact_secondary_verification" id="contact_secondary_verification" tabindex="-1" autocomplete="off">
					</div>

					<!-- Row 1: Name & Email -->
					<div class="form-row form-row-2col">
						<div class="form-group <?php echo isset( $form_errors['contact_name'] ) ? 'has-error' : ''; ?>">
							<label for="contact_name" class="form-label">
								<?php esc_html_e( 'Your Name', 'ross-portfolio' ); ?> <span class="required" aria-hidden="true">*</span>
							</label>
							<input
								type="text"
								name="contact_name"
								id="contact_name"
								class="form-input"
								placeholder="<?php esc_attr_e( 'e.g. Jane Doe', 'ross-portfolio' ); ?>"
								value="<?php echo esc_attr( $posted_data['contact_name'] ); ?>"
								required
								aria-required="true"
								<?php echo isset( $form_errors['contact_name'] ) ? 'aria-invalid="true" aria-describedby="error_contact_name"' : ''; ?>
							>
							<?php if ( isset( $form_errors['contact_name'] ) ) : ?>
								<span id="error_contact_name" class="field-error-msg"><?php echo esc_html( $form_errors['contact_name'] ); ?></span>
							<?php endif; ?>
						</div>

						<div class="form-group <?php echo isset( $form_errors['contact_email'] ) ? 'has-error' : ''; ?>">
							<label for="contact_email" class="form-label">
								<?php esc_html_e( 'Email Address', 'ross-portfolio' ); ?> <span class="required" aria-hidden="true">*</span>
							</label>
							<input
								type="email"
								name="contact_email"
								id="contact_email"
								class="form-input"
								placeholder="<?php esc_attr_e( 'e.g. jane@company.com', 'ross-portfolio' ); ?>"
								value="<?php echo esc_attr( $posted_data['contact_email'] ); ?>"
								required
								aria-required="true"
								<?php echo isset( $form_errors['contact_email'] ) ? 'aria-invalid="true" aria-describedby="error_contact_email"' : ''; ?>
							>
							<?php if ( isset( $form_errors['contact_email'] ) ) : ?>
								<span id="error_contact_email" class="field-error-msg"><?php echo esc_html( $form_errors['contact_email'] ); ?></span>
							<?php endif; ?>
						</div>
					</div>

					<!-- Row 2: Service & Scope/Budget -->
					<div class="form-row form-row-2col">
						<div class="form-group">
							<label for="contact_service" class="form-label">
								<?php esc_html_e( 'Area of Interest / Service', 'ross-portfolio' ); ?>
							</label>
							<select name="contact_service" id="contact_service" class="form-select">
								<option value=""><?php esc_html_e( 'Select an Option...', 'ross-portfolio' ); ?></option>
								<option value="Enterprise WordPress Theme Engineering" <?php selected( $posted_data['contact_service'], 'Enterprise WordPress Theme Engineering' ); ?>><?php esc_html_e( 'Enterprise WordPress Theme Engineering', 'ross-portfolio' ); ?></option>
								<option value="Front-End Performance Audit & Core Web Vitals" <?php selected( $posted_data['contact_service'], 'Front-End Performance Audit & Core Web Vitals' ); ?>><?php esc_html_e( 'Front-End Performance Audit & Core Web Vitals', 'ross-portfolio' ); ?></option>
								<option value="Design System & Glassmorphism UI" <?php selected( $posted_data['contact_service'], 'Design System & Glassmorphism UI' ); ?>><?php esc_html_e( 'Design System & Glassmorphism UI', 'ross-portfolio' ); ?></option>
								<option value="WCAG 2.2 AA Accessibility Remediation" <?php selected( $posted_data['contact_service'], 'WCAG 2.2 AA Accessibility Remediation' ); ?>><?php esc_html_e( 'WCAG 2.2 AA Accessibility Remediation', 'ross-portfolio' ); ?></option>
								<option value="Architecture Advisory / Fractional Lead" <?php selected( $posted_data['contact_service'], 'Architecture Advisory / Fractional Lead' ); ?>><?php esc_html_e( 'Architecture Advisory / Fractional Lead', 'ross-portfolio' ); ?></option>
								<option value="General Technical Inquiry" <?php selected( $posted_data['contact_service'], 'General Technical Inquiry' ); ?>><?php esc_html_e( 'General Technical Inquiry', 'ross-portfolio' ); ?></option>
							</select>
						</div>

						<div class="form-group">
							<label for="contact_budget" class="form-label">
								<?php esc_html_e( 'Project Scope / Budget', 'ross-portfolio' ); ?>
							</label>
							<select name="contact_budget" id="contact_budget" class="form-select">
								<option value=""><?php esc_html_e( 'Select Budget Range...', 'ross-portfolio' ); ?></option>
								<option value="Under $5k (Audit / Quick Consultation)" <?php selected( $posted_data['contact_budget'], 'Under $5k (Audit / Quick Consultation)' ); ?>><?php esc_html_e( 'Under $5k (Audit / Consultation)', 'ross-portfolio' ); ?></option>
								<option value="$5k - $15k (Standard Theme / Feature Build)" <?php selected( $posted_data['contact_budget'], '$5k - $15k (Standard Theme / Feature Build)' ); ?>><?php esc_html_e( '$5k - $15k (Standard Build)', 'ross-portfolio' ); ?></option>
								<option value="$15k - $30k (Full Platform Architecture)" <?php selected( $posted_data['contact_budget'], '$15k - $30k (Full Platform Architecture)' ); ?>><?php esc_html_e( '$15k - $30k (Full Platform Architecture)', 'ross-portfolio' ); ?></option>
								<option value="$30k+ (Enterprise Multi-Month Contract)" <?php selected( $posted_data['contact_budget'], '$30k+ (Enterprise Multi-Month Contract)' ); ?>><?php esc_html_e( '$30k+ (Enterprise Contract)', 'ross-portfolio' ); ?></option>
							</select>
						</div>
					</div>

					<!-- Row 3: Subject -->
					<div class="form-group">
						<label for="contact_subject" class="form-label">
							<?php esc_html_e( 'Subject / Project Name', 'ross-portfolio' ); ?>
						</label>
						<input
							type="text"
							name="contact_subject"
							id="contact_subject"
							class="form-input"
							placeholder="<?php esc_attr_e( 'e.g. Next-Gen Headless / Classic WordPress Migration', 'ross-portfolio' ); ?>"
							value="<?php echo esc_attr( $posted_data['contact_subject'] ); ?>"
						>
					</div>

					<!-- Row 4: Message Area -->
					<div class="form-group <?php echo isset( $form_errors['contact_message'] ) ? 'has-error' : ''; ?>">
						<label for="contact_message" class="form-label">
							<?php esc_html_e( 'Project Overview / Message', 'ross-portfolio' ); ?> <span class="required" aria-hidden="true">*</span>
						</label>
						<textarea
							name="contact_message"
							id="contact_message"
							rows="5"
							class="form-textarea"
							placeholder="<?php esc_attr_e( 'Tell me about your project goals, technical constraints, timeline, and deliverables...', 'ross-portfolio' ); ?>"
							required
							aria-required="true"
							<?php echo isset( $form_errors['contact_message'] ) ? 'aria-invalid="true" aria-describedby="error_contact_message"' : ''; ?>
						><?php echo esc_textarea( $posted_data['contact_message'] ); ?></textarea>
						<?php if ( isset( $form_errors['contact_message'] ) ) : ?>
							<span id="error_contact_message" class="field-error-msg"><?php echo esc_html( $form_errors['contact_message'] ); ?></span>
						<?php endif; ?>
					</div>

					<!-- Submit Button -->
					<div class="form-submit-row">
						<button type="submit" name="ross_portfolio_contact_submit" class="btn-primary form-submit-btn">
							<svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg>
							<span><?php esc_html_e( 'Send Direct Inquiry', 'ross-portfolio' ); ?></span>
						</button>
						<span class="form-privacy-note">
							<svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"></rect><path d="M7 11V7a5 5 0 0 1 10 0v4"></path></svg>
							<?php esc_html_e( 'Zero third-party trackers. Data processed privately on server.', 'ross-portfolio' ); ?>
						</span>
					</div>
				</form>
			</div>
		</main>

	</div>

</div>

<?php
get_footer();
