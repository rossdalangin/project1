<?php
/**
 * Comments Template
 *
 * @package RossPortfolio
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area glass-card" style="padding: 2.5rem; margin-top: 3rem;">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title" style="font-size: 1.5rem; margin-bottom: 1.5rem; color: #FFFFFF;">
			<?php
			$ross_portfolio_comment_count = get_comments_number();
			if ( '1' === $ross_portfolio_comment_count ) {
				printf(
					/* translators: 1: title. */
					esc_html__( 'One thought on &ldquo;%1$s&rdquo;', 'ross-portfolio' ),
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			} else {
				printf(
					/* translators: 1: comment count number, 2: title. */
					esc_html( _nx( '%1$s thought on &ldquo;%2$s&rdquo;', '%1$s thoughts on &ldquo;%2$s&rdquo;', $ross_portfolio_comment_count, 'comments title', 'ross-portfolio' ) ),
					number_format_i18n( $ross_portfolio_comment_count ), // phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
					'<span>' . wp_kses_post( get_the_title() ) . '</span>'
				);
			}
			?>
		</h2>

		<ol class="comment-list">
			<?php
			wp_list_comments(
				array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 48,
				)
			);
			?>
		</ol>

		<?php
		the_comments_navigation(
			array(
				'prev_text' => __( '&laquo; Older Comments', 'ross-portfolio' ),
				'next_text' => __( 'Newer Comments &raquo;', 'ross-portfolio' ),
			)
		);

		if ( ! comments_open() ) :
			?>
			<p class="no-comments" style="color: var(--text-subtle); font-style: italic; margin-top: 1rem;"><?php esc_html_e( 'Comments are closed.', 'ross-portfolio' ); ?></p>
			<?php
		endif;

	endif;

	comment_form(
		array(
			'class_container'    => 'comment-respond',
			'class_form'         => 'comment-form',
			'title_reply_before' => '<h3 id="reply-title" class="comment-reply-title" style="font-size: 1.25rem; color: #FFFFFF; margin-bottom: 1rem;">',
			'title_reply_after'  => '</h3>',
			'submit_button'      => '<button name="%1$s" type="submit" id="%2$s" class="%3$s btn btn-primary">%4$s</button>',
			'class_submit'       => 'btn btn-primary',
		)
	);
	?>

</div><!-- #comments -->
