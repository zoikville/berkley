<?php

function custom_wp_trim_excerpt( $text ) {

	$raw_excerpt = $text;
	if ( '' == $text ) {
		$text = get_the_content('');

		$text = strip_shortcodes( $text );

		$text = apply_filters('the_content', $text);
		$text = str_replace(']]>', ']]&gt;', $text);

		/***Add the allowed HTML tags separated by a comma.***/
		$allowed_tags = '<p>,<a>,<em>,<strong>,<div>,<h1>,<h2>,<h3>,<h4>,<h5>,<h6>,<hr>,<img>,<span>,<ul>';
		$text = strip_tags($text, $allowed_tags);

		/***Change the excerpt word count.***/
		$excerpt_word_count = 80;
		$excerpt_length = apply_filters('excerpt_length', $excerpt_word_count);

		/*** Change the excerpt ending.***/
		//$excerpt_end = ' <a href="'. get_permalink($post->ID) . '">' . '&raquo; Continue Reading.' . '</a>';
		$excerpt_end = '';
		$excerpt_more = apply_filters('excerpt_more', ' ' . $excerpt_end);

		$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
		if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $excerpt_more;
		} else {
			$text = implode(' ', $words);
		}
	}
	return apply_filters('wp_trim_excerpt', $text, $raw_excerpt);

}
remove_filter('get_the_excerpt', 'wp_trim_excerpt');
add_filter('get_the_excerpt', 'custom_wp_trim_excerpt');


// many different excerpt sizes or want to show an exerpt outside the loop
function my_excerpt( $excerpt_length = 55, $id = false, $echo = true ) {

	$text = '';

	if($id) {
		$the_post = & get_post( $my_id = $id );
		$text = ($the_post->post_excerpt) ? $the_post->post_excerpt : $the_post->post_content;
	} else {
		global $post;
		$text = ($post->post_excerpt) ? $post->post_excerpt : get_the_content('');
	}

	$text = strip_shortcodes( $text );
	$text = apply_filters('the_content', $text);
	$text = str_replace(']]>', ']]&gt;', $text);
	$allowed_tags = '';
	$text = strip_tags($text, $allowed_tags);

	$excerpt_more = ' ...';
	$words = preg_split("/[\n\r\t ]+/", $text, $excerpt_length + 1, PREG_SPLIT_NO_EMPTY);
	if ( count($words) > $excerpt_length ) {
			array_pop($words);
			$text = implode(' ', $words);
			$text = $text . $excerpt_more;
	} else {
			$text = implode(' ', $words);
	}
	if($echo)
			echo apply_filters('the_content', $text);
	else
		return $text;

}

