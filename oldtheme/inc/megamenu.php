<?php




// mega menu Script move to main scripts file.
// document.addEventListener('DOMContentLoaded', function() {
//     const menuItems = document.querySelectorAll('.c-main-menu > li.has-mega-menu');
    

    
//     menuItems.forEach(item => {
//         const triggerType = item.dataset.triggerType || 'hover';
//         const link = item.querySelector('a, button');
//         const submenu = item.querySelector('.mega-menu__content');
//         let hoverTimeout;
//         let isOpen = false;
        
//         // Set up ARIA attributes
//         if (link && submenu) {
//             link.setAttribute('aria-expanded', 'false');
//             link.setAttribute('aria-haspopup', 'true');
//             submenu.setAttribute('aria-label', `Submenu for ${link.textContent}`);
//         }

//         function closeAllMenus() {
//             menuItems.forEach(menuItem => {
//                 const submenu = menuItem.querySelector('.mega-menu__content');
//                 const link = menuItem.querySelector('a, button');
//                 if (submenu && submenu.style.display === 'block') {
//                     submenu.setAttribute('aria-hidden', 'true');
//                     link.setAttribute('aria-expanded', 'false');
//                     submenu.style.opacity = '0';
//                     submenu.style.display = 'none';
//                     submenu.style.transition = '';
//                 }
//             });
//         }

//      function showSubmenu() {
//          if (submenu) {
//              // Close all other menus first
//              closeAllMenus();
             
//              submenu.setAttribute('aria-hidden', 'false');
//              link.setAttribute('aria-expanded', 'true');
//              submenu.style.display = 'block';
//              submenu.style.transition = 'opacity 300ms ease-in-out';
             
//              requestAnimationFrame(() => {
//                  submenu.style.opacity = '0';
//                  requestAnimationFrame(() => {
//                      submenu.style.opacity = '1';
//                  });
//              });
//              isOpen = true;
//          }
//      }
     
        
//         function hideSubmenu() {
//             if (submenu) {
//                 submenu.setAttribute('aria-hidden', 'true');
//                 link.setAttribute('aria-expanded', 'false');
                
//                 submenu.style.transition = 'opacity 300ms ease-in-out';
//                 submenu.style.opacity = '0';
                
//                 setTimeout(() => {
//                     submenu.style.display = 'none';
//                     submenu.style.transition = '';
//                 }, 300);
//                 isOpen = false;
//             }
//         }


    
        

//         // Set up event listeners based on trigger type
//         if (triggerType === 'hover') {
//             // Hover functionality
//             item.addEventListener('mouseenter', () => {
//                 clearTimeout(hoverTimeout);
//                 hoverTimeout = setTimeout(showSubmenu, 300);
//             });
            
//             item.addEventListener('mouseleave', () => {
//                 clearTimeout(hoverTimeout);
//                 hoverTimeout = setTimeout(hideSubmenu, 300);
//             });
//         } else if (triggerType === 'click') {
//             // Click functionality
//             link.addEventListener('click', (e) => {
//                 if (link.tagName.toLowerCase() === 'a') {
//                     e.preventDefault();
//                 }
//                 if (!isOpen) {
//                     showSubmenu();
//                 } else {
//                     hideSubmenu();
//                 }
//             });

//             // Close menu when clicking outside
//             document.addEventListener('click', (e) => {
//                 if (!item.contains(e.target) && isOpen) {
//                     hideSubmenu();
//                 }
//             });
//         }

//         // Keep keyboard navigation regardless of trigger type
//         link.addEventListener('keydown', function(e) {
//             if (e.key === 'Enter' || e.key === 'Space') {
//                 e.preventDefault();
//                 if (!isOpen) {
//                     showSubmenu();
//                 } else {
//                     hideSubmenu();
//                 }
//             }
//             if (e.key === 'Escape' && isOpen) {
//                 hideSubmenu();
//                 link.focus();
//             }
//         });

//         // Handle focus events
//         item.addEventListener('focusin', () => {
//             if (triggerType === 'hover') {
//                 showSubmenu();
//             }
//         });

