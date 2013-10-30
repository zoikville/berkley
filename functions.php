<?php

include TEMPLATEPATH.'/functions/needed/general.php';
include TEMPLATEPATH.'/functions/needed/login.php';
include TEMPLATEPATH.'/functions/needed/useful.php';
include TEMPLATEPATH.'/functions/needed/meta.php';
include TEMPLATEPATH.'/functions/needed/disable-updates.php';
include TEMPLATEPATH.'/functions/needed/showid.php';
include TEMPLATEPATH.'/functions/needed/seo_fields.php';
include TEMPLATEPATH.'/functions/needed/menu.php';
include TEMPLATEPATH.'/functions/post_type.php';
include TEMPLATEPATH.'/functions/taxonomy.php';
include TEMPLATEPATH.'/functions/post_order.php';
include TEMPLATEPATH.'/functions/custom_meta.php';
include TEMPLATEPATH.'/functions/pagenavi.php';
include TEMPLATEPATH.'/functions/needed/dashboard.php';
include TEMPLATEPATH.'/functions/shortcodes/tinymce_loader.php';
// include TEMPLATEPATH.'/functions/widget.php';

include TEMPLATEPATH.'/functions/tax_meta.php';
// include TEMPLATEPATH.'/functions/tax_order.php';


// Get JS and CSS for Frontend
function my_enqueue_scripts_frontpage() {
	wp_enqueue_style( 'global', get_stylesheet_uri() );

	wp_deregister_script( 'jquery' );
	wp_enqueue_script( 'modernizr', get_stylesheet_directory_uri() . '/js/modernizr.js' );
	wp_enqueue_script( 'jquery', get_stylesheet_directory_uri() . '/js/jquery.js' );
	wp_enqueue_script( 'carouFredSel', get_stylesheet_directory_uri() . '/js/carouFredSel.js' );
	wp_enqueue_script( 'uniform', get_stylesheet_directory_uri() . '/js/uniform.js' );
	wp_enqueue_script( 'functions', get_stylesheet_directory_uri() . '/js/functions.js' );

}
add_action( 'wp_enqueue_scripts', 'my_enqueue_scripts_frontpage' );


// Add Theme Menu
if ( STYLESHEETPATH == TEMPLATEPATH ) {
	define('OF_FILEPATH', TEMPLATEPATH);
	define('OF_DIRECTORY', get_stylesheet_directory_uri());
} else {
	define('OF_FILEPATH', STYLESHEETPATH);
	define('OF_DIRECTORY', get_stylesheet_directory_uri());
}
require_once (OF_FILEPATH . '/admin/admin-functions.php'); // Custom functions and plugins
require_once (OF_FILEPATH . '/admin/admin-interface.php'); // Admin Interfaces (options,framework, seo)
require_once (OF_FILEPATH . '/admin/theme-options.php'  ); // Options panel settings and custom settings
require_once (OF_FILEPATH . '/admin/theme-functions.php'); // Theme actions based on options settings


add_action( 'admin_footer-edit-tags.php', 'wpse_56569_remove_cat_tag_description' );

function wpse_56569_remove_cat_tag_description(){
	global $current_screen;
	switch ( $current_screen->id ) {
		case 'edit-category':
		break;
		case 'edit-post_tag':
		break;
	}
	?>
	<script type="text/javascript">
	jQuery(document).ready( function($) {
		$('#tag-description,#parent').closest('.form-field').remove();
	});
	</script>
	<?php
}

function special_nav_class($classes, $item){
	global $wp_query;
	$currnetPostType = $wp_query->query['post_type'];
	
	$my_class = strtolower($item->title);
	
	if ($currnetPostType == $my_class) {
		//$my_class = str_replace(' ', '-', 'current_page_item menu-'.$my_class);
		$my_class = 'current_page_item menu-'.$my_class;
	} else {
		$my_class = 'menu-'.$my_class;
	}
	
	$classes[] = $my_class;
	return $classes;
}
add_filter('nav_menu_css_class' , 'special_nav_class' , 10 , 2);


add_image_size( 'featured', 940, 320, true );
add_image_size( 'staff-photo', 180, 180, true );


function posttype_admin_css() {
	global $post_type;
	if ($post_type == 'slider') {
		echo '<style type="text/css">#side-sortables #slider-meta,#edit-slug-box,#view-post-btn,#post-    preview,.updated p a{display: none;}</style>';
	}
}
add_action('admin_head', 'posttype_admin_css');


function my_content($contents, $num) {
	$content = strip_tags(html_entity_decode($contents, ENT_COMPAT, 'UTF-8'));
	if(strlen($content) > $num) {
		// $matches = array();
		// preg_match("/^(.{1,$num})[\s]/i", $content, $matches);
		// $trimmed_text = $matches[0]. '...';
		// echo $trimmed_text;
		$content = substr($content, 0, $num); 
		$content = $content.'...';
		echo $content;
	}else{
		echo $content;
	}
}







function favicon(){
echo '<link rel="shortcut icon" href="',get_template_directory_uri(),'/favicon2.ico" />',"\n";
}






function shortcode_featured( $atts, $content = null ) {
	extract(shortcode_atts(array(
		'title' => 'no title'
	), $atts));

	$html .= '<div class="featured-item">';
	$html .= '<h2 class="title">'.$title.'</h2>';
	$html .= '<div class="content">'. do_shortcode($content) . '</div>';
	$html .= '</div>';
	
	return $html;
}
add_shortcode('featured', 'shortcode_featured');

function shortcode_subheading( $atts, $title = null ) {
	$html .= '<h2 class="post-subheading">'.$title.'</h2>';
	return $html;
}
add_shortcode('subheading', 'shortcode_subheading');

function shortcode_link( $atts, $text = null ) {
	extract(shortcode_atts(array(
		'url' => '/',
		'bold' => 'no'
	), $atts));

	if($bold == 'yes') {
		$class = 'bold';
	} else {
		$class = '';
	}
	
	$html .= '<span class="post-link '. $class .'"><a href="'. $url .'">'.$text.'</a></span>';
	return $html;
}
add_shortcode('link', 'shortcode_link');

function shortcode_line() {
	$html .= '<hr class="post-hr">';
	return $html;
}
add_shortcode('hr', 'shortcode_line');

function shortcode_columns( $atts) {
	extract(shortcode_atts(array(
		'lefttitle' => '',
		'leftcontent' => '',
		'righttitle' => '',
		'rightcontent' => ''
	), $atts));
	
	$html .= '<div class="clearfix two-columns">';
	$html .= '<div class="left-column"><h2 class="title">'.do_shortcode($lefttitle).'</h2>';
	$html .= '<div class="content">'. do_shortcode($leftcontent) . '</div></div>';
	$html .= '<div class="right-column"><h2 class="title">'.do_shortcode($righttitle).'</h2>';
	$html .= '<div class="content">'. do_shortcode($rightcontent) . '</div></div>';
	$html .= '</div>';
	
	return $html;
}
add_shortcode('columns', 'shortcode_columns');