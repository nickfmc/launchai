/**
 * Edits and additions to the default Gutenberg setup
 */

wp.blocks.registerBlockStyle('core/button', {
  name: 'standard',
  label: 'Standard Button'
});

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

wp.domReady(() => {
  // Remove default button styles — theme registers 'standard' above
  wp.blocks.unregisterBlockStyle('core/button', 'fill');
  wp.blocks.unregisterBlockStyle('core/button', 'outline');
  wp.blocks.unregisterBlockStyle('core/button', 'squared');

  // Unregister blocks not used in this theme
  // NOTE: Do NOT unregister FSE-required blocks:
  //   core/site-logo, core/site-title, core/site-tagline — used in header template
  //   core/search, core/query-title                      — used in 404/search/archive templates
  //   core/buttons                                       — core/button container
  //   core/social-links                                  — footer social icons
  wp.blocks.unregisterBlockType('core/preformatted');
  wp.blocks.unregisterBlockType('core/verse');
  wp.blocks.unregisterBlockType('core/pullquote');
  wp.blocks.unregisterBlockType('core/media-text');
  wp.blocks.unregisterBlockType('core/more');
  wp.blocks.unregisterBlockType('core/calendar');
  wp.blocks.unregisterBlockType('core/latest-comments');
  wp.blocks.unregisterBlockType('core/tag-cloud');
  wp.blocks.unregisterBlockType('core/rss');
  wp.blocks.unregisterBlockType('core/latest-posts');
  wp.blocks.unregisterBlockType('core/categories');
  wp.blocks.unregisterBlockType('core/archives');
});


