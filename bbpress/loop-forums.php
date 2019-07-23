<?php
/**
 * Forums Loop
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<?php do_action( 'bbp_template_before_forums_loop' ); ?>

<ul id="forums-list-<?php bbp_forum_id(); ?>" class="bbp-forums">

	<li class="thisisyyz__forum-header">

		<div class="forum-titles">
			<div class="bbp-forum-info"><?php esc_html_e( 'Chats' ); ?></div>
			<div class="bbp-forum-topic-count"><?php esc_html_e( 'Topics', 'bbpress' ); ?></div>
			<div class="bbp-forum-reply-count">
				<?php
					bbp_show_lead_topic() ?
						esc_html_e( 'Replies', 'bbpress' ) :
						esc_html_e( 'Posts', 'bbpress' );
				?>
			</div>
		</div>

	</li><!-- .bbp-header -->

	<li class="thisisyyz__forum-body">

		<?php
		while ( bbp_forums() ) :
			bbp_the_forum();
			?>

			<?php bbp_get_template_part( 'loop', 'single-forum' ); ?>

		<?php endwhile; ?>

	</li><!-- .bbp-body -->

</ul><!-- .forums-directory -->

<?php do_action( 'bbp_template_after_forums_loop' ); ?>
