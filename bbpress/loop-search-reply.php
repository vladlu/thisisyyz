<?php
/**
 * Search Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div class="thisisyyz__search__container">

	<div class="bbp-reply-header">

		<div class="bbp-reply-title">

			<h3><?php esc_html_e( 'In reply to: ', 'bbpress' ); ?>
			<a class="bbp-topic-permalink" href="<?php bbp_topic_permalink( bbp_get_reply_topic_id() ); ?>"><?php bbp_topic_title( bbp_get_reply_topic_id() ); ?></a></h3>

		</div><!-- .bbp-reply-title -->

	</div><!-- .bbp-reply-header -->


	<div id="post-<?php bbp_reply_id(); ?>" <?php bbp_reply_class( 0, [ 'thisisyyz__container' ] ); ?>>

		<div class="thisisyyz__column-1">
				<?php do_action( 'bbp_theme_before_reply_author_details' ); ?>

				<span class="thisisyyz__author"><?php bbp_reply_author_link( [ 'sep' => '' ] ); ?></span>

				<?php do_action( 'bbp_theme_after_reply_author_details' ); ?>
		</div>


		<div class="thisisyyz__column-2">

			<?php do_action( 'bbp_theme_before_reply_content' ); ?>

			<div class="thisisyyz__message-container">
				<div class="thisisyyz__message">
					<div class="thisisyyz__message__bubble" onclick="location.href='<?php bbp_reply_url(); ?>'"></div>

					<span class="thisisyyz__message__text">
						<?php bbp_reply_content(); ?>
					</span>
				</div>
			</div>

			<?php do_action( 'bbp_theme_after_reply_content' ); ?>



			<div class="thisisyyz__created">
				<span title="<?php bbp_reply_post_date(); ?>"><?php bbp_reply_post_date( 0, true ); ?></span>
			</div>

			<?php if ( current_user_can( 'edit_others_replies' ) ) : ?>
				<div class="thisisyyz__admin-links">
					<?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>

					<?php bbp_reply_admin_links(); ?>

					<?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>
				</div>
			<?php endif; ?>

		</div>

	</div><!-- #post-<?php bbp_reply_id(); ?> -->

</div>
