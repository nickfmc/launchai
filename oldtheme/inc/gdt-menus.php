<?php
  
/*********************************************
 MENU SETUP - #navigation
**********************************************/


// setup wp_nav_menu stuff.............

// registering WP nav menus
register_nav_menus(
  array(
    'main-menu' => 'Primary Menu',           // main nav menu
    'tertiary-menu' => 'Tertiary Menu',      // tertiary nav menu
    'mobile-menu' => 'Mobile Menu'      // mobile nav menu
  )
);


/* usage: <?php gdt_nav_menu( 'main-menu', 'c-menu-main' ); ?> */
function gdt_nav_menu($theme_location, $class, $additional_args = array()) {
  $menu = null;
  if (has_nav_menu($theme_location)) {
      $default_args = array(
          'container' => false,
          'theme_location' => $theme_location,
          'menu_class' => $class . '',
          'echo' => 0,
      );
      
      // Merge default args with additional args
      $args = array_merge($default_args, $additional_args);
      
      $menu = wp_nav_menu($args);
  }
  echo $menu;
}







/*
 * Adds menu data support for HC Off-canvas Nav
 */

$hc_nav_menu_walker;

class HC_Walker_Nav_Menu extends Walker_Nav_Menu {

  public function start_lvl(&$output, $depth = 0, $args = array()) {
    global $hc_nav_menu_walker;
    $hc_nav_menu_walker->start_lvl($output, $depth, $args);
  }

  public function end_lvl(&$output, $depth = 0, $args = array()) {
    global $hc_nav_menu_walker;
    $hc_nav_menu_walker->end_lvl($output, $depth, $args);
  }

  public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    global $hc_nav_menu_walker;

    $item_output = '';

    $hc_nav_menu_walker->start_el($item_output, $item, $depth, $args, $id);

    if ($item->current_item_parent) {
      $item_output = preg_replace('/<li/', '<li data-nav-active', $item_output, 1);
    }

    if ($item->current) {
      $item_output = preg_replace('/<li/', '<li data-nav-highlight', $item_output, 1);
    }

    $output .= $item_output;
  }

  public function end_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
    global $hc_nav_menu_walker;
    $hc_nav_menu_walker->end_el($output, $item, $depth, $args, $id);
  }
}

add_filter('wp_nav_menu_args', function($args) {
  global $hc_nav_menu_walker;

  if (!empty($args['walker'])) {
    $hc_nav_menu_walker = $args['walker'];
  }
  else {
    $hc_nav_menu_walker = new Walker_Nav_Menu();
  }

  $args['walker'] = new HC_Walker_Nav_Menu();

  return $args;
});




// Accessible Nav Walker
class Accessible_Nav_Walker extends Walker_Nav_Menu {
  function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0) {
      $indent = ($depth) ? str_repeat("\t", $depth) : '';
      $classes = empty($item->classes) ? array() : (array) $item->classes;
      $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
      
      // Start the item
      $output .= $indent . '<li class="' . esc_attr($class_names) . '">';
      
      // Build the link
      $attributes = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) . '"' : '';
      $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) . '"' : '';
      $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) . '"' : '';
      $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) . '"' : '';
      
      // Add the main link
      $item_output = $args->before;
      $item_output .= '<a' . $attributes . '>';
      $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
      $item_output .= '</a>';
      
      // If item has children, add the dropdown button
      if (in_array('menu-item-has-children', $classes)) {
          $item_output .= '<button class="dropdown-toggle" aria-expanded="false">';
          $item_output .= '<span class="screen-reader-text">Show submenu for ' . $item->title . '</span>';
          $item_output .= '<svg aria-hidden="true" width="20" height="20" viewBox="0 0 20 20" fill="none"><path d="M5 7.5L10 12.5L15 7.5" stroke="currentColor" stroke-width="1.66667" stroke-linecap="round" stroke-linejoin="round"/></svg>';
          $item_output .= '</button>';
      }
      
      $item_output .= $args->after;
      
      $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
  }
}
// end Accessible Nav Walker

?>