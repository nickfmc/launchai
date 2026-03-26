<?php
/**
 * Core theme setup: head cleanup, theme support, and initial hook registrations.
 */


/*------------------------------------*\
    CLEAN UP STUFF
\*------------------------------------*/

/**
 * Fire up key filters and functions on after_setup_theme.
 */
function launchpad_setup() {
	// Remove WP version from RSS.
	add_filter( 'the_generator', 'launchpad_rss_version' );
	// Remove injected CSS for recent comments widget.
	add_filter( 'show_recent_comments_widget_style', '__return_false', 99 );
	// Enable theme support features.
	launchpad_theme_support();
}
add_action( 'after_setup_theme', 'launchpad_setup' );


/**
 * Clean up unnecessary items from <head>.
 */
function launchpad_head_cleanup() {
	remove_action( 'wp_head', 'rsd_link' );
	remove_action( 'wp_head', 'wlwmanifest_link' );
	remove_action( 'wp_head', 'parent_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'start_post_rel_link', 10, 0 );
	remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0 );
	remove_action( 'wp_head', 'wp_generator' );
	add_filter( 'feed_links_show_comments_feed', '__return_false' );
}
add_action( 'init', 'launchpad_head_cleanup' );


/**
 * Remove all emoji-related scripts and styles.
 */
function launchpad_disable_emojicons() {
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
}
add_action( 'init', 'launchpad_disable_emojicons' );
add_filter( 'emoji_svg_url', '__return_false' );


/**
 * Remove WP version from RSS.
 *
 * @return string Empty string to strip the generator tag.
 */
function launchpad_rss_version() {
	return '';
}


/*------------------------------------*\
    THEME SUPPORT
\*------------------------------------*/

/**
 * Register WP feature support for this theme.
 */
function launchpad_theme_support() {
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );
	add_theme_support( 'customize-selective-refresh-widgets' );
	add_theme_support( 'automatic-feed-links' );
	add_theme_support( 'editor-styles' );
	add_editor_style( 'build/editor-styles.css' );
	remove_theme_support( 'core-block-patterns' );
	add_theme_support( 'responsive-embeds' );
	add_theme_support( 'align-wide' );
	add_theme_support( 'custom-line-height' );
	add_theme_support( 'custom-units' );
	add_theme_support( 'custom-spacing' );
	add_theme_support( 'custom-colors' );
	add_theme_support( 'block-template-parts' );
	add_theme_support( 'block-templates' );
}
