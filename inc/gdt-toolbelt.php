<?php
/**
 * Miscellaneous helper functions for working with pages and post hierarchies.
 */


/**
 * Determine if the current page is within a given page tree.
 *
 * @param int $pid The ID of the root page to check against.
 * @return bool
 */
function launchpad_is_tree( $pid ) {
	global $post;

	if ( is_page( $pid ) ) {
		return true;
	}

	$anc = get_post_ancestors( $post->ID );
	foreach ( $anc as $ancestor ) {
		if ( is_page() && $ancestor === $pid ) {
			return true;
		}
	}

	return false;
}


/**
 * Check whether the current page has child pages.
 *
 * @return bool True if the current page has children, false otherwise.
 */
function launchpad_page_has_parent() {
	global $post;

	$parent   = false;
	$children = get_pages( 'child_of=' . $post->ID );

	if ( count( $children ) > 0 ) {
		$parent = true;
	}

	return $parent;
}
