<?php
/**
 * Forums Loop - Single Forum
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div onclick="location.href='<?php bbp_forum_permalink(); ?>'" id="bbp-forum-<?php bbp_forum_id(); ?>" <?php bbp_forum_class(); ?>>

	<div class="bbp-forum-info">

		<?php if ( bbp_is_user_home() && bbp_is_subscriptions() ) : ?>

			<span class="bbp-row-actions">

				<?php do_action( 'bbp_theme_before_forum_subscription_action' ); ?>

				<?php
				bbp_forum_subscription_link(
					[
						'before'      => '',
						'subscribe'   => '+',
						'unsubscribe' => '&times;',
					]
				);
				?>

				<?php do_action( 'bbp_theme_after_forum_subscription_action' ); ?>

			</span>

		<?php endif; ?>

		<?php do_action( 'bbp_theme_before_forum_title' ); ?>

		<div class="bbp-forum-title"><?php bbp_forum_title(); ?></div>

		<?php do_action( 'bbp_theme_after_forum_title' ); ?>

		<?php do_action( 'bbp_theme_before_forum_description' ); ?>

		<div class="bbp-forum-content"><?php bbp_forum_content(); ?></div>

		<?php do_action( 'bbp_theme_after_forum_description' ); ?>

		<?php do_action( 'bbp_theme_before_forum_sub_forums' ); ?>

		<?php bbp_list_forums(); ?>

		<?php do_action( 'bbp_theme_after_forum_sub_forums' ); ?>

		<?php bbp_forum_row_actions(); ?>

	</div>

	<div class="bbp-forum-topic-count">
		<i class="fa fa-comment-o" aria-hidden="true"></i>
		<?php bbp_forum_topic_count(); ?>
	</div>

	<div class="bbp-forum-reply-count">
		<i class="fa fa-comments-o" aria-hidden="true"></i>
		<?php bbp_show_lead_topic() ? bbp_forum_reply_count() : bbp_forum_post_count(); ?>
	</div>

</div><!-- #bbp-forum-<?php bbp_forum_id(); ?> -->
