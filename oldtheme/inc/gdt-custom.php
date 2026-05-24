<?php
/**
 * Custom functions for this project? If yes, drop them here!
 */

  // If using acf icon picker - https://github.com/houke/acf-icon-picker -  modify the path to the icons directory
//   add_filter( 'acf_icon_path_suffix', 'acf_icon_path_suffix' );

//   function acf_icon_path_suffix( $path_suffix ) {
//       return 'img/icons/';
//   }
  
//used for Stackable blocks support - match to wrapper width 
global $content_width;
$content_width = 1180;

// ****************** Grab custom data and input into Generate Block headline field ************

                  // function custom_field_gb_query() {
                  //   // Start output buffering
                  //   ob_start();
                  //     //  shortcode content
                      

                  //   $output = ob_get_clean();

                  //   // Return the content as a string
                  //   return $output;
                  // }
                  // add_shortcode('custom_field_gb_query', 'custom_field_gb_query');



                  // add_filter( 'render_block_generateblocks/headline', function( $block_content, $block ) {
                  //   if ( 
                  //     !is_admin() && 
                  //     ! empty( $block['attrs']['className'] ) && 
                  //     strpos( $block['attrs']['className'], 'is-field-name' ) !== false 
                  //   ) {
                  //     $post_id = get_the_ID();
                  //     $block_content = do_shortcode('[custom_field_gb_query]');		
                  //   }

                  //   return $block_content;
                  // }, 10, 2 );

// ****************** Grab custom data and input into Generate Block headline field ************

?>
