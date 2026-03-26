<?php
/**
 * LaunchPad Theme — functions.php
 *
 * Loads all inc/ modules. Do not add functions here directly.
 */

// Core theme functions.
require_once get_template_directory() . '/inc/gdt-cleanup.php';
require_once get_template_directory() . '/inc/gdt-gutenberg.php';
require_once get_template_directory() . '/inc/gdt-enqueues.php';
require_once get_template_directory() . '/inc/gdt-menus.php';
require_once get_template_directory() . '/inc/gdt-content.php';
require_once get_template_directory() . '/inc/gdt-images.php';
require_once get_template_directory() . '/inc/gdt-toolbelt.php';

// require_once get_template_directory() . '/inc/megamenu.php';

// Custom post types / taxonomies (enable as needed).
// require_once get_template_directory() . '/inc/custom-post-type.php';
// require_once get_template_directory() . '/inc/custom-taxonomy.php';

// Admin customizations.
require_once get_template_directory() . '/inc/admin.php';

// Per-project custom functions.
require_once get_template_directory() . '/inc/gdt-custom.php';
