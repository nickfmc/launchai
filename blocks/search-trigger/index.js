/**
 * Search Trigger block — client-side registration.
 *
 * This is a dynamic block rendered server-side via render.php.
 * The client registration tells Gutenberg the block exists so it can
 * be rendered inside template parts without throwing a validation error.
 */
import { registerBlockType } from '@wordpress/blocks';
import metadata from './block.json';

registerBlockType( metadata.name, {
	edit: () => null,
	save: () => null,
} );
