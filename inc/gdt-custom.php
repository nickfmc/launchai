<?php
/**
 * Per-project custom functions.
 * Drop project-specific code here.
 */


/**
 * Set $content_width — used by some plugins (e.g. Stackable) to constrain media widths.
 * Must run inside after_setup_theme so it's available before wp_head.
 */
function launchpad_content_width() {
	// phpcs:ignore WordPress.NamingConventions.PrefixAllGlobals.NonPrefixedVariableFound
	$GLOBALS['content_width'] = 1180;
}
add_action( 'after_setup_theme', 'launchpad_content_width', 0 );


// ---- Project-specific functions below ----------------------------------------

// Example: ACF icon picker path override
// add_filter( 'acf_icon_path_suffix', function( $path_suffix ) {
// 	return 'img/icons/';
// } );