//         item.addEventListener('focusout', (e) => {
//             if (triggerType === 'hover' && !item.contains(e.relatedTarget)) {
//                 hideSubmenu();
//             }
//         });
//     });
// });

 
//     // Close mega menu when clicking outside
//     document.addEventListener('click', function(e) {
//         if (!e.target.closest('.has-mega-menu')) {
//             menuItems.forEach(item => {
//                 const submenu = item.querySelector('.mega-menu__content');
//                 if (submenu && submenu.getAttribute('aria-hidden') === 'false') {
//                     const link = item.querySelector('a');
//                     submenu.setAttribute('aria-hidden', 'true');
//                     link.setAttribute('aria-expanded', 'false');
//                     submenu.style.display = 'none';
//                 }
//             });
//         }
//     });







function register_mega_menu_style() {
    if (!function_exists('mega_menu_background_style')) {
        function mega_menu_background_style() {
            error_log('Function running');
            echo "<!-- Debug: Mega Menu Style Function is running -->";
            
            $bg_color = get_option('mm_bg_color', '#ffffff');
            
            $custom_css = "
                .mega-menu__content {
                    background-color: {$bg_color} !important;
                }
            ";
             
            echo '<style type="text/css">' . $custom_css . '</style>';
        }
        add_action('wp_head', 'mega_menu_background_style');
    }
}
add_action('init', 'register_mega_menu_style', 5); // Priority 5 ensures it runs early



// Add inline styles where I have to.
function pass_css_vars() {
    $breakpoint = get_option('mm_mobile_breakpoint', 1000); // Get the value, default to 1000
    $container_width = get_option('mm_container_width', '1200');
    ?>
    <style>
        @media screen and (min-width: <?php echo $breakpoint; ?>px) {
            .c-main-navigation {
                display: flex !important;
            }
        }
        .mega-menu__content--full-width .mega-menu__content-inner {
            max-width: <?php echo $container_width; ?>px !important;
        }
    </style>
    <?php
}
add_action('wp_head', 'pass_css_vars', 5);




// mega menu walker
class Mega_Menu_Walker extends Walker_Nav_Menu {
    function start_el(&$output, $item, $depth = 0, $args = null, $id = 0) {
        $trigger_type = get_option('mm_dropdown_trigger', 'hover');
        $indent = ($depth) ? str_repeat("\t", $depth) : '';
        
        $has_mega_menu = get_post_meta($item->ID, '_has_mega_menu', true);
        $layout_id = get_post_meta($item->ID, '_mega_menu_layout', true);
        
        $classes = empty($item->classes) ? array() : (array) $item->classes;
        if ($has_mega_menu) {
            $classes[] = 'has-mega-menu';
        }
        
        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        
        // If this is a top-level item with mega menu
        if ($depth === 0 && in_array('has-mega-menu', $classes)) {
            // Add the data attribute to the li element
            $output .= '<li role="none" class="' . esc_attr(implode(' ', $classes)) . '" data-trigger-type="' . esc_attr($trigger_type) . '">';
        } else {
            // Regular menu items without the data attribute
            $output .= '<li role="none" class="' . esc_attr(implode(' ', $classes)) . '">';
        }
        
        $attributes = $this->build_attributes($item);
        
      $item_output = $args->before;
      if ($trigger_type === 'click' && in_array('has-mega-menu', $classes)) {
          $item_output .= '<button'. $attributes .'>';
          $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
          $item_output .= '</button>';
      } else {
          $item_output .= '<a'. $attributes .'>';
          $item_output .= $args->link_before . apply_filters('the_title', $item->title, $item->ID) . $args->link_after;
          $item_output .= '</a>';
      }
      
        
        // Add mega menu content if enabled 
        if ($depth === 0 && $has_mega_menu && $layout_id) {
            $item_output .= $this->get_mega_menu_content($layout_id);
        }
        
        $item_output .= $args->after;
        
        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }

