<?php
/**
 * Site Header — classic PHP markup (ported from header.php).
 *
 * Rendered into the FSE "header" template-part slot via the
 * render_block_core/template-part filter in inc/gdt-custom.php, so the rest
 * of the site (templates, footer, Site Editor) stays block-theme driven.
 */
?>
<!-- Skip links should be the first focusable elements -->
<div class="skip-links" role="navigation" aria-label="Skip links navigation">
	<a href="#main-content" class="skip-link" role="link" aria-label="Skip to main content">Skip to main content</a>
	<a href="#site-navigation" class="skip-link" role="link" aria-label="Skip to main navigation">Skip to main navigation</a>
	<a href="#c-page-footer" class="skip-link" role="link" aria-label="Skip to page footer">Skip to page footer</a>
</div>
<!-- END Skip links should be the first focusable elements -->

<header id="c-page-header" class="o-section c-page-header" role="banner" itemscope itemtype="https://schema.org/WPHeader">
	<div class="o-wrapper-wide u-relative">
		<?php get_template_part( 'template-part/header/logo' ); ?>
		<?php get_template_part( 'template-part/navigation/nav-main' ); ?>
		<?php get_template_part( 'template-part/navigation/nav-tertiary' ); ?>

		<div class="c-cl-mobile-nav">
			<button href="#" id="open-modal-nav" class="c-modal-nav-button" aria-expanded="false" aria-haspopup="menu" aria-label="Open menu">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
					<path d="M3 12H21M3 6H21M3 18H21" stroke="#414651" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
				</svg>
			</button>
			<?php get_template_part( 'template-part/navigation/nav-mobile' ); ?>
		</div>
	</div>
</header>
