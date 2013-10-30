<?php

// functions run on activation –> important flush to clear rewrites
if ( is_admin() && isset($_GET['activated'] ) && $pagenow == 'themes.php' ) {
	$wp_rewrite->flush_rules();
}

// Disable posts auto saving
function disableAutoSave(){
	wp_deregister_script('autosave');
}
// add_action( 'wp_print_scripts', 'disableAutoSave' );

// Contact Form 7 Placeholder
function wpcf7_form_elements_filter( $form ) {
	$form = str_replace( 'title="', 'placeholder="', $form );
	$form = preg_replace( '/\"\>(.[^\<\>\"]+?)\<\\/textarea\>/', '" placeholder="\1"></textarea>', $form );
	$form = str_replace( 'wpcf7-use-title-as-watermark', '', $form );
	return $form;
}
add_filter( 'wpcf7_form_elements', 'wpcf7_form_elements_filter' );

// Body Classes
function of_body_classes($classes) {
	$classes[] = '';
	return $classes;
}
// add_filter( 'body_class', 'of_body_classes' );

function of_media_items_args( $args ) {
	$args['send'] = true;
	return $args;
}
add_filter( 'get_media_item_args', 'of_media_items_args' );

// Remove WordPress Version For Security Reasons
remove_action('wp_head', 'wp_generator');

function of_admin_bar_css() {
	if( ! is_user_logged_in() ) return false;
	echo '
		<style type="text/css" media="screen">
			#wp-admin-bar-wp-logo, #wp-admin-bar-search { display: none; }
		</style>
	';
}
add_action('wp_head', 'of_admin_bar_css');

// Remove Frontpage Adminbar
// add_filter( 'show_admin_bar', '__return_false' );

// Remove Editor From Admin Appearance Menu
function remove_the_editor() {
	remove_action('admin_menu', '_add_themes_utility_last', 101);
}
add_action('_admin_menu', 'remove_the_editor', 1);

// Remove the Title Attribute from the Menu
function my_menu_notitle( $menu ){
	return $menu = preg_replace('/ title=\"(.*?)\"/', '', $menu );
}
add_filter( 'wp_nav_menu', 'my_menu_notitle' );
add_filter( 'wp_page_menu', 'my_menu_notitle' );
add_filter( 'wp_list_categories', 'my_menu_notitle' );

// remove junk from head
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wp_generator');
remove_action('wp_head', 'wlwmanifest_link');
remove_action('wp_head', 'feed_links_extra', 3);
remove_action('wp_head', 'start_post_rel_link', 10, 0);
remove_action('wp_head', 'parent_post_rel_link', 10, 0);

// Make orderby => rand work
remove_all_filters('posts_orderby');

// we normally want these to be active
// remove_action('wp_head', 'feed_links', 2);
// remove_action('wp_head', 'index_rel_link');
// remove_action('wp_head', 'adjacent_posts_rel_link', 10, 0);

