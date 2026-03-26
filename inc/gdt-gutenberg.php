<?php
/**
 * Block editor theme support and customizations.
 */


/**
 * Enqueue block editor customization script.
 */
function launchpad_block_editor_scripts() {
	wp_enqueue_script(
		'launchpad-block-editor',
		get_theme_file_uri( '/dist/gutenberg-custom.js' ),
		array( 'wp-blocks', 'wp-dom' ),
		filemtime( get_stylesheet_directory() . '/dist/gutenberg-custom.js' ),
		true
	);
}
add_action( 'enqueue_block_editor_assets', 'launchpad_block_editor_scripts' );


/**
 * Register the patterns/ directory so WP auto-loads theme patterns.
 * Each pattern declares its own title, slug, and categories via file header.
 */
function launchpad_register_patterns() {
	register_block_pattern_category(
		'launchpad',
		array( 'label' => __( 'LaunchPad', 'launchpad' ) )
	);
}
add_action( 'init', 'launchpad_register_patterns' );


/**
 * Add a custom block category.
 *
 * @param array $categories Array of block categories.
 * @return array
 */
function launchpad_block_category( $categories ) {
	return array_merge(
		array(
			array(
				'slug'  => 'myblocks',
				'title' => __( 'Custom Blocks', 'launchpad' ),
			),
		),
		$categories
	);
}
add_filter( 'block_categories_all', 'launchpad_block_category', 10, 2 );


/**
 * Return the filemtime version for a theme asset, or false if file not found.
 *
 * @param string $script_path Path relative to the theme root (e.g. '/src/js/splide.min.js').
 * @return int|false
 */
function launchpad_asset_version( $script_path ) {
	$file_path = get_template_directory() . $script_path;
	if ( file_exists( $file_path ) ) {
		return filemtime( $file_path );
	}
	return false;
}


/**
 * Register block-related scripts (Splide, Swiper, per-block JS).
 */
function launchpad_register_block_scripts() {
	wp_register_script( 'splide', get_template_directory_uri() . '/src/js/splide.min.js', array( 'acf' ), launchpad_asset_version( '/src/js/splide.min.js' ) );
	wp_register_script( 'slider', get_template_directory_uri() . '/template-part/block/slider/slider.js', array( 'splide', 'acf' ), launchpad_asset_version( '/template-part/block/slider/slider.js' ) );
	wp_register_script( 'swiper', get_template_directory_uri() . '/dist/swiper-bundle.min.js', array(), launchpad_asset_version( '/dist/swiper-bundle.min.js' ) );
	wp_register_script( 'effects', get_template_directory_uri() . '/template-part/block/swiper-material/effect-material.min.js', array(), launchpad_asset_version( '/template-part/block/swiper-material/effect-material.min.js' ) );
	wp_register_script( 'material-slider', get_template_directory_uri() . '/template-part/block/swiper-material/slider.js', array( 'swiper', 'effects', 'acf' ), launchpad_asset_version( '/template-part/block/swiper-material/slider.js' ) );
	wp_register_script( 'project-slider', get_template_directory_uri() . '/template-part/block/swiper-projects/project-slider.js', array( 'swiper', 'effects', 'acf' ), launchpad_asset_version( '/template-part/block/swiper-projects/project-slider.js' ) );
}
add_action( 'init', 'launchpad_register_block_scripts' );


/**
 * Register ACF JSON block types.
 */
function launchpad_register_acf_blocks() {
	register_block_type( get_stylesheet_directory() . '/template-part/block/button/block.json' );
	register_block_type( get_stylesheet_directory() . '/template-part/block/swiper-material/block.json' );
	register_block_type( get_stylesheet_directory() . '/template-part/block/swiper-projects/block.json' );
}
add_action( 'init', 'launchpad_register_acf_blocks', 5 );
