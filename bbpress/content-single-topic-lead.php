<?php
/**
 * Single Topic Lead Content Part
 *
 * @package bbPress
 * @subpackage Theme
 */

?>


<?php do_action( 'bbp_template_before_lead_topic' ); ?>

<div class="thisisyyz__buttons">
	<?php
	bbp_breadcrumb(
		[
			'include_home'    => false,
			'include_current' => false,
			'root_text'       => 'Chats',
		]
	);
	?>

	<div class="thisisyyz-reply__buttons-right">

		<?php bbp_topic_favorite_link(); ?>
		<?php bbp_topic_subscription_link(); ?>

	</div>
</div>


<div class="thisisyyz__topic-lead-left-block">
	<div class="thisisyyz__the-title thisisyyz__the-title__topic-lead">
		<?php bbp_topic_title(); ?>
	</div>
</div>


<div id="bbp-topic-<?php bbp_topic_id(); ?>-lead" class="bbp-lead-topic">

	<div class="bbp-body">

		<div id="post-<?php bbp_topic_id(); ?>" <?php bbp_topic_class( 0, [ 'thisisyyz__container' ] ); ?>>


			<div class="thisisyyz__column-1">

				<?php do_action( 'bbp_theme_before_topic_started_by' ); ?>

				<span class="thisisyyz__author"><?php bbp_topic_author_link( [ 'sep' => '' ] ); ?></span>

				<?php do_action( 'bbp_theme_after_topic_started_by' ); ?>

			</div>

			<div class="thisisyyz__column-2">

				<?php do_action( 'bbp_theme_before_topic_content' ); ?>

				<div class="thisisyyz__message-container">
					<div class="thisisyyz__message">
						<div class="thisisyyz__message__bubble" onclick="location.href='#new-post'"></div>

						<span class="thisisyyz__message__text">
							<?php bbp_topic_content(); ?>
						</span>
					</div>
				</div>

				<?php do_action( 'bbp_theme_after_topic_content' ); ?>

				<div class="thisisyyz__reply-counter">
					<span class="bbp-topic-reply-count"><a title="<?php esc_attr_e( 'Reply!' ); ?>" href="#new-post"><?php thisisyyz_topics_reply_count(); ?></a></span>
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

		</div><!-- #post-<?php bbp_topic_id(); ?> -->

	</div><!-- .bbp-body -->

</div><!-- #bbp-topic-<?php bbp_topic_id(); ?>-lead -->

<?php do_action( 'bbp_template_after_lead_topic' ); ?>
