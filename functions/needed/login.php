<?php 

// Custom Login Page Style
function custom_login() {
 echo '<link rel="stylesheet" type="text/css" href="' . get_bloginfo('template_directory') . '/functions/needed/login/login.css" />';
}
add_action('login_head', 'custom_login');

// Change Login Logo URL
function change_wp_login_url() {
	return get_bloginfo('url');
}
add_filter('login_headerurl', 'change_wp_login_url');

// Change Login Logo Title
function change_wp_login_title() {
	return 'Powered by ' . get_option('blogname');
}
add_filter('login_headertitle', 'change_wp_login_title');

// Redirect to options panel page after login
function my_login_redirect($redirect_to, $request) {
	return home_url().'/wp-admin/admin.php?page=optionsframework';
}
// add_filter("login_redirect", "my_login_redirect", 10, 3);


// Redirect front end failed login to current page
//add_action( 'wp_login_failed', 'my_front_end_login_fail' ); // hook failed login
function my_front_end_login_fail( $username ) {
	$referrer = $_SERVER['HTTP_REFERER']; // where did the post submission come from?
	// if there's a valid referrer, and it's not the default log-in screen
	if ( !empty($referrer) && !strstr($referrer,'wp-login') && !strstr($referrer,'wp-admin') ) {
		wp_redirect( $referrer . '?login=failed' ); // let's append some information (login=failed) to the URL for the theme to use
		exit;
	}
}

// Preventing admin panel access for logged in users except administrator
//add_action('init', 'prevent_admin_access', 0);
function prevent_admin_access() {
    if (strpos(strtolower($_SERVER['REQUEST_URI']), '/wp-admin') !== false && !current_user_can('Administrator')) {
        wp_redirect(get_option('siteurl'));
    }
}



?>