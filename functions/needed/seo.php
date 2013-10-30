<?php

$global_title        = options('of_global_title', false) ? options('of_global_title', false) : get_bloginfo('name');
$global_title_suffix = options('of_title_suffix', false);
$global_desc         = options('of_global_dec', false);
$global_keywords     = options('of_global_keywords', false);
$suffix              = $global_title_suffix ? $global_title_suffix : $global_title;


if (is_home()||is_front_page()) {
    $title       = $global_title;
    $description = $global_desc;
    $keywords    = $global_keywords;
}
elseif (is_single()  || is_page()) {
    $title       = get_post_meta($post->ID, "seo_title", true);
    $title       = ( $title ? $title : single_post_title('', false).' - '.$suffix );
    $description = get_post_meta($post->ID, "seo_desc", true);
    $keywords    = get_post_meta($post->ID, "seo_keywords", true);
}
elseif (is_category()) {
    $title       = single_cat_title('', false).' - '.$suffix;
    $description = category_description();
    $keywords    = $global_keywords;
}
elseif (is_tag()){
    $title       = single_tag_title('', false).' - '.$suffix;
    $description = tag_description();
    $keywords    = $global_keywords;
}
elseif (is_tax()){
    $title       = get_queried_object()->name.' - '.$suffix;
    $description = get_queried_object()->description;
    $keywords    = $global_keywords;
}
elseif (is_search()){
    $title       = 'Search Results: '.wp_specialchars($s).' - '.$suffix;
    $description = $global_desc;
    $keywords    = $global_keywords;
}
elseif (is_date()){
    $title       = 'Archive'.' - '.$suffix;
    $description = $global_desc;
    $keywords    = $global_keywords;
}
else{
    $title       = $global_title;
    $description = $global_desc;
    $keywords    = $global_keywords;
}

$description = $description ? $description : $global_desc;
$keywords    = $keywords ? $keywords : $global_keywords;

$description = trim($description);
$keywords = trim($keywords);

$of_is_seo = get_option( 'of_is_seo' );

// Enabled enhanced SEO
if( '' == $of_is_seo || 'true' == $of_is_seo ) : ?>
<title><?php echo of_qtrans_use( $title ); ?></title>
<meta name="description" content="<?php echo of_qtrans_use( $description ); ?>" />
<meta name="keywords" content="<?php echo of_qtrans_use( $keywords ); ?>" />
<?php 
// Original HTML Title output
else :
function of_wp_title_filter( $title ) {
    global $page, $paged;
    if ( is_feed() ) return $title;
    if ( $paged >= 2 || $page >= 2 ) $title .= sprintf( __( 'Page %s' ), max( $paged, $page ) ) . ' &laquo; ';
    $title .= get_bloginfo( 'name' );
    $site_description = get_bloginfo( 'description', 'display' );
    if ( $site_description && ( is_home() || is_front_page() ) ) $title .= ' &#124; ' . $site_description;
    return $title;
}
add_filter( 'wp_title', 'of_wp_title_filter' );
?>
<title><?php wp_title( '&laquo;', true, 'right' ); ?></title>
<?php endif; ?>
