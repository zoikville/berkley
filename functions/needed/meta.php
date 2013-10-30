<?php

// Translate meta (qTranslate Plugin)
function of_meta($id, $key, $echo = true) {
	if(function_exists('qtrans_getAvailableLanguages')) {
		$selectedLanguage = qtrans_getLanguage();
		if($echo)
			echo get_post_meta($id, $key."_".$selectedLanguage, true);
		else
			return get_post_meta($id, $key."_".$selectedLanguage, true);
	}
	else {
		if($echo)
			echo get_post_meta($id, $key, true);
		else
			return get_post_meta($id, $key, true);
	}
}

