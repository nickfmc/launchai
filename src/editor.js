/**
 * Block editor customizations.
 * Registers custom block styles and removes unused blocks.
 */
import { registerBlockStyle, unregisterBlockType, getBlockType } from '@wordpress/blocks';
import domReady from '@wordpress/dom-ready';

registerBlockStyle( 'core/button', {
	name: 'standard',
	label: 'Standard Button',
} );

registerBlockStyle( 'core/paragraph', {
	name: 'secondaryfont',
	label: 'Secondary Font',
} );

registerBlockStyle( 'core/columns', {
	name: 'no-gutter',
	label: 'No Gutters',
} );

// GenerateBlocks — text block styles
[
	{ name: 'h1-style', label: 'H1 Style' },
	{ name: 'h2-style', label: 'H2 Style' },
	{ name: 'h3-style', label: 'H3 Style' },
	{ name: 'h4-style', label: 'H4 Style' },
	{ name: 'h5-style', label: 'H5 Style' },
	{ name: 'h6-style', label: 'H6 Style' },
	{ name: 'eyebrow',  label: 'Eyebrow Style' },
].forEach( ( style ) => registerBlockStyle( 'generateblocks/text', style ) );

domReady( () => {
	// Remove default button styles — theme registers 'standard' above.
	unregisterBlockType( 'core/button', 'fill' );
	unregisterBlockType( 'core/button', 'outline' );
	unregisterBlockType( 'core/button', 'squared' );

	// Unregister blocks not used in this theme.
	// NOTE: Do NOT unregister FSE-required blocks:
	//   core/site-logo, core/site-title, core/site-tagline — used in header template
	//   core/search, core/query-title                      — used in 404/search/archive templates
	//   core/buttons                                       — core/button container
	//   core/social-links                                  — footer social icons
	const blocksToRemove = [
		'core/preformatted',
		'core/verse',
		'core/pullquote',
		'core/media-text',
		'core/more',
		'core/calendar',
		'core/latest-comments',
		'core/tag-cloud',
		'core/rss',
		'core/latest-posts',
		'core/categories',
		'core/archives',
	];

	blocksToRemove.forEach( ( blockName ) => {
		if ( getBlockType( blockName ) ) {
			unregisterBlockType( blockName );
		}
	} );
} );
