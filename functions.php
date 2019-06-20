<?php
/**
 * Functions file that contains all main routine
 *
 * @package thisisyyz
 * @since 1.0.0
 */



/**
 * Loads constants.
 *
 * @since 1.0.0
 */
function thisisyyz_load_constants() {

	/**
	 * The URL to the theme.
	 *
	 * @since 1.0.0
	 * @var string THISISYYZ_URL
	 */
	define( 'THISISYYZ_URL', get_stylesheet_directory_uri() . '/' );


	/**
	 * The version of the theme.
	 *
	 * @since 1.0.0
	 * @var string THISISYYZ_VERSION
	 */
	define( 'THISISYYZ_VERSION', wp_get_theme()->get('Version') );
}
thisisyyz_load_constants();




/**
 * Loads style.css of the parent theme.
 *
 * I see no reasons to follow Codex here and load child's style.css twice (It makes CSS debugging with browser harder).
 * https://developer.wordpress.org/themes/advanced-topics/child-themes/#3-enqueue-stylesheet
 *
 * @since 1.0.0
 */
function thisisyyz_enqueue_styles() {
	$assets_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';

	wp_enqueue_style( 'thisisyyz-parent-style', get_template_directory_uri() . '/style' . $assets_suffix . '.css', [], THISISYYZ_VERSION );
}
add_action( 'wp_enqueue_scripts', 'thisisyyz_enqueue_styles' );


/**
 * Loads public scripts.
 *
 * @since 1.0.0
 */
function thisisyyz_enqueue_scripts() {
	$assets_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';


	/*
	 * JS
	 */
	wp_enqueue_script(
		'thisisyyz-script',
		THISISYYZ_URL . 'js/script' . $assets_suffix . '.js',
		[ 'jquery' ],
		THISISYYZ_VERSION
	);


	/*
	 * Babel Polyfill
	 */
	wp_enqueue_script(
		'thisisyyz-script-babel-polyfill',
		THISISYYZ_URL . 'libs/babel-polyfill/babel-polyfill.js',
		[],
		THISISYYZ_VERSION
	);


	/*
	 * Lightbox.js
	 */
	wp_enqueue_script(
		'thisisyyz-lightbox',
		THISISYYZ_URL . 'js/lightbox.js',
		[ 'jquery', 'jquery-ui-draggable' ],
		THISISYYZ_VERSION
	);
}
add_action( 'wp_enqueue_scripts', 'thisisyyz_enqueue_scripts' );


/**
 * Loads admin scripts.
 *
 * @since 1.0.0
 */
function thisisyyz_admin_enqueue_scripts() {
	$assets_suffix = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ? '' : '.min';


	/*
	 * JS
	 */
	wp_enqueue_script(
		'thisisyyz-admin-script',
		THISISYYZ_URL . 'js/admin-script' . $assets_suffix . '.js',
		[ 'jquery' ],
		THISISYYZ_VERSION
	);


	/*
	 * Babel Polyfill
	 */
	wp_enqueue_script(
		'thisisyyz-script-babel-polyfill',
		THISISYYZ_URL . 'libs/babel-polyfill/babel-polyfill.js',
		[],
		THISISYYZ_VERSION
	);
}
add_action( 'admin_enqueue_scripts', 'thisisyyz_admin_enqueue_scripts' );




/**
 * Show lead topic.
 *
 * @since 1.0.0
 */
add_filter( 'bbp_show_lead_topic', '__return_true' );


/**
 * Disables replies and topics revision log (Because this theme doesn't support them).
 *
 * @since 1.0.0
 */
add_filter( 'bbp_allow_revisions',        '__return_false' );
add_filter( 'bbp_get_reply_revision_log', '__return_null' );
add_filter( 'bbp_get_topic_revision_log', '__return_null' );


/**
 * We don't need an empty span tag.
 *
 * The function will print nothing instead of the empty span.
 *
 * @since 1.0.0
 *
 * @param string $retval
 * @param array  $r
 * @return mixed
 */
function thisisyyz_all_or_nothing( $retval, $r ) {
	foreach ( $r['links'] as $link) {
		if ( $link ) {
			return $retval;
		}
	}
	return;
}
add_filter( 'bbp_get_topic_admin_links', 'thisisyyz_all_or_nothing', 10, 2 );
add_filter( 'bbp_get_reply_admin_links', 'thisisyyz_all_or_nothing', 10, 2 );




/**
 * Prints the number of replies for the topic.
 *
 * @since 1.0.0
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
 * Prints the date of the last reply in the topic.
 *
 * @since 1.0.0
 */
function thisisyyz_topic_last_reply_date() {
	if ( bbp_get_topic_reply_count() ) {
		echo 'Last reply was ' . bbp_get_topic_last_active_time();
	} else {
		echo 'No replies yet';
	}
}


/**
 * Gets "reply_to" URL.
 *
 * Triggers the function and then gets the URL with the filter and prints it.
 *
 * @since 1.0.0
 */
function thisisyyz_reply_to_url() {
	add_filter( 'bbp_get_reply_to_link', 'thisisyyz_reply_to_url_handler', 10, 2 );

	bbp_get_reply_to_link( [ 'id' =>  bbp_get_reply_id() ] );
}


/**
 * Prints "reply_to" URL.
 *
 * @since 1.0.0
 */
function thisisyyz_reply_to_url_handler( $retval, $r ) {
	echo $r['uri'];

	remove_action( 'bbp_get_reply_to_link', 'thisisyyz_reply_to_url_handler' );
}
