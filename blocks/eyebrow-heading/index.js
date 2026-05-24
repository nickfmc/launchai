/**
 * Eyebrow Heading block.
 *
 * Renders a single semantic heading tag (h1–h6) containing an eyebrow span
 * and the main heading text — all inside one element.
 *
 * Output:
 *   <h2 class="c-eyebrow-heading">
 *     <span class="is-eyebrow">Eyebrow text</span>
 *     Main heading text
 *   </h2>
 */
import { registerBlockType } from '@wordpress/blocks';
import { useBlockProps, RichText, InspectorControls } from '@wordpress/block-editor';
import { PanelBody, SelectControl } from '@wordpress/components';
import metadata from './block.json';

registerBlockType( metadata.name, {
	edit( { attributes, setAttributes } ) {
		const { tagName: TagName, eyebrowText, headingText } = attributes;
		const blockProps = useBlockProps( { className: 'c-eyebrow-heading' } );

		return (
			<>
				<InspectorControls>
					<PanelBody title="Heading Level">
						<SelectControl
							label="Tag"
							value={ TagName }
							options={ [
								{ label: 'H1', value: 'h1' },
								{ label: 'H2', value: 'h2' },
								{ label: 'H3', value: 'h3' },
								{ label: 'H4', value: 'h4' },
								{ label: 'H5', value: 'h5' },
								{ label: 'H6', value: 'h6' },
							] }
							onChange={ ( value ) => setAttributes( { tagName: value } ) }
						/>
					</PanelBody>
				</InspectorControls>

				<TagName { ...blockProps }>
					<RichText
						tagName="span"
						className="is-eyebrow"
						value={ eyebrowText }
						onChange={ ( value ) => setAttributes( { eyebrowText: value } ) }
						placeholder="Eyebrow text…"
						allowedFormats={ [] }
					/>
					<RichText
						tagName="span"
						className="c-eyebrow-heading__text"
						value={ headingText }
						onChange={ ( value ) => setAttributes( { headingText: value } ) }
						placeholder="Heading text…"
						allowedFormats={ [ 'core/bold', 'core/italic' ] }
					/>
				</TagName>
			</>
		);
	},

	save( { attributes } ) {
		const { tagName: TagName, eyebrowText, headingText } = attributes;
		const blockProps = useBlockProps.save( { className: 'c-eyebrow-heading' } );

		return (
			<TagName { ...blockProps }>
				{ eyebrowText && (
					<RichText.Content
						tagName="span"
						className="is-eyebrow"
						value={ eyebrowText }
					/>
				) }
				<RichText.Content
					tagName="span"
					className="c-eyebrow-heading__text"
					value={ headingText }
				/>
			</TagName>
		);
	},
} );
