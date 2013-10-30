<?php


// create a new taxonomy
function new_taxonomy() {
	
	$labels = array(
		'name' => _x( 'Office', 'taxonomy general name' ),
		'singular_name' => _x( 'Office', 'taxonomy singular name' ),
		'search_items' =>  __( 'Search Office' ),
		'all_items' => __( 'All Office' ),
		// 'parent_item' => __( 'Parent Office' ),
		'parent_item_colon' => __( 'Parent Office:' ),
		'edit_item' => __( 'Edit Office' ),'update_item' => __( 'Update Office' ),
		'add_new_item' => __( 'Add New Office' ),
		'new_item_name' => __( 'New Office Name' ),
		'menu_name' => __( 'Office' ),
	);

	register_taxonomy(
		'office', //The name of the taxonomy. Name must not contain capital letters or spaces. 
		array('staff'),
		array(
			'labels' => $labels,
			'show_tagcloud' => false,
			'sort' => true,
			'rewrite' => array('slug' => 'office', ),
			'hierarchical' => true, // Tags Style or Categories Style
			'args' => array( 'orderby' => 'term_order' )
		)
	);
	
}
add_action( 'init', 'new_taxonomy' );

// Unregister Taxonomy
function unregister_taxonomy(){
	global $wp_taxonomies;

	$taxonomy_1 = 'category';
	if ( taxonomy_exists( $taxonomy_1))
		unset( $wp_taxonomies[$taxonomy_1]);
	$taxonomy_2 = 'post_tag';
	if ( taxonomy_exists( $taxonomy_2))
		unset( $wp_taxonomies[$taxonomy_2]);
		
}
//add_action( 'init', 'unregister_taxonomy');

