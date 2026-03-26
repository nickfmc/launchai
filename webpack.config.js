/**
 * Extends @wordpress/scripts webpack config with theme-specific entry points.
 * Run:  npm run build   (production)
 *       npm run start   (watch / dev)
 */
const defaultConfig = require( '@wordpress/scripts/config/webpack.config' );
const path = require( 'path' );

module.exports = {
	...defaultConfig,
	entry: {
		// Front-end bundle: JS + SCSS → build/site.js + build/site.css
		site: path.resolve( __dirname, 'src/site.js' ),
		// Block editor styles → build/editor-styles.css
		'editor-styles': path.resolve( __dirname, 'src/editor-styles.js' ),
	},
};
