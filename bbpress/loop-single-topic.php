<?php
/**
 * Topics Loop - Single
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div id="bbp-topic-<?php bbp_topic_id(); ?>" <?php bbp_topic_class( 0, [ 'thisisyyz__container' ] ); ?>>


	<?php if ( bbp_is_user_home() ) : ?>

		<?php if ( bbp_is_favorites() ) : ?>

			<span class="bbp-row-actions">

					<?php do_action( 'bbp_theme_before_topic_favorites_action' ); ?>

					<?php
					bbp_topic_favorite_link(
						[
							'before'    => '',
							'favorite'  => '+',
							'favorited' => '&times;',
						]
					);
					?>

					<?php do_action( 'bbp_theme_after_topic_favorites_action' ); ?>

				</span>

		<?php elseif ( bbp_is_subscriptions() ) : ?>

			<span class="bbp-row-actions">

					<?php do_action( 'bbp_theme_before_topic_subscription_action' ); ?>

					<?php
					bbp_topic_subscription_link(
						[
							'before'      => '',
							'subscribe'   => '+',
							'unsubscribe' => '&times;',
						]
					);
					?>

					<?php do_action( 'bbp_theme_after_topic_subscription_action' ); ?>

				</span>

		<?php endif; ?>

	<?php endif; ?>


	<?php if ( ! bbp_is_single_forum() || ( bbp_get_topic_forum_id() !== bbp_get_forum_id() ) ) : ?>

		<?php do_action( 'bbp_theme_before_topic_started_in' ); ?>

		<div class="bbp-topic-started-in">
			<?php
			printf(
				/* translators: 1: Forum Permalink, 2: Forum Title */
				__( 'in: <a href="%1$s">%2$s</a>', 'bbpress' ),
				esc_html( bbp_get_forum_permalink( bbp_get_topic_forum_id() ) ),
				esc_html( bbp_get_forum_title( bbp_get_topic_forum_id() ) )
			);
			?>
		</div>

		<?php do_action( 'bbp_theme_after_topic_started_in' ); ?>

	<?php endif; ?>


	<div class="thisisyyz__column-1">

		<?php do_action( 'bbp_theme_before_topic_meta' ); ?>


		<?php do_action( 'bbp_theme_before_topic_started_by' ); ?>

		<span class="thisisyyz__author"><?php bbp_topic_author_link( [ 'sep' => '' ] ); ?></span>

		<?php do_action( 'bbp_theme_after_topic_started_by' ); ?>


		<?php do_action( 'bbp_theme_after_topic_meta' ); ?>

		<?php bbp_topic_row_actions(); ?>

	</div>


	<div class="thisisyyz__column-2">

		<?php do_action( 'bbp_theme_before_topic_title' ); ?>

		<div class="thisisyyz__message-container">
			<div class="thisisyyz__message">
				<div class="thisisyyz__message__bubble" onclick="location.href='<?php bbp_topic_permalink(); ?>'"></div>

				<span class="thisisyyz__message__text">
					<span><?php bbp_topic_title(); ?></span>
				</span>
			</div>
		</div>

		<?php do_action( 'bbp_theme_after_topic_title' ); ?>

		<div class="thisisyyz__reply-counter">
			<span class="bbp-topic-reply-count"><a title="<?php thisisyyz_topic_last_reply_date(); ?>" href="<?php bbp_topic_last_reply_url(); ?>"><?php thisisyyz_topics_reply_count(); ?></a></span>
		</div>


		<div class="thisisyyz__created">
				<span title="<?php bbp_reply_post_date( bbp_get_topic_id() ); ?>">
					<?php bbp_reply_post_date( bbp_get_topic_id(), true ); ?>
				</span>
		</div>
		<?php if ( current_user_can( 'edit_others_topics' ) ) : ?>
			<div class="thisisyyz__admin-links">
				<?php do_action( 'bbp_theme_before_topic_admin_links' ); ?>

				<?php bbp_topic_admin_links(); ?>

				<?php do_action( 'bbp_theme_after_topic_admin_links' ); ?>
			</div>
		<?php endif; ?>
	</div>


	<div class="thisisyyz__column-3"></div>

</div><!-- #bbp-topic-<?php bbp_topic_id(); ?> -->
