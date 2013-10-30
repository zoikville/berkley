<?php

// Register Navigation Menus
$menus = array(
	'main-menu' =>'Main Menu',
	'sitemap' => 'Sitemap',
);

// Translate Menus (qTranslate Plugin)
if(function_exists('qtrans_getAvailableLanguages')) {
	$availableLanguages = qtrans_getAvailableLanguages('enabled_languages');
	if(is_array($menus)) {
		foreach( $menus as $_key => $_val ) {
			$t_key = $_key;
			$t_val = $_val;
			foreach( $availableLanguages as $lang_key ) {
				$_val = $t_val." (".$lang_key.")";
				$_key = $t_key."-".$lang_key;
				$new_menus[$_key] = $_val;
			}
		}
	}
	register_nav_menus($new_menus);
} else {
	register_nav_menus($menus);
}

// Translate Menus (qTranslate Plugin)
if(function_exists('qtrans_getAvailableLanguages')) {
	function of_menu($theme_location, $class, $id, $depth) {
		$selectedLanguage = qtrans_getLanguage();
		wp_nav_menu(array('container' => '', 'theme_location' => $theme_location."-".$selectedLanguage, 'menu_class' => $class, 'menu_id' => $id, 'depth' => $depth));
	}
} else {
	function of_menu($theme_location, $class, $id, $depth) {
		wp_nav_menu(array('container' => '', 'theme_location' => $theme_location, 'menu_class' => $class, 'menu_id' => $id, 'depth' => $depth));
	}
}

