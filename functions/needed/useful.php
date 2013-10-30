<?php

// Automatically integrate multi-languages text (qTranslate)
function of_qtrans_use( $content ) {
    if( function_exists( 'qtrans_getLanguage' ) ) {
        $lang = qtrans_getLanguage();
        return qtrans_use( $lang, $content );
    } else {
        return $content;
    }
}

// Hide real email address to avoid spam
function hide_mailto($mail, $label, $subject = "", $body = "") {
    $chars = preg_split("//", $mail, -1, PREG_SPLIT_NO_EMPTY);
    $new_mail = "<a href=\"mailto:";
    foreach ($chars as $val) {
        $new_mail .= "&#".ord($val).";";
    }
    $new_mail .= ($subject != "" && $body != "") ? "?subject=".$subject."&body=".$body : "";
    $new_mail .= "\">".$label."";
    return $new_mail;
}

// Exclude Pages from Search Results
function excludePages($query) {
	if ($query->is_search) {
		$query->set('post_type', array('post', 'custom-post-type'));
	}
		return $query;
}
//if (!is_admin())
//add_filter('pre_get_posts','excludePages');

// Get Page ID by Name (slug)
function get_ID_by_page_slug($page_slug) {
    $page = get_page_by_path($page_slug);
    if ($page) {
        return $page->ID;
    } else {
        return null;
    }
}

// Get Post ID by Slug
function get_post_id_by_slug( $slug, $post_type ) {
    $query = new WP_Query(
        array(
            'name' => $slug,
            'post_type' => $post_type
        )
    );

    $query->the_post();

    return get_the_ID();
}


