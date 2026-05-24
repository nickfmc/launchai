<?php
/**
 * Block editor theme support and customizations.
 */


/**
 * Enqueue block editor customization script.
 * Uses the wp-scripts built file so WP package dependencies are auto-declared
 * via the generated .asset.php file.
 */
function launchpad_block_editor_scripts() {
	$asset_file = get_stylesheet_directory() . '/build/editor.asset.php';
	if ( ! file_exists( $asset_file ) ) {
		return;
	}
	$asset = include $asset_file;
	wp_enqueue_script(
		'launchpad-block-editor',
		get_stylesheet_directory_uri() . '/build/editor.js',
		$asset['dependencies'],
		$asset['version'],
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
 * Register native block types.
 */
function launchpad_register_blocks() {
	register_block_type( get_stylesheet_directory() . '/blocks/search-trigger/block.json' );
	register_block_type( get_stylesheet_directory() . '/blocks/eyebrow-heading/block.json' );
}
add_action( 'init', 'launchpad_register_blocks', 5 );
