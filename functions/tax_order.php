<?php

// Add Options to DB
function add_tax_order_options(){
	$options = 
	array
	(
	    'autosort' => '1',
	    'adminsort' => '1',
	    'level' => 0  // user level
	);

	update_option('tto_options', $options);
}
add_action( 'after_setup_theme', 'add_tax_order_options' ); 

require("tax-terms-order/taxonomy-terms-order.php");

?>