    private function get_mega_menu_content($layout_id) {
      $layout = get_post($layout_id);
      if (!$layout) {
          return '';
      }
      // Get the full-width background setting
        $full_width_bg = get_option('mm_full_width_background', '0');

         // Generate a unique ID for the mega menu content
        $unique_id = 'mega-menu-' . $layout_id;
// If full-width background is enabled, wrap the content in an inner container
if ($full_width_bg === '1') {
    return sprintf(
        '<div id="%s" class="mega-menu__content mega-menu__content--full-width" aria-hidden="true" data-nosnippet role="region" aria-label="Submenu for %s">' .
        '<div class="mega-menu__content-inner">' .
        '%s' .
        '</div>' .
        '</div>',
        esc_attr($unique_id),
        esc_attr($layout->post_title),
        apply_filters('the_content', $layout->post_content)
    );
} else {
  
      return sprintf(
          '<div id="%s" class="mega-menu__content" aria-hidden="true" data-nosnippet role="region" aria-label="Submenu for %s">%s</div>',
          esc_attr($unique_id),
          esc_attr($layout->post_title),
          apply_filters('the_content', $layout->post_content)
      );
  }
}

private function build_attributes($item) {
    $trigger_type = get_option('mm_dropdown_trigger', 'hover');
    $has_mega_menu = get_post_meta($item->ID, '_has_mega_menu', true);
    
    // If it's a click trigger and has mega menu, use button instead of link
    if ($trigger_type === 'click' && $has_mega_menu) {
        $attributes  = ' type="button"';
        $attributes .= !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) .'"' : '';
        $attributes .= ' role="button"';
        $attributes .= ' class="mega-menu-button"'; // Add a class for styling
    } else {
        // Regular link attributes
        $attributes  = !empty($item->attr_title) ? ' title="' . esc_attr($item->attr_title) .'"' : '';
        $attributes .= !empty($item->target) ? ' target="' . esc_attr($item->target) .'"' : '';
        $attributes .= !empty($item->xfn) ? ' rel="' . esc_attr($item->xfn) .'"' : '';
        $attributes .= !empty($item->url) ? ' href="' . esc_attr($item->url) .'"' : '';
        $attributes .= ' role="menuitem"';
    }
    
    // Add ARIA attributes if item has mega menu
    if ($has_mega_menu) {
        $mega_menu_id = 'mega-menu-' . get_post_meta($item->ID, '_mega_menu_layout', true);
        $attributes .= ' aria-expanded="false" aria-haspopup="true" aria-controls="' . esc_attr($mega_menu_id) . '"';
    }
    
    return $attributes;
}

}









function register_mega_menu_post_type() {
    register_post_type('mega_menu_content', array(
        'labels' => array(
            'name' => 'Menu Layouts',
            'singular_name' => 'Menu Layout',
            'add_new' => 'Add New Layout',
            'add_new_item' => 'Add New Menu Layout',
            'edit_item' => 'Edit Menu Layout',
            'new_item' => 'New Menu Layout',
            'view_item' => 'View Menu Layout',
            'search_items' => 'Search Layouts',
            'not_found' => 'No layouts found',
            'not_found_in_trash' => 'No layouts found in trash',
            'menu_name' => 'Menu Layouts'
        ),
        'public' => false,
        'show_ui' => true,
        'show_in_admin_bar' => true,
        'show_in_rest' => true,
        'supports' => array('title', 'editor'),
        'menu_position' => 60,
        'exclude_from_search' => true,
        'publicly_queryable' => false,
        'has_archive' => false,
        'capability_type' => 'page',
        'menu_icon' => 'dashicons-grid-view',
    ));

    // Remove unused metaboxes
    add_action('add_meta_boxes_mega_menu_content', function() {
        remove_meta_box('slugdiv', 'mega_menu_content', 'normal');
        remove_meta_box('postcustom', 'mega_menu_content', 'normal');
    });
}
add_action('init', 'register_mega_menu_post_type');

// Add custom meta box to menu items
function add_mega_menu_metabox() {
    add_meta_box(
        'mega-menu-settings',
        'Mega Menu Settings',
        'render_mega_menu_metabox',
        'nav-menus',
        'side',
        'default'
    );
}
add_action('admin_head-nav-menus.php', 'add_mega_menu_metabox');


