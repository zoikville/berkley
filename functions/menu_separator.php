<?php

// Add Admin Menu Separator
function add_admin_menu_separator($position, $index) {
  global $menu;
  $value = array('','read',"separator{$index}",'','wp-menu-separator');
  array_splice($menu, $position, 0, array($value));
}
add_action('admin_init','admin_menu_separator');
function admin_menu_separator() {
	// The First Para is Position, the Second Should i++ from 3
	add_admin_menu_separator(5, 3);
	add_admin_menu_separator(8, 4);
	add_admin_menu_separator(12, 5);
} 

?>