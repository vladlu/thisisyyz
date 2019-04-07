<?php

/**
 * Replies Loop - Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

?>

<div id="post-<?php bbp_reply_id(); ?>" <?php bbp_reply_class( 0, ['thisisyyz__container'] ); ?>>

    <div class="thisisyyz__column-1">
	        <?php do_action( 'bbp_theme_before_reply_author_details' ); ?>

            <span class="thisisyyz__author"><?php bbp_reply_author_link( array( 'sep' => '' ) ); ?></span>

	        <?php do_action( 'bbp_theme_after_reply_author_details' ); ?>
    </div>


    <div class="thisisyyz__column-2">

	    <?php do_action( 'bbp_theme_before_reply_content' ); ?>

        <div class="thisisyyz__message-container">
            <div class="thisisyyz__message">
                <div class="thisisyyz__message__bubble" onclick="location.href='<?php thisisyyz_reply_to_url(); ?>'"></div>

                <span class="thisisyyz__message__text">
                    <?php bbp_reply_content(); ?>
                </span>
            </div>
        </div>

	    <?php do_action( 'bbp_theme_after_reply_content' ); ?>



        <div class="thisisyyz__created">
            <span title="<?php bbp_reply_post_date() ?>"><?php bbp_reply_post_date( 0, true ) ?></span>
        </div>

	    <?php if ( current_user_can( 'edit_others_replies' ) ): ?>
            <div class="thisisyyz__admin-links">
                <?php do_action( 'bbp_theme_before_reply_admin_links' ); ?>

                <?php bbp_reply_admin_links(); ?>

                <?php do_action( 'bbp_theme_after_reply_admin_links' ); ?>
            </div>
        <?php endif; ?>

    </div>

</div><!-- #post-<?php bbp_reply_id(); ?> -->