// Add this function to display fields in menu items
function add_mega_menu_custom_fields($item_id, $item) {
  $mega_menu = get_post_meta($item_id, '_has_mega_menu', true);
  $mega_menu_layout = get_post_meta($item_id, '_mega_menu_layout', true);
  
  $layouts = get_posts(array(
      'post_type' => 'mega_menu_content',
      'posts_per_page' => -1,
  ));
  ?>
  <div class="mega-menu-fields description-wide">
      <p>
          <label>
              <input type="checkbox" name="menu-item-mega-menu[<?php echo $item_id; ?>]" value="1" <?php checked($mega_menu, '1'); ?> />
              Enable Mega Menu
          </label>
      </p>
      <p>
          <label>Layout:
              <select name="menu-item-mega-menu-layout[<?php echo $item_id; ?>]">
                  <option value="">None</option>
                  <?php foreach ($layouts as $layout) : ?>
                      <option value="<?php echo esc_attr($layout->ID); ?>" <?php selected($mega_menu_layout, $layout->ID); ?>>
                          <?php echo esc_html($layout->post_title); ?>
                      </option>
                  <?php endforeach; ?>
              </select>
          </label>
      </p>
  </div>
  <?php
}
add_action('wp_nav_menu_item_custom_fields', 'add_mega_menu_custom_fields', 10, 2);



function render_mega_menu_metabox() {
    global $nav_menu_selected_id;

    $layouts = get_posts(array(
        'post_type' => 'mega_menu_content',
        'posts_per_page' => -1,
    ));

    ?>
    <div id="mega-menu-fields" class="mega-menu-fields">
        <p>
            <label>
                <input type="checkbox" name="menu-item-mega-menu[0]" value="1" />
                Enable Mega Menu
            </label>
        </p>
        <p>
            <label>Layout:
                <select name="menu-item-mega-menu-layout[0]">
                    <option value="">None</option>
                    <?php foreach ($layouts as $layout) : ?>
                        <option value="<?php echo esc_attr($layout->ID); ?>">
                            <?php echo esc_html($layout->post_title); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </label>
        </p>
    </div>
    <?php
}


// Add this JavaScript to handle the fields
function add_mega_menu_admin_script() {
  ?>
  <script type="text/javascript">
      jQuery(document).ready(function($) {
          $(document).on('menu-item-added', function(event, $menuItem) {
              var templateFields = $('#mega-menu-fields').clone();
              templateFields.find('input, select').each(function() {
                  var name = $(this).attr('name');
                  if (name) {
                      var newName = name.replace('[0]', '[' + $menuItem.find('input.menu-item-data-db-id').val() + ']');
                      $(this).attr('name', newName);
                  }
              });
              $menuItem.find('.menu-item-actions').before(templateFields);
          });
      });
  </script>
  <?php
}
add_action('admin_footer-nav-menus.php', 'add_mega_menu_admin_script');

// Save menu item meta
function save_mega_menu_meta($menu_id, $menu_item_db_id) {
  // Add debugging
  error_log('Saving mega menu meta for menu item: ' . $menu_item_db_id);
  error_log('POST data: ' . print_r($_POST, true));

  if (defined('DOING_AJAX') && DOING_AJAX) {
      return;
  }

  if (isset($_POST['menu-item-mega-menu'][$menu_item_db_id])) {
      update_post_meta($menu_item_db_id, '_has_mega_menu', '1');
      error_log('Saved has_mega_menu');
  } else {
      delete_post_meta($menu_item_db_id, '_has_mega_menu');
      error_log('Deleted has_mega_menu');
  }

  if (isset($_POST['menu-item-mega-menu-layout'][$menu_item_db_id])) {
      $layout_id = sanitize_text_field($_POST['menu-item-mega-menu-layout'][$menu_item_db_id]);
      update_post_meta($menu_item_db_id, '_mega_menu_layout', $layout_id);
      error_log('Saved mega_menu_layout: ' . $layout_id);
  }
}

add_action('wp_update_nav_menu_item', 'save_mega_menu_meta', 10, 2);



// Add custom column to mega menu content list
function add_mega_menu_columns($columns) {
    $new_columns = array();
    foreach($columns as $key => $value) {
        if($key == 'date') {
            // Insert our column before the date column
            $new_columns['menu_usage'] = 'Used In Menus';
        }
        $new_columns[$key] = $value;
    }
    return $new_columns;
}
add_filter('manage_mega_menu_content_posts_columns', 'add_mega_menu_columns');

