<?php

// Extended from https://github.com/jkudish/custom-metadata

include 'custom-meta/custom_metadata.php';

add_action( 'admin_init', 'x_init_custom_fields' );
function x_init_custom_fields() {

	if( function_exists( 'x_add_metadata_group' ) && function_exists( 'x_add_metadata_field' ) ) {

		/******************* Slider ****************************/
		x_add_metadata_group( 'x_slider', 'type_slider', array(
			'label' => 'Slider'
		) );

			x_add_metadata_field('x_slider_sub_title', 'slider', array(
				'group' => 'x_slider',
				'field_type' => 'text',
				'label' => 'Subheading Text',
				'description' => ''
			));

			x_add_metadata_field('x_slider_image', 'slider', array(
				'group' => 'x_slider',
				'field_type' => 'upload',
				'label' => 'Slider Image (940×320)',
				'display_column' => true,
				'display_column_callback' => 'of_field_column_thumb_callback',
				'description' => ''
			));
			
			x_add_metadata_field('x_slider_description', 'slider', array(
				'group' => 'x_slider',
				'field_type' => 'textarea',
				'label' => 'Slider Description',
				'description' => ''
			));
			
			x_add_metadata_field('x_slider_link_text', 'slider', array(
				'group' => 'x_slider',
				'field_type' => 'text',
				'label' => 'Slider Link Text',
				'description' => ''
			));
			
			x_add_metadata_field('x_slider_link', 'slider', array(
				'group' => 'x_slider',
				'field_type' => 'text',
				'label' => 'Slider Link',
				'description' => ''
			));
		
		/******************* Deal Info ****************************/
		x_add_metadata_group( 'x_staff', 'type_staff', array(
			'label' => 'Slider'
		) );
		
			x_add_metadata_field('x_staff_job_title', 'staff', array(
				'group' => 'x_staff',
				'field_type' => 'text',
				'label' => 'Staff Job title',
				'description' => ''
			));
			
			x_add_metadata_field('x_staff_photo', 'staff', array(
				'group' => 'x_staff',
				'field_type' => 'upload',
				'label' => 'Staff Photo (180×180)',
				'description' => ''
			));
			
			x_add_metadata_field('x_staff_direct', 'staff', array(
				'group' => 'x_staff',
				'field_type' => 'text',
				'label' => 'Direct Phone',
				'description' => ''
			));
			
			x_add_metadata_field('x_staff_mobile', 'staff', array(
				'group' => 'x_staff',
				'field_type' => 'text',
				'label' => 'Mobile Phone',
				'description' => ''
			));
			
			x_add_metadata_field('x_staff_email', 'staff', array(
				'group' => 'x_staff',
				'field_type' => 'text',
				'label' => 'Email',
				'description' => ''
			));
			
		x_add_metadata_group( 'x_staff_sub', 'type_staff_desc', array(
			'label' => 'Staff info'
		) );
		
			x_add_metadata_field('x_staff_subheading', 'staff', array(
				'group' => 'x_staff_sub',
				'field_type' => 'text',
				'label' => 'Subheading Text',
				'description' => ''
			));
			
			x_add_metadata_field('x_staff_description', 'staff', array(
				'group' => 'x_staff_sub',
				'field_type' => 'wysiwyg',
				'label' => 'Description Text',
				'description' => ''
			));
	}
}

function of_field_column_date_callback( $field_slug, $field, $object_type, $object_id, $value ) {
	if( ! empty( $value[0] ) )
		echo @date('M d, Y', $value[0]);
}


function of_field_column_thumb_callback( $field_slug, $field, $object_type, $object_id, $value ) {
	if( ! empty( $value[0] ) )
		printf( '<a href="%s" title="%s" target="_blank" rel="nofollow"><img src="%s" alt="%s" style="height: 48px; width: auto;" /></a>', $value[0], $field_slug, $value[0], $field_slug );
}

function of_field_column_link_callback( $field_slug, $field, $object_type, $object_id, $value ) {
	if( ! empty( $value[0] ) )
		printf( '<a href="%s" title="%s" target="_blank" rel="nofollow">%s</a>', $value[0], $field_slug, $value[0] );
}

function of_field_column_options_callback( $field_slug, $field, $object_type, $object_id, $value ) {
	$options_def = array(
		'yes' => 'Yes',
		'no' => 'No',
		'' => 'N/A',
	);
	if( $value[0] && isset( $options_def[$value[0]] ) )
		echo esc_html( $options_def[$value[0]] );
}

function of_field_column_user_callback( $field_slug, $field, $object_type, $object_id, $value ) {
	$user = get_userdata( intval( $value[0] ) );
	if( $user )
		echo $user->display_name . ' ( ' . $user->user_login . ' )';
}

