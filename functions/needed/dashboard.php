<?php

// Remove default widgets
function remove_dashboard_widgets() {
	global $wp_meta_boxes;
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
	unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_recent_drafts']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
	unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
}
add_action('wp_dashboard_setup', 'remove_dashboard_widgets' );

// Remove Admin Menu
function remove_menus () {
	global $menu;
	$restricted = array( __('Dashboard'), __('Media'), __('Links'),__('Posts'), __('Comments')/*, __('Tools')*/ );
	end ($menu);
	while ( prev($menu) ) {
		$value = explode( ' ',$menu[key($menu)][0] );
		if( in_array( $value[0] != NULL ? $value[0] : '', $restricted ) ) { unset( $menu[key($menu)] ); }
	}
}
add_action('admin_menu', 'remove_menus');

// Hide Welcome Panel
function hide_welcome_panel() {
	$user_id = get_current_user_id();
	if ( 1 == get_user_meta( $user_id, 'show_welcome_panel', true ) )
		update_user_meta( $user_id, 'show_welcome_panel', 0 );
}
add_action( 'load-index.php', 'hide_welcome_panel' );

// Remove Sub Menu
function remove_submenu() {
	remove_submenu_page( 'options-general.php', 'options-privacy.php' );  // main-menu-slug, sub-menu-sug
	remove_submenu_page( 'themes.php', 'widgets.php' );
}
//add_action('admin_init','remove_submenu');

// Dashboard widget content
function dashboard_widget_function() {
	echo "Hello World, I'm a great Dashboard Widget";
}
function add_dashboard_widgets() {
	wp_add_dashboard_widget('dashboard_widget_name', 'Dashboard Widget Name', 'dashboard_widget_function');
}
// Register widget
// add_action('wp_dashboard_setup', 'add_dashboard_widgets' );
// tr#contact-form-7
// Clear Header
function clear_header() {
	echo '
	<style type="text/css" media="screen">
		#wp-admin-bar-wp-logo,
		#wp-admin-bar-comments,
		#wp-admin-bar-new-content,
		#wp-admin-bar-updates,
		#contextual-help-link-wrap
		{
			display: none;
		}
	</style>';
}
add_action( 'admin_head', 'clear_header' );

// Custom Footer Copyright
function modify_footer_admin () {
	return 'Powered By Zhou';
}
//add_filter('admin_footer_text', 'modify_footer_admin');

// Custom Footer Version Info
function change_footer_version() {
	return '<a href="mailto:zhou.working@gmail.com">Contact Me</a>';
}
//add_filter( 'update_footer', 'change_footer_version', 9999);



// Reorder Menus
function custom_menu_order($menu_ord) {
	if (!$menu_ord) return true;
	return array(
		'index.php', // Dashboard
		'edit.php', // Posts
		'upload.php', // Media
		'link-manager.php', // Links
		'edit.php?post_type=page', // Pages
		'edit-comments.php', // Comments
		'themes.php', // Appearance
		'plugins.php', // Plugins
		'users.php', // Users
		'tools.php', // Tools
		'options-general.php' // Settings
	);
}
//add_filter('custom_menu_order', 'custom_menu_order');
//add_filter('menu_order', 'custom_menu_order');

//  Remove Post Edit Page Blocks
function customize_meta_boxes() {
	remove_meta_box('categorydiv','post','normal');
	remove_meta_box('tagsdiv-post_tag','post','normal');
	// remove_meta_box('slugdiv','post','normal');
	remove_meta_box('postimagediv','post','normal');
	remove_meta_box('postexcerpt','post','normal');
	remove_meta_box('formatdiv','post','normal');
	remove_meta_box('trackbacksdiv','post','normal');
	remove_meta_box('postcustom','post','normal');
	// remove_meta_box('commentstatusdiv','post','normal');
	// remove_meta_box('commentsdiv','post','normal');
	remove_meta_box('authordiv','post','normal');
	// remove_meta_box('revisionsdiv','post','normal');

	// remove_meta_box('slugdiv','page','normal');
	remove_meta_box('postimagediv','page','normal');
	remove_meta_box('postexcerpt','page','normal');
	remove_meta_box('formatdiv','page','normal');
	remove_meta_box('trackbacksdiv','page','normal');
	remove_meta_box('postcustom','page','normal');
	remove_meta_box('commentstatusdiv','page','normal');
	remove_meta_box('commentsdiv','page','normal');
	remove_meta_box('authordiv','page','normal');
	remove_meta_box('revisionsdiv','page','normal');
}
add_action('admin_init','customize_meta_boxes');

// Change default post menu label
function change_post_menu_label() {
	global $menu;
	global $submenu;
	$menu[5][0] = 'Events';
	$submenu['edit.php'][5][0] = 'All Events';
	$submenu['edit.php'][10][0] = 'Add New';
	// $submenu['edit.php'][15][0] = 'Status'; // Change name for categories
	// $submenu['edit.php'][16][0] = 'Labels'; // Change name for tags
	echo '';
}
function change_post_object_label() {
	global $wp_post_types;
	$labels = &$wp_post_types['post']->labels;
	$labels->name = 'Events';
	$labels->singular_name = 'Event';
	$labels->add_new = 'Add Event';
	$labels->add_new_item = 'Add Event';
	$labels->edit_item = 'Edit Event';
	$labels->new_item = 'New Event';
	$labels->view_item = 'View Event';
	$labels->search_items = 'Search Events';
	$labels->not_found = 'No Events found';
	$labels->not_found_in_trash = 'No Events found in Trash';
}
//add_action( 'init', 'change_post_object_label' );
//add_action( 'admin_menu', 'change_post_menu_label' );

// Remove Items from the Post and Page Columns
function custom_post_columns($defaults) {
	unset($defaults['comments']);
	unset($defaults['tags']);
	return $defaults;
}
function custom_pages_columns($defaults) {
	unset($defaults['comments']);
	return $defaults;
}
add_filter('manage_posts_columns', 'custom_post_columns');
add_filter('manage_pages_columns', 'custom_pages_columns');

// add post type class to body admin
function sld_admin_body_class( $classes ) {
	global $wpdb, $post;
	$post_type = get_post_type( $post->ID );
	if ( is_admin() ) {
		$classes .= 'type-' . $post_type;
	}
	return $classes;
}
add_filter( 'admin_body_class', 'sld_admin_body_class' );

// Make large size be selected by default in media upload window
function make_full_size_be_selected_by_default(){
	update_option('image_default_size', 'full');
}
add_action( 'after_setup_theme', 'make_full_size_be_selected_by_default' ); 

// Custom javascript
function of_javascript(){
	echo 
	'<script type="text/javascript">
		jQuery(document).ready( function() {
			if(jQuery("#menu-posts-type_related_media").hasClass("wp-has-current-submenu") || jQuery("#menu-posts-type_partners").hasClass("wp-has-current-submenu") || jQuery("#menu-posts-type_third_events").hasClass("wp-has-current-submenu")){
				jQuery("#postdivrich").css({"height": "0px", "overflow": "hidden"});
			}
		} )
	</script>';
}
// add_action('admin_head', 'of_javascript');