// Populate the custom column
function populate_mega_menu_columns($column, $post_id) {
    if($column === 'menu_usage') {
        global $wpdb;
        
        $menu_items = $wpdb->get_results($wpdb->prepare(
            "SELECT DISTINCT mi.ID as menu_item_id, m.term_id, p2.post_title as nav_label
            FROM {$wpdb->prefix}postmeta pm
            JOIN {$wpdb->prefix}posts mi ON pm.post_id = mi.ID
            JOIN {$wpdb->prefix}term_relationships tr ON mi.ID = tr.object_id
            JOIN {$wpdb->prefix}term_taxonomy tt ON tr.term_taxonomy_id = tt.term_taxonomy_id
            JOIN {$wpdb->prefix}terms m ON tt.term_id = m.term_id
            JOIN {$wpdb->prefix}postmeta pm2 ON mi.ID = pm2.post_id AND pm2.meta_key = '_menu_item_object_id'
            JOIN {$wpdb->prefix}posts p2 ON pm2.meta_value = p2.ID
            WHERE pm.meta_key = '_mega_menu_layout'
            AND pm.meta_value = %d
            AND tt.taxonomy = 'nav_menu'",
            $post_id
        ));

        if(!empty($menu_items)) {
            foreach($menu_items as $item) {
                $menu_name = get_term($item->term_id, 'nav_menu')->name;
                
                echo '<div>';
                echo sprintf(
                    '<a href="%s">%s → %s</a>',
                    esc_url(admin_url('nav-menus.php?action=edit&menu=' . $item->term_id)),
                    esc_html($menu_name),
                    esc_html($item->nav_label)
                );
                echo '</div>';
            }
        } else {
            echo '<span class="description">Not in use</span>';
        }
    }
}



add_action('manage_mega_menu_content_posts_custom_column', 'populate_mega_menu_columns', 10, 2);



// ADD THE BACKEND SETTINGS PAGE
// Add submenu page for Mega Menu Settings
function add_mega_menu_settings_page() {
    add_submenu_page(
        'edit.php?post_type=mega_menu_content',
        'Mega Menu Settings',
        'Settings',
        'manage_options',
        'mega-menu-settings',
        'render_mega_menu_settings_page'
    );
}
add_action('admin_menu', 'add_mega_menu_settings_page');


// add the settings
function register_mega_menu_settings() {
    register_setting('mega_menu_settings', 'mm_container_width');
    register_setting('mega_menu_settings', 'mm_full_width_background');
    register_setting('mega_menu_settings', 'mm_bg_color');
    register_setting('mega_menu_settings', 'mm_text_color');

    register_setting('mega_menu_settings', 'mm_dropdown_trigger');
    register_setting('mega_menu_settings', 'mm_mobile_breakpoint');

}
add_action('admin_init', 'register_mega_menu_settings');





