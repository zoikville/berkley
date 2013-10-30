<?php

// How to use:

// $id = get_the_ID();
 
  /*
  * Grab the saved menu name that we saved with our Meta Box
  */
  // $menu_to_use = get_post_meta($id, 'themestore-meta-menu-name', 1);

  /*
  * Print the html
  */
  // of_menu( $menu_to_use, 'menu_'.$menu_to_use, 'menu_id_'.$menu_to_use, '1' );

function themestore_get_all_menus() {
  $menu_obj = get_terms( 'nav_menu' );
  return $menu_obj;
}

$meta_box_menu = array(
    'id' => 'themestore-meta-menu',
    'title' => 'Navigation',
    'page' => 'page',
    'context' => 'side',
    'priority' => 'default',
    'fields' => array(
        array(
            'id' => 'themestore-meta-menu-name',
            'type' => 'select',
            'std' => 'none'
        ),
    ),
);
 
/*
* This function will register the meta box with WordPress
*/
function themestore_add_box() {
    global $meta_box_menu;
    add_meta_box($meta_box_menu['id'], $meta_box_menu['title'], 'themestore_meta_menu_html', $meta_box_menu['page'], $meta_box_menu['context'], $meta_box_menu['priority']);
}
add_action('admin_init', 'themestore_add_box');
 
/*
* This function will produce the html needed to display our meta box in the admin area
*/

function themestore_meta_menu_html() {
  global $meta_box_menu, $post;
 
  $output = '<p style="padding:10px 0 0 0;">'.__('Choose which menu shows up in the secondary spot for this page. This will override any selections made in Appearance > Menus', 'themestore').'</p>';
  $output .= '<input type="hidden" name="sf_meta_box_nonce" value="'. wp_create_nonce(basename(__FILE__)). '" />';
 
  $output .= '<table class="form-table">';
 
  foreach ($meta_box_menu['fields'] as $field) {
    $meta = get_post_meta($post->ID, $field['id'], true);
 
    /*
    *   Get out all our menus using the function from functions.php
    */
    $menus = themestore_get_all_menus();
 
    /*
    *   Grab out saved data for edit mode
    */
    $meta = get_post_meta($post->ID, $field['id'], true);
 
    $output .= '<select name="'.$field['id'].'" class="widefat">';
    $output .= '<option value="none">- none -</option>';
    if(is_array($menus)):
      foreach($menus as $k => $v):
        if($meta==$v->slug):
          $output .= '<option selected="selected" value="' . $v->slug .'">' . $v->name . '</option>';
        else:
          $output .= '<option value="' . $v->slug .'">' . $v->name . '</option>';
        endif;
      endforeach;
    endif;
    $output .= '</select>';
 
  }
 
  $output .= '</table>';
 
  echo $output;
}

 
/*
* This function will save our preferences into the database
*/
function themestore_save_data($post_id) {
 
  global $meta_box, $meta_box_menu;
 
    foreach ($meta_box_menu['fields'] as $field) {
      $old = get_post_meta($post_id, $field['id'], true);
      $new = $_POST[$field['id']];
 
      if ($new && $new != $old) {
        update_post_meta($post_id, $field['id'], stripslashes(htmlspecialchars($new)));
      } elseif ('' == $new && $old) {
        delete_post_meta($post_id, $field['id'], $old);
      }
    }
}
add_action('save_post', 'themestore_save_data');