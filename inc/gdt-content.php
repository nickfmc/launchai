<?php
/**
 * Content-related functions: excerpts, title cropping, embeds, sidebars, body classes.
 */


/*------------------------------------*\
    EXCERPTS
\*------------------------------------*/

/**
 * Set the default excerpt word length.
 *
 * @return int
 */
function launchpad_excerpt_length() {
	return 66;
}
add_filter( 'excerpt_length', 'launchpad_excerpt_length', 999 );


/**
 * Replace the default "[…]" excerpt suffix with a "Read more" link.
 *
 * @param string $more The default more string.
 * @return string
 */
function launchpad_excerpt_more( $more ) {
	global $post;
	if ( $post ) {
		return '...  <a class="excerpt-read-more" href="' . get_permalink( $post->ID ) . '" title="Read ' . get_the_title( $post->ID ) . '"><span>Read more &raquo;</span></a>';
	}
	return $more;
}
add_filter( 'excerpt_more', 'launchpad_excerpt_more' );


/**
 * Return a word-count-limited excerpt.
 *
 * TIP: $char_limit must be less than launchpad_excerpt_length().
 * Usage: echo launchpad_excerpt( 25 );
 *
 * @param int $char_limit Number of words to include.
 * @return string
 */
function launchpad_excerpt( $char_limit ) {
	$excerpt_string = explode( ' ', get_the_excerpt(), $char_limit );
	if ( count( $excerpt_string ) >= $char_limit ) {
		array_pop( $excerpt_string );
		$excerpt_string = implode( ' ', $excerpt_string ) . '[...]';
	} else {
		$excerpt_string = implode( ' ', $excerpt_string );
	}
	return preg_replace( '`\[[^\]]*\]`', '', $excerpt_string );
}


/**
 * Return a character-count-limited excerpt from post content.
 *
 * Usage: echo launchpad_content_excerpt( 25 );
 *
 * @param int $char_limit Number of characters to include.
 * @return string
 */
function launchpad_content_excerpt( $char_limit ) {
	$excerpt = strip_tags( get_the_content() );
	$char_limit++;
	$excerpt = preg_replace( '/\[[^\]]+\]/', '', $excerpt );
	if ( strlen( $excerpt ) > $char_limit ) {
		$subex    = substr( $excerpt, 0, $char_limit - 5 );
		$exwords  = explode( ' ', $subex );
		$excut    = -( strlen( $exwords[ count( $exwords ) - 1 ] ) );
		if ( $excut < 0 ) {
			$excerpt_string = substr( $subex, 0, $excut );
		} else {
			$excerpt_string = $subex;
		}
		$excerpt_string .= '[...]';
	} else {
		$excerpt_string = $excerpt;
	}
	return $excerpt_string;
}


/*------------------------------------*\
    TITLE
\*------------------------------------*/

/**
 * Return the post title cropped to a character limit.
 *
 * Usage: echo launchpad_title_crop( 55 );
 *
 * @param int $count Maximum character count.
 * @return string
 */
function launchpad_title_crop( $count ) {
	$title = get_the_title();
	if ( strlen( $title ) > $count ) {
		$title = substr( $title, 0, $count ) . '...';
	}
	return $title;
}


/**
 * Make the "Read More" link go to the top of the post, not an anchor mid-page.
 *
 * @param string $link The more link HTML.
 * @return string
 */
function launchpad_remove_more_jump_link( $link ) {
	$offset = strpos( $link, '#more-' );
	if ( $offset ) {
		$end = strpos( $link, '"', $offset );
	}
	if ( ! empty( $end ) ) {
		$link = substr_replace( $link, '', $offset, $end - $offset );
	}
	return $link;
}
add_filter( 'the_content_more_link', 'launchpad_remove_more_jump_link' );


/*------------------------------------*\
    EMBEDS
\*------------------------------------*/

/**
 * Wrap oEmbed HTML in a responsive container.
 *
 * @param string $html    The oEmbed HTML.
 * @param string $url     The URL being embedded.
 * @param array  $attr    oEmbed attributes.
 * @param int    $post_id Post ID.
 * @return string
 */
function launchpad_embed_oembed_html( $html, $url, $attr, $post_id ) {
	return '<div class="embed-responsive  ut-aspect-16x9">' . $html . '</div>';
}
add_filter( 'embed_oembed_html', 'launchpad_embed_oembed_html', 99, 4 );


/*------------------------------------*\
    WIDGET AREAS
\*------------------------------------*/

/**
 * Register widgetized areas (sidebar and footer columns).
 */
function launchpad_register_sidebars() {
	register_sidebar(
		array(
			'id'            => 'sidebar',
			'name'          => 'Sidebar',
			'description'   => 'The primary sidebar.',
			'before_widget' => '<div id="%1$s" class="widget  clearfix  %2$s"><div class="widget-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h4 class="widgettitle">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'id'            => 'footer-1',
			'name'          => 'Footer - Column 1',
			'description'   => 'First footer column.',
			'before_widget' => '<div id="%1$s" class="widget  clearfix  %2$s"><div class="widget-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h4 class="widgettitle">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'id'            => 'footer-2',
			'name'          => 'Footer - Column 2',
			'description'   => 'Second footer column.',
			'before_widget' => '<div id="%1$s" class="widget  clearfix  %2$s"><div class="widget-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h4 class="widgettitle">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'id'            => 'footer-3',
			'name'          => 'Footer - Column 3',
			'description'   => 'Third footer column.',
			'before_widget' => '<div id="%1$s" class="widget  clearfix  %2$s"><div class="widget-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h4 class="widgettitle">',
			'after_title'   => '</h4>',
		)
	);

	register_sidebar(
		array(
			'id'            => 'footer-4',
			'name'          => 'Footer - Column 4',
			'description'   => 'Fourth footer column.',
			'before_widget' => '<div id="%1$s" class="widget  clearfix  %2$s"><div class="widget-wrap">',
			'after_widget'  => '</div></div>',
			'before_title'  => '<h4 class="widgettitle">',
			'after_title'   => '</h4>',
		)
	);
}
add_action( 'widgets_init', 'launchpad_register_sidebars' );


/*------------------------------------*\
    BODY CLASSES
\*------------------------------------*/

/**
 * Add a body class based on the current page template slug.
 *
 * @param array $classes Existing body classes.
 * @return array
 */
function launchpad_page_template_body_classes( $classes ) {
	if ( is_page() ) {
		$template = get_page_template_slug();
		if ( '' === $template ) {
			$classes[] = 'default-page';
		} else {
			$classes[] = sanitize_html_class( str_replace( '.php', '', $template ) );
		}
	}
	return $classes;
}
add_filter( 'body_class', 'launchpad_page_template_body_classes' );


/**
 * Return a slug for use as an extra body class (category, term, or post name).
 *
 * @return string
 */
function launchpad_pretty_body_class() {
	$term = get_queried_object();
	$cat  = array();

	if ( is_single() ) {
		$cat = get_the_category();
	}

	if ( ! empty( $cat ) ) {
		return $cat[0]->slug;
	} elseif ( isset( $term->slug ) ) {
		return $term->slug;
	} elseif ( isset( $term->post_name ) ) {
		return $term->post_name;
	}

	return '';
}
