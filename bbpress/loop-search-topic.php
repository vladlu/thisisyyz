<?php
/**
 * Search Loop - Single Topic
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div class="thisisyyz__search__container">

	<div class="bbp-topic-header">

		<div class="bbp-topic-title">

			<?php do_action( 'bbp_theme_before_topic_title' ); ?>

			<h3><?php esc_html_e( 'Topic: ', 'bbpress' ); ?>
			<a href="<?php bbp_topic_permalink(); ?>"><?php bbp_topic_title(); ?></a></h3>

			<div class="bbp-topic-title-meta">

				<?php if ( function_exists( 'bbp_is_forum_group_forum' ) && bbp_is_forum_group_forum( bbp_get_topic_forum_id() ) ) : ?>

					<?php esc_html_e( 'in group forum ', 'bbpress' ); ?>

				<?php else : ?>

					<?php esc_html_e( 'in forum ', 'bbpress' ); ?>

				<?php endif; ?>

				<a href="<?php bbp_forum_permalink( bbp_get_topic_forum_id() ); ?>"><?php bbp_forum_title( bbp_get_topic_forum_id() ); ?></a>

			</div><!-- .bbp-topic-title-meta -->

			<?php do_action( 'bbp_theme_after_topic_title' ); ?>

		</div><!-- .bbp-topic-title -->

	</div><!-- .bbp-topic-header -->



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
					<div class="thisisyyz__message__bubble" onclick="location.href='<?php bbp_topic_permalink(); ?>'"></div>

					<span class="thisisyyz__message__text">
							<?php bbp_topic_content(); ?>
						</span>
				</div>
			</div>

			<?php do_action( 'bbp_theme_after_topic_content' ); ?>


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

</div>
