<?php
/**
 * Admin area customizations: dashboard, menus, login page, ACF tweaks.
 */


/*------------------------------------*\
    DASHBOARD
\*------------------------------------*/

/**
 * Remove unnecessary default dashboard widgets.
 */
function launchpad_disable_dashboard_widgets() {
	global $wp_meta_boxes;
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments'] ); // Comments Widget.
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links'] );  // Incoming Links Widget.
	unset( $wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins'] );         // Plugins Widget.
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'] );       // Quick Press Widget.
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts'] );     // Recent Drafts Widget.
	unset( $wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary'] );         // Secondary Dashboard.
	// Plugin widgets.
	unset( $wp_meta_boxes['dashboard']['normal']['core']['yoast_db_widget'] );           // Yoast SEO.
	unset( $wp_meta_boxes['dashboard']['normal']['core']['rg_forms_dashboard'] );        // Gravity Forms.
	unset( $wp_meta_boxes['dashboard']['normal']['core']['bbp-dashboard-right-now'] );   // bbPress.
	unset( $wp_meta_boxes['dashboard']['normal']['core']['tribe_dashboard_widget'] );    // The Events Calendar.
}
add_action( 'wp_dashboard_setup', 'launchpad_disable_dashboard_widgets' );


/*------------------------------------*\
    ADMIN MENUS
\*------------------------------------*/

/**
 * Remove unnecessary admin menu pages based on user capabilities.
 */
function launchpad_hide_menu_items() {
	if ( current_user_can( 'update_core' ) ) {
		remove_menu_page( 'edit-comments.php' ); // Comments.
	}
	if ( ! current_user_can( 'update_core' ) ) {
		remove_menu_page( 'index.php' );                  // Dashboard.
		remove_menu_page( 'edit.php?post_type=page ' );   // Pages.
		remove_menu_page( 'upload.php' );                 // Media.
		remove_menu_page( 'link-manager.php' );           // Links.
		remove_menu_page( 'edit-comments.php' );          // Comments.
		remove_menu_page( 'themes.php' );                 // Appearance.
		remove_menu_page( 'plugins.php' );                // Plugins.
		remove_menu_page( 'users.php' );                  // Users.
		remove_menu_page( 'tools.php' );                  // Tools.
		remove_menu_page( 'options-general.php' );        // Settings.
	}
}
add_action( 'admin_menu', 'launchpad_hide_menu_items', 999 );


// Hide the admin bar for non-admins.
if ( ! current_user_can( 'update_core' ) ) {
	show_admin_bar( false );
}


/*------------------------------------*\
    REVISIONS
\*------------------------------------*/

/**
 * Limit the number of revisions stored per post.
 *
 * @param int     $num  Number of revisions to keep.
 * @param WP_Post $post The post object.
 * @return int
 */
function launchpad_limit_revisions( $num, $post ) {
	return 15;
}
add_filter( 'wp_revisions_to_keep', 'launchpad_limit_revisions', 10, 2 );


/*------------------------------------*\
    REWRITE RULES
\*------------------------------------*/

/**
 * Flush rewrite rules on theme activation so CPTs register correctly.
 */
function launchpad_flush_rewrite_rules() {
	flush_rewrite_rules();
}
add_action( 'after_switch_theme', 'launchpad_flush_rewrite_rules' );


/*------------------------------------*\
    CUSTOM LOGIN PAGE
\*------------------------------------*/

/**
 * Enqueue custom login page stylesheet.
 */
function launchpad_login_css() {
	wp_enqueue_style( 'launchpad-login', get_template_directory_uri() . '/inc/login.css', false );
}
add_action( 'login_enqueue_scripts', 'launchpad_login_css', 10 );

/**
 * Point the login logo link to the site home URL.
 *
 * @return string
 */
function launchpad_login_url() {
	return home_url();
}
add_filter( 'login_headerurl', 'launchpad_login_url' );

/**
 * Set the login logo alt text to the site name.
 *
 * @return string
 */
function launchpad_login_title() {
	return get_option( 'blogname' );
}
add_filter( 'login_headertext', 'launchpad_login_title' );


/*------------------------------------*\
    ACF TWEAKS
\*------------------------------------*/

/**
 * Add alternating row colours to ACF repeater fields for readability.
 */
function launchpad_acf_repeater_colors() {
	echo '<style>
		.acf-repeater .acf-row:nth-child(odd) > .acf-row-handle.order,
		.acf-repeater .acf-row:nth-child(odd) > .acf-row-handle.remove {
			background: #dadada;
		}
	</style>';
}
add_action( 'admin_head', 'launchpad_acf_repeater_colors' );

// To hide ACF from the admin menu, uncomment:
// add_filter( 'acf/settings/show_admin', '__return_false' );

// Custom admin footer credit (disabled by default):
// add_filter( 'admin_footer_text', function() {
// 	echo '<span>Developed by <a href="https://mountainairweb.com" target="_blank">Mountain Air Web</a></span>.';
// } );
