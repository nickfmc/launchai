<?php
/**
 * Asset registration and enqueuing.
 */


/**
 * Register and enqueue front-end scripts and styles.
 */
function launchpad_scripts_and_styles() {
	if ( ! is_admin() ) {
		// Comment reply script for threaded comments.
		if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
			wp_enqueue_script( 'comment-reply' );
		}

		// Main stylesheet (compiled from src/site.scss via wp-scripts).
		$css_ver = filemtime( get_stylesheet_directory() . '/build/site.css' );
		wp_register_style( 'launchpad-styles', get_stylesheet_directory_uri() . '/build/site.css', array(), $css_ver, 'all' );

		// Main JS bundle (compiled from src/site.js via wp-scripts).
		$js_ver = filemtime( get_stylesheet_directory() . '/build/site.js' );
		wp_register_script( 'launchpad-scripts', get_stylesheet_directory_uri() . '/build/site.js', array(), $js_ver, true );

		wp_enqueue_style( 'launchpad-styles' );
		wp_enqueue_script( 'launchpad-scripts' );
	}
}
add_action( 'wp_enqueue_scripts', 'launchpad_scripts_and_styles', 999 );
