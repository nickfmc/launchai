<?php
/**
 * Image sizes and responsive image helper.
 */


// Default thumbnail size.
set_post_thumbnail_size( 150, 150, true );

// Custom crop sizes.
add_image_size( 'crop-1200-500', 1200, 500, true );

// To expose custom sizes in the media manager, uncomment:
// add_filter( 'image_size_names_choose', 'launchpad_custom_image_sizes' );
// function launchpad_custom_image_sizes( $sizes ) {
// 	return array_merge( $sizes, array(
// 		'crop-1200-500' => __( '1200px by 500px', 'launchpad' ),
// 	) );
// }


/**
 * Build src, srcset, sizes, and alt attributes for a responsive image.
 *
 * Usage: <img <?php echo launchpad_responsive_image( get_field( 'image' ), 'crop-1200-500', '1200px' ); ?> />
 *
 * @param int    $image_id   Attachment ID.
 * @param string $image_size Registered image size slug.
 * @param string $max_width  Max display width (e.g. '1200px') for the sizes attribute.
 * @return string|null HTML attribute string, or null if no image ID provided.
 */
function launchpad_responsive_image( $image_id, $image_size, $max_width ) {
	if ( empty( $image_id ) ) {
		return null;
	}

	$image_src    = wp_get_attachment_image_url( $image_id, $image_size );
	$image_srcset = wp_get_attachment_image_srcset( $image_id, $image_size );
	$image_alt    = get_post_meta( $image_id, '_wp_attachment_image_alt', true );

	return 'src="' . esc_url( $image_src ) . '" srcset="' . esc_attr( $image_srcset ) . '" sizes="(max-width: ' . esc_attr( $max_width ) . ') 100vw, ' . esc_attr( $max_width ) . '" alt="' . esc_attr( $image_alt ) . '"';
}
