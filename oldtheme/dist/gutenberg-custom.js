/**
 * Edits and additions to the default Gutenberg setup
 */

// // ++ create custom button style names + remove included buttons styles
wp.blocks.registerBlockStyle( 'core/button', {
  name: 'standard',
  label: 'Standard Button'
} );
// wp.blocks.registerBlockStyle( 'core/button', {
//   name: 'border',
//   label: 'Border Button'
// } );

wp.blocks.registerBlockStyle(
  'core/paragraph',
  {
    name: 'secondaryfont',
    label: 'Secondary Font',
    
  }
);


wp.blocks.registerBlockStyle(
  'core/columns',
  {
    name: 'no-gutter',
    label: 'No Gutters'
  }
);

/* ==========================================================================
   CONTENT GRID LAYOUT SYSTEM
   ========================================================================== */

// Register Content Grid style for Group block (container)
wp.blocks.registerBlockStyle(
  'core/group',
  {
    name: 'content-grid',
    label: 'Content Grid'
  }
);

// Register Content Grid style for GenerateBlocks Element (v2.0+)
wp.blocks.registerBlockStyle(
  'generateblocks/element',
  {
    name: 'content-grid',
    label: 'Content Grid'
  }
);

// Child positioning styles - Apply to various content blocks
const contentGridChildBlocks = [
  'core/paragraph',
  'core/heading',
  'core/image',
  'core/gallery',
  'core/group',
  'core/columns',
  'core/cover',
  'core/spacer',
  'core/separator',
  'generateblocks/element',
  'core/list'
];

// Register positioning styles for each applicable block type
contentGridChildBlocks.forEach(function(blockName) {
  
  // Feature - Extends slightly beyond content area
  wp.blocks.registerBlockStyle(blockName, {
    name: 'content--feature',
    label: '↔ Feature'
  });
  
  // Feature Max - Extends further into margins
  wp.blocks.registerBlockStyle(blockName, {
    name: 'content--feature-max',
    label: '↔↔ Feature Max'
  });
  
  // Full Width - Edge-to-edge
  wp.blocks.registerBlockStyle(blockName, {
    name: 'content--full',
    label: '↔↔↔ Full Width'
  });
  
  // Full Width Safe - Full width with gutter padding
  wp.blocks.registerBlockStyle(blockName, {
    name: 'content--full-safe',
    label: '⬌ Full Safe'
  });
  
});


// some blocks are required by WP when doing other things, so keep an eye on the consol log, currently cover block causes errors if we remove it.
wp.domReady( () => {
  wp.blocks.unregisterBlockStyle( 'core/button', 'fill' );
  wp.blocks.unregisterBlockStyle( 'core/button', 'outline' );
  wp.blocks.unregisterBlockStyle( 'core/button', 'squared' );
  // Unregister unwanted blocks here
  wp.blocks.unregisterBlockType( 'core/preformatted' );
  wp.blocks.unregisterBlockType( 'core/verse' );
  wp.blocks.unregisterBlockType( 'core/pullquote' );
  wp.blocks.unregisterBlockType( 'core/media-text' );
  // wp.blocks.unregisterBlockType( 'core/cover' );
  wp.blocks.unregisterBlockType( 'core/more' );
  wp.blocks.unregisterBlockType( 'core/buttons' );
  wp.blocks.unregisterBlockType( 'core/site-logo' );
  wp.blocks.unregisterBlockType( 'core/site-tagline' );
  wp.blocks.unregisterBlockType( 'core/site-title' );
  wp.blocks.unregisterBlockType( 'core/calendar' );
  wp.blocks.unregisterBlockType( 'core/latest-comments' );
  wp.blocks.unregisterBlockType( 'core/tag-cloud' );
  wp.blocks.unregisterBlockType( 'core/search' );
  wp.blocks.unregisterBlockType( 'core/rss' );
  wp.blocks.unregisterBlockType( 'core/social-links' );
  wp.blocks.unregisterBlockType( 'core/latest-posts' );
  wp.blocks.unregisterBlockType( 'core/categories' );
  wp.blocks.unregisterBlockType( 'core/archives' );
  wp.blocks.unregisterBlockType( 'core/query-title' );
  // wp.blocks.unregisterBlockType( 'core/post-terms' );
  // wp.blocks.unregisterBlockType( 'core/coverImage' );

  // toolset customization
  // wp.blocks.unregisterBlockType( 'toolset-blocks/button' );
} );
