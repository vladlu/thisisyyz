<?php


/*--------------------------------------------------------------
				CONSTANTS
--------------------------------------------------------------*/

/*
 * Theme Version
 */
define('THISISYYZ_VERSION', wp_get_theme()->get('Version') );


/*--------------------------------------------------------------
				ACTIONS
--------------------------------------------------------------*/


/**
 * Loads parent themes's style.css.
 *
 * I see no reasons to follow Codex here and load child's style.css twice (It makes CSS debugging with browser harder).
 * https://developer.wordpress.org/themes/advanced-topics/child-themes/#3-enqueue-stylesheet
 */
add_action( 'wp_enqueue_scripts', 'thisisyyz_enqueue_styles' );
function thisisyyz_enqueue_styles() {
	wp_enqueue_style( 'thisisyyz-parent-style', get_template_directory_uri() . '/style.css', [], THISISYYZ_VERSION );
}


/**
 * Loads scripts
 */
add_action( 'wp_enqueue_scripts', 'thisisyyz_enqueue_scripts' );
function thisisyyz_enqueue_scripts() {

	/* Script.js */
	wp_enqueue_script( 'thisisyyz-script', get_stylesheet_directory_uri() . '/js/script.js', [ 'jquery' ], THISISYYZ_VERSION );

	/* Lightbox.js */
	wp_enqueue_script( 'thisisyyz-lightbox', get_stylesheet_directory_uri() . '/js/lightbox.js', [ 'jquery', 'jquery-ui-draggable' ], THISISYYZ_VERSION );
}


/**
 * Loads admin scripts
 */
add_action( 'admin_enqueue_scripts', 'thisisyyz_admin_enqueue_scripts' );
function thisisyyz_admin_enqueue_scripts() {
	wp_enqueue_script( 'thisisyyz-admin-script', get_stylesheet_directory_uri() . '/js/admin-script.js', [ 'jquery' ], THISISYYZ_VERSION );
}


/*--------------------------------------------------------------
				FILTERS
--------------------------------------------------------------*/


/**
 * Show Lead Topic
 */
add_filter( 'bbp_show_lead_topic', '__return_true' );


/**
 * Disables Replies and Topics Revision Log (This theme doesn't support them).
 */
add_filter( 'bbp_allow_revisions',        '__return_false' );
add_filter( 'bbp_get_reply_revision_log', '__return_null' );
add_filter( 'bbp_get_topic_revision_log', '__return_null' );


/**
 * We don't need an empty span tag.
 */
add_filter( 'bbp_get_topic_admin_links', 'thisisyyz_all_or_nothing', 10, 2 );
add_filter( 'bbp_get_reply_admin_links', 'thisisyyz_all_or_nothing', 10, 2 );
function thisisyyz_all_or_nothing( $retval, $r ) {
	foreach ( $r['links'] as $link) {
		if ( $link ) {
			return $retval; // The function will print nothing instead of the empty span.
		}
	}
	return;
}


/*--------------------------------------------------------------
				FUNCTIONS
--------------------------------------------------------------*/


/**
 * Prints the number of replies in the topic
 */
function thisisyyz_topics_reply_count() {
	$reply_count = bbp_get_topic_reply_count();

	if ($reply_count) {
		printf( _n(
			'<span class="thisisyyz__reply-count-number">%s</span> <span class="thisisyyz__reply-count-text">REPLY</span>',
			'<span class="thisisyyz__reply-count-number">%s</span> <span class="thisisyyz__reply-count-text">REPLIES</span>',
			$reply_count ), $reply_count );
	// No replies yet
	} else {
		echo '<span class="thisisyyz__reply-count-nothing"> — </span>';
	}
}


/**
 * Prints the date of the last reply in the topic
 */
function thisisyyz_topic_last_reply_date() {
	if ( bbp_get_topic_reply_count() ) {
		echo 'Last reply was ' . bbp_get_topic_last_active_time();
	} else {
		echo 'No replies yet';
	}
}


/**
* Gets reply_to URL
 *
 * Triggers the function and then gets URL with the filter and prints it.
 */
function thisisyyz_reply_to_url() {
	add_filter( 'bbp_get_reply_to_link', 'thisisyyz_reply_to_url_handler', 10, 2 );

	bbp_get_reply_to_link( [ 'id' =>  bbp_get_reply_id() ] );
}
function thisisyyz_reply_to_url_handler( $retval, $r ) {
	echo $r['uri'];

	remove_action( 'bbp_get_reply_to_link', 'thisisyyz_reply_to_url_handler' );
}