// getting all values for a custom field key (cross-post)
function get_meta_values( $key = '', $type = 'post', $status = 'publish' ) {
    global $wpdb;
    if( empty( $key ) )
        return;
    $r = $wpdb->get_col( $wpdb->prepare( "
        SELECT DISTINCT pm.meta_value FROM {$wpdb->postmeta} pm
        LEFT JOIN {$wpdb->posts} p ON p.ID = pm.post_id
        WHERE pm.meta_key = '%s' 
        AND p.post_status = '%s' 
        AND p.post_type = '%s'
    ", $key, $status, $type ) );
    return $r;
}

/* Post URLs to IDs function, supports custom post types - borrowed and modified from url_to_postid() in wp-includes/rewrite.php */
function bwp_url_to_postid($url)
{
	global $wp_rewrite;
 
	$url = apply_filters('url_to_postid', $url);
 
	// First, check to see if there is a 'p=N' or 'page_id=N' to match against
	if ( preg_match('#[?&](p|page_id|attachment_id)=(\d+)#', $url, $values) )   {
		$id = absint($values[2]);
		if ( $id )
			return $id;
	}
 
	// Check to see if we are using rewrite rules
	$rewrite = $wp_rewrite->wp_rewrite_rules();
 
	// Not using rewrite rules, and 'p=N' and 'page_id=N' methods failed, so we're out of options
	if ( empty($rewrite) )
		return 0;
 
	// Get rid of the #anchor
	$url_split = explode('#', $url);
	$url = $url_split[0];
 
	// Get rid of URL ?query=string
	$url_split = explode('?', $url);
	$url = $url_split[0];
 
	// Add 'www.' if it is absent and should be there
	if ( false !== strpos(home_url(), '://www.') && false === strpos($url, '://www.') )
		$url = str_replace('://', '://www.', $url);
 
	// Strip 'www.' if it is present and shouldn't be
	if ( false === strpos(home_url(), '://www.') )
		$url = str_replace('://www.', '://', $url);
 
	// Strip 'index.php/' if we're not using path info permalinks
	if ( !$wp_rewrite->using_index_permalinks() )
		$url = str_replace('index.php/', '', $url);
 
	if ( false !== strpos($url, home_url()) ) {
		// Chop off http://domain.com
		$url = str_replace(home_url(), '', $url);
	} else {
		// Chop off /path/to/blog
		$home_path = parse_url(home_url());
		$home_path = isset( $home_path['path'] ) ? $home_path['path'] : '' ;
		$url = str_replace($home_path, '', $url);
	}
 
	// Trim leading and lagging slashes
	$url = trim($url, '/');
 
	$request = $url;
	// Look for matches.
	$request_match = $request;
	foreach ( (array)$rewrite as $match => $query) {
		// If the requesting file is the anchor of the match, prepend it
		// to the path info.
		if ( !empty($url) && ($url != $request) && (strpos($match, $url) === 0) )
			$request_match = $url . '/' . $request;
 
		if ( preg_match("!^$match!", $request_match, $matches) ) {
			// Got a match.
			// Trim the query of everything up to the '?'.
			$query = preg_replace("!^.+\?!", '', $query);
 
			// Substitute the substring matches into the query.
			$query = addslashes(WP_MatchesMapRegex::apply($query, $matches));
 
			// Filter out non-public query vars
			global $wp;
			parse_str($query, $query_vars);
			$query = array();
			foreach ( (array) $query_vars as $key => $value ) {
				if ( in_array($key, $wp->public_query_vars) )
					$query[$key] = $value;
			}
 
		// Taken from class-wp.php
		foreach ( $GLOBALS['wp_post_types'] as $post_type => $t )
			if ( $t->query_var )
				$post_type_query_vars[$t->query_var] = $post_type;
 
		foreach ( $wp->public_query_vars as $wpvar ) {
			if ( isset( $wp->extra_query_vars[$wpvar] ) )
				$query[$wpvar] = $wp->extra_query_vars[$wpvar];
			elseif ( isset( $_POST[$wpvar] ) )
				$query[$wpvar] = $_POST[$wpvar];
			elseif ( isset( $_GET[$wpvar] ) )
				$query[$wpvar] = $_GET[$wpvar];
			elseif ( isset( $query_vars[$wpvar] ) )
				$query[$wpvar] = $query_vars[$wpvar];
 
			if ( !empty( $query[$wpvar] ) ) {
				if ( ! is_array( $query[$wpvar] ) ) {
					$query[$wpvar] = (string) $query[$wpvar];
				} else {
					foreach ( $query[$wpvar] as $vkey => $v ) {
						if ( !is_object( $v ) ) {
							$query[$wpvar][$vkey] = (string) $v;
						}
					}
				}
 
				if ( isset($post_type_query_vars[$wpvar] ) ) {
					$query['post_type'] = $post_type_query_vars[$wpvar];
					$query['name'] = $query[$wpvar];
				}
			}
		}
 
			// Do the query
			$query = new WP_Query($query);
			if ( !empty($query->posts) && $query->is_singular )
				return $query->post->ID;
			else
				return 0;
		}
	}
	return 0;
}

// Get attachment id from image src
function get_attachment_id_from_src ($image_src) {
    global $wpdb;
    
    // Remove image size, get the original image src
    $image_src = preg_replace('/-\d+x\d+(?=\.(jpg|jpeg|png|gif)$)/i', '', $image_src);
    
    $query = "SELECT ID FROM {$wpdb->posts} WHERE guid='$image_src'";
    $id = $wpdb->get_var($query);
    return $id;
}

// Get Popular Posts 
function popularPosts($num) {
    global $wpdb;
 
    $posts = $wpdb->get_results("SELECT comment_count, ID, post_title FROM $wpdb->posts ORDER BY comment_count DESC LIMIT 0 , $num");
 
    foreach ($posts as $post) {
        setup_postdata($post);
        $id = $post->ID;
        $title = $post->post_title;
        $count = $post->comment_count;
 
        if ($count != 0) {
            $popular .= '<li>';
            $popular .= '<a href="' . get_permalink($id) . '" title="' . $title . '">' . $title . '</a> ';
            $popular .= '</li>';
        }
    }
    return $popular;
}

// Instead of wp get_metadata(), this function will keep meta data array order. For functions/custom_metadata
function get_metadata_array_by_order($post_id, $meta_key){
	global $wpdb;
	$value_arr = $wpdb->get_results(  $wpdb->prepare(
		"
		SELECT meta_id, meta_value
		FROM $wpdb->postmeta
		WHERE post_id = %d
			AND meta_key = %s
		",
		$post_id, $meta_key
	), ARRAY_A);

	if(count($value_arr) > 1){
		$value_arr = sysSortArray($value_arr, 'meta_id');
	}

	$new_value = array();

	foreach ( $value_arr as $v ) 
	{
		$new_value[] = $v['meta_value'];
	}

	return $new_value;
}

// Get current URL
function curPageURL() {
    $isHTTPS = (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on");
    $port = (isset($_SERVER["SERVER_PORT"]) && ((!$isHTTPS && $_SERVER["SERVER_PORT"] != "80") || ($isHTTPS && $_SERVER["SERVER_PORT"] != "443")));
    $port = ($port) ? ':'.$_SERVER["SERVER_PORT"] : '';
    $url = ($isHTTPS ? 'https://' : 'http://').$_SERVER["SERVER_NAME"].$port.$_SERVER["REQUEST_URI"];
    return $url;
}

// Counting posts within categories
function get_post_count($categories) {
    global $wpdb;
    
    $post_count = 0;
    foreach($categories as $cat) :
        $querystr = "
            SELECT count
            FROM $wpdb->term_taxonomy
            WHERE term_id = $cat";
    $result = $wpdb->get_var($querystr);
    $post_count += $result;
    endforeach;
    
    return $post_count;
}

// change the number of posts shown in the WordPress admin area
//function dapl_query_string($query_string) {   
//    global $pagenow;   
//    if (is_admin() && $pagenow == 'edit.php') {
//        $query_string = str_replace('posts_per_page=15', 'posts_per_page=100', $query_string); 
//    }
//    return $query_string; 
//}  
//add_filter('query_string', 'dapl_query_string');

// Dump an array
function dump($vars, $label = '', $return = false) {
    if (ini_get('html_errors')) {
        $content = "<pre>\n";
        if ($label != '') {
            $content .= "<strong>{$label} :</strong>\n";
        }
        $content .= htmlspecialchars(print_r($vars, true));
        $content .= "\n</pre>\n";
    } else {
        $content = $label . " :\n" . print_r($vars, true);
    }
    if ($return) { return $content; }
    echo $content;
    return null;
}


/**
 * @package     BugFree
 * @version     $Id: FunctionsMain.inc.php,v 1.32 2005/09/24 11:38:37 wwccss Exp $
 *
 *
 * Sort an two-dimension array by some level two items use array_multisort() function.
 *
 * sysSortArray($Array,"Key1","SORT_ASC","SORT_RETULAR","Key2"……)
 * @author                      Chunsheng Wang <wwccss@263.net>
 * @param  array   $ArrayData   the array to sort.
 * @param  string  $KeyName1    the first item to sort by.
 * @param  string  $SortOrder1  the order to sort by("SORT_ASC"|"SORT_DESC")
 * @param  string  $SortType1   the sort type("SORT_REGULAR"|"SORT_NUMERIC"|"SORT_STRING")
 * @return array                sorted array.
 */
function sysSortArray($ArrayData,$KeyName1,$SortOrder1 = "SORT_ASC",$SortType1 = "SORT_REGULAR")
{
    if(!is_array($ArrayData))
    {
        return $ArrayData;
    }
 
    // Get args number.
    $ArgCount = func_num_args();
 
    // Get keys to sort by and put them to SortRule array.
    for($I = 1;$I < $ArgCount;$I ++)
    {
        $Arg = func_get_arg($I);
        if(!eregi("SORT",$Arg))
        {
            $KeyNameList[] = $Arg;
            $SortRule[]    = '$'.$Arg;
        }
        else
        {
            $SortRule[]    = $Arg;
        }
    }
 
    // Get the values according to the keys and put them to array.
    foreach($ArrayData AS $Key => $Info)
    {
        foreach($KeyNameList AS $KeyName)
        {
            ${$KeyName}[$Key] = $Info[$KeyName];
        }
    }
 
    // Create the eval string and eval it.
    $EvalString = 'array_multisort('.join(",",$SortRule).',$ArrayData);';
    eval ($EvalString);
    return $ArrayData;
}
 
//################# Example #################
//$arr = array(
//    array(
//        'name'      =>   'study',
//        'size'      =>   '1235',
//        'type'      =>   'jpe',
//        'time'      =>   '1921-11-13',
//        'class'     =>   'dd',
//    ),
//    array(
//        'name'      =>   'chinese',
//        'size'      =>   '153',
//        'type'      =>   'jpe',
//        'time'      =>   '2005-11-13',
//        'class'     =>   'jj',
//    ),
//    array(
//        'name'      =>   'program',
//        'size'      =>   '35',
//        'type'      =>   'gif',
//        'time'      =>   '1997-11-13',
//        'class'     =>   'dd',
//    ),
//    array(
//        'name'      =>   'chinese',
//        'size'      =>   '65',
//        'type'      =>   'jpe',
//        'time'      =>   '1925-02-13',
//        'class'     =>   'yy',
//    ),
//    array(
//        'name'      =>   'chinese',
//        'size'      =>   '5',
//        'type'      =>   'icon',
//        'time'      =>   '1967-12-13',
//        'class'     =>   'rr',
//    ),
//);
// 
//print_r($arr);
// 
//// Alerm：153 is less than 65
//$temp = sysSortArray($arr,"name","SORT_ASC");
// 
//print_r($temp);


?>