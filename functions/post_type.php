<?php

// Define New Post Type
add_action( 'init', 'create_post_type' );
function create_post_type() {
	
	register_post_type( 'slider', array(
		'labels' => array(
			'name' => __( 'Slider' ),
			'singular_name' => __( 'Slider' ),
			'add_new_item' => __( 'Add New Slider' ),
			'edit_item' => __( 'Edit Slider' ),
			'new_item' => __( 'New Slider' ),
			'view_item' => __( 'View Slider' ),
			'search_item' => __( 'Search Slider' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'not_found' => __( 'Not Found' ),
		),
		'menu_position' => 4,
		'public' => true,
		'has_archive' => true,
		'hierarchical' => false, 
		'rewrite' => array( 'slug' => 'slider' ),
		'supports' => array( 'title', 'page-attributes' )
	) );




	register_post_type( 'staff', array(
		'labels' => array(
			'name' => __( 'Staff' ),
			'singular_name' => __( 'Staff' ),
			'add_new_item' => __( 'Add New Staff' ),
			'edit_item' => __( 'Edit Staff' ),
			'new_item' => __( 'New Staff' ),
			'view_item' => __( 'View Staff' ),
			'search_item' => __( 'Search Staff' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'not_found' => __( 'Not Found' ),
		),
		'menu_position' => 4,
		'public' => true,
		'has_archive' => true,
		'hierarchical' => false, 
		'rewrite' => array( 'slug' => 'staff' ),
		'supports' => array( 'title'/*, 'editor'*/ )
	) );

	register_post_type( 'news', array(
		'labels' => array(
			'name' => __( 'News' ),
			'singular_name' => __( 'News' ),
			'add_new_item' => __( 'Add New News' ),
			'edit_item' => __( 'Edit News' ),
			'new_item' => __( 'New News' ),
			'view_item' => __( 'View News' ),
			'search_item' => __( 'Search News' ),
			'parent_item' => null,
			'parent_item_colon' => null,
			'not_found' => __( 'Not Found' ),
		),
		'menu_position' => 4,
		'public' => true,
		'has_archive' => true,
		'hierarchical' => false, 
		'rewrite' => array( 'slug' => 'news' ),
		'supports' => array( 'title', 'editor' )
	) );
}

