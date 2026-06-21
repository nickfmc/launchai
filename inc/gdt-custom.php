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


// Add missing alt tags to images
function add_missing_alt_tags_to_content($content) {
    // Don't process empty content, admin pages, or REST API requests
    if (empty($content) || is_admin() || defined('REST_REQUEST')) {
        return $content;
    }

    // Only process content that actually has images
    if (strpos($content, '<img') === false) {
        return $content;
    }

    return preg_replace_callback(
        '/<img\s[^>]*src="([^"]*)"[^>]*\/?>/i',
        function ($matches) {
            $img_tag = $matches[0];

            // Capture existing alt value (even empty)
            if (preg_match('/alt\s*=\s*"([^"]*)"/i', $img_tag, $alt_match)) {
                // Alt attribute exists and is non-empty — leave it alone
                if ('' !== $alt_match[1]) {
                    return $img_tag;
                }
                // Alt="" — fall through to fill it
            }

            $image_id = null;

            // Try wp-image-{id} class first (fastest, most reliable)
            if (preg_match('/wp-image-(\d+)/', $img_tag, $id_match)) {
                $image_id = absint($id_match[1]);
            } elseif (preg_match('/data-image-id="(\d+)"/', $img_tag, $id_match)) {
                $image_id = absint($id_match[1]);
            } else {
                // Fallback: resolve from URL
                $src = esc_url_raw($matches[1]);
                $image_id = attachment_url_to_postid($src);
            }

            if ($image_id > 0 && 'attachment' === get_post_type($image_id)) {
                $alt_text = get_post_meta($image_id, '_wp_attachment_image_alt', true);
                if (!empty($alt_text)) {
                    // Replace empty alt or inject alt attribute
                    if (preg_match('/alt\s*=\s*""/i', $img_tag)) {
                        $img_tag = preg_replace('/alt\s*=\s*""/i', 'alt="' . esc_attr($alt_text) . '"', $img_tag);
                    } else {
                        $img_tag = str_replace('<img', '<img alt="' . esc_attr($alt_text) . '"', $img_tag);
                    }
                }
            }

            return $img_tag;
        },
        $content
    );
}

// Only apply to standard content
add_filter('the_content', 'add_missing_alt_tags_to_content', 20);