function render_mega_menu_settings_page() {
    // Save settings if form is submitted
    if (isset($_POST['mm_save_settings']) && check_admin_referer('mega_menu_settings_nonce')) {
        $full_width_bg = isset($_POST['mm_full_width_background']) ? 1 : 0;
        update_option('mm_full_width_background', $full_width_bg);
        
        // Save other settings...
        update_option('mm_container_width', sanitize_text_field($_POST['mm_container_width']));
        update_option('mm_bg_color', sanitize_hex_color($_POST['mm_bg_color']));

        update_option('mm_dropdown_trigger', sanitize_text_field($_POST['mm_dropdown_trigger']));
        update_option('mm_mobile_breakpoint', sanitize_text_field($_POST['mm_mobile_breakpoint']));
        
        // Add success message
        add_settings_error('mega_menu_settings', 'settings_updated', 'Settings saved successfully.', 'updated');
    }



    




    
    ?>
    <div class="wrap mega-menu-settings">
        <h1 class="settings-title">🎨 Mega Menu Settings</h1>
        
        <form method="post" action="">
            <?php wp_nonce_field('mega_menu_settings_nonce'); ?>
            <div class="settings-container">
                <div class="settings-grid">
                    <!-- Layout Settings Card -->
                    <div class="settings-card">
                        <div class="card-header">
                            <h2>Layout Settings</h2>
                            <span class="badge">Core</span>
                        </div>
                        <div class="card-content">
                            
                        <div class="form-group">
                                <label class="switch-label">
                                    <input type="checkbox" 
                                           name="mm_full_width_background" 
                                           value="1" 
                                           <?php checked(get_option('mm_full_width_background'), 1); ?>>
                                    Full Width Background
                                </label>
                                <p class="description">Menu background extends full width while content stays within container</p>
                            </div>
                        <div class="form-group">
                                <label>Container Width</label>
                                <input type="text" 
                                       name="mm_container_width" 
                                       value="<?php echo esc_attr(get_option('mm_container_width', '1200')); ?>" 
                                       placeholder="1200">
                                <p class="description">Enter the width of your mega menu container in px's. only applicable to full width background</p>
                            </div>
                            
                        </div>
                    </div>

                    <!-- Style Settings Card -->
                    <div class="settings-card">
                        <div class="card-header">
                            <h2>Style Settings</h2>
                            <span class="badge">Design</span>
                        </div>
                        <div class="card-content">
                            <div class="form-group">
                                <label>Menu Background Color</label>
                                <input type="color" 
                                       name="mm_bg_color" 
                                       value="<?php echo esc_attr(get_option('mm_bg_color', '#ffffff')); ?>">
                            </div>
                            
                          
                      
                        </div>
                    </div>

                    <!-- Behavior Settings Card -->
                    <div class="settings-card">
                        <div class="card-header">
                            <h2>Behavior Settings</h2>
                            <span class="badge">Interactive</span>
                        </div>
                        <div class="card-content">
                   
                            <div class="form-group">
                                <label>Dropdown Trigger</label>
                                <select name="mm_dropdown_trigger">
                                    <option value="hover" <?php selected(get_option('mm_dropdown_trigger'), 'hover'); ?>>Hover</option>
                                    <option value="click" <?php selected(get_option('mm_dropdown_trigger'), 'click'); ?>>Click</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Mobile Breakpoint</label>
                                <input type="text" 
                                       name="mm_mobile_breakpoint" 
                                       value="<?php echo esc_attr(get_option('mm_mobile_breakpoint', '768')); ?>" 
                                       placeholder="768">
                                <p class="description">Width in px at which the menu switches to mobile view</p>
                            </div>
                        </div>
                    </div>

                </div>
                
                <div class="settings-submit">
                    <input type="submit" name="mm_save_settings" class="button-primary" value="Save All Settings">
                </div>
            </div>
        </form>
    </div>





<style>
.settings-title {
    font-size: 2.5em;
    margin-bottom: 30px;
    color: #23282d;
    font-weight: 500;
}

.settings-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 20px;
    margin-top: 20px;
}

.settings-card {
    background: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    overflow: hidden;
    transition: transform 0.2s;
}

.settings-card:hover {
    transform: translateY(-2px);
}

.card-header {
    padding: 15px 20px;
    background: #f8f9fa;
    border-bottom: 1px solid #eee;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.card-header h2 {
    margin: 0;
    font-size: 1.2em;
    color: #23282d;
}

.card-content {
    padding: 20px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
}

.form-group input[type="text"],
.form-group select {
    width: 100%;
    padding: 8px;
    border: 1px solid #ddd;
    border-radius: 4px;
}

.badge {
    background: #0073aa;
    color: white;
    padding: 4px 8px;
    border-radius: 4px;
    font-size: 12px;
}

/* Switch Toggle */
.switch {
    position: relative;
    display: inline-block;
    width: 60px;
    height: 34px;
}

.switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: #ccc;
    transition: .4s;
    border-radius: 34px;
}

.slider:before {
    position: absolute;
    content: "";
    height: 26px;
    width: 26px;
    left: 4px;
    bottom: 4px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

input:checked + .slider {
    background-color: #2196F3;
}

input:checked + .slider:before {
    transform: translateX(26px);
}

/* Statistics Styling */
.stat-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 10px 0;
    border-bottom: 1px solid #eee;
}

.stat-value {
    font-size: 1.2em;
    font-weight: bold;
    color: #0073aa;
}

/* Button Styling */
.button-primary {
    background: #0073aa;
    border-color: #0073aa;
    color: white;
    padding: 8px 16px;
    border-radius: 4px;
    cursor: pointer;
    transition: all 0.2s;
}

.button-primary:hover {
    background: #005177;
}

</style>
    <?php    
}



