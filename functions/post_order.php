<?php

// Add Options to DB
function add_post_order_options() {
	$options = array(
		'autosort' => '0',
		'adminsort' => '1',
		'level' => '0', // user level
		'ignore_sticky_posts' => '0',
		'feedsort' => '0',
		'always_show_thumbnails' => '0',
		'allow_post_types' => array(
			'type_slide', 
			'staff'
		)
	);
	update_option( 'cpto_options', $options );
}
add_action( 'after_setup_theme', 'add_post_order_options' ); 

require( 'post-order/advanced-post-types-order.php' );


/****************
 Sample: force to use my own order
 ****************/
$args = array(
	'post_type' => 'feature',
	'orderby' => 'rand',
	'force_no_custom_order' => true,
);
/***************
****************/

