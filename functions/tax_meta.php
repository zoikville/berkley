<?php
/*
Plugin Name: Demo Tax meta class
Plugin URI: http://en.bainternet.info/2012/wordpress-taxonomies-extra-fields-the-easy-way
Description: Tax meta class usage demo
Version: 1.0
Author: Bainternet, Ohad Raz
Author URI: http://en.bainternet.info
*/

//include the main class file
require_once("tax-meta-class/tax-meta-class.php");
if (is_admin()){

	$prefix = '';
	/* 
	 * configure your meta box
	 */
	$config = array(
		'id' => 'office_meta_box', // meta box id, unique per meta box
		'title' => 'Office Meta Box', // meta box title
		'pages' => array('office'), // taxonomy name, accept categories, post_tag and custom taxonomies
		'context' => 'normal', // where the meta box appear: normal (default), advanced, side; optional
		'fields' => array(), // list of meta fields (can be added by field arrays)
		'local_images' => false, // Use local or hosted images (meta box images for add/remove)
		'use_with_theme' => true //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
	);
	
	
	$my_meta =  new Tax_Meta_Class($config);
	
	$my_meta->addText($prefix.'office_tel',array('name'=> 'Office TEL'));
	$my_meta->addText($prefix.'office_fax',array('name'=> 'Office FAX'));
	$my_meta->addTextarea($prefix.'office_address',array('name'=> 'Office Address'));
	$my_meta->addTextarea($prefix.'office_map',array('name'=> 'Google Map (Please enter iFrame)'));
	$my_meta->addTextarea($prefix.'office_map_link',array('name'=> 'Large Google Map Link'));
	$my_meta->Finish();
}