<!DOCTYPE html>
<!--[if lt IE 7 ]><html dir="ltr" lang="en" class="no-js ie ie6 lte7 lte8 lte9"><![endif]-->
<!--[if IE 7 ]>   <html dir="ltr" lang="en" class="no-js ie ie7 lte7 lte8 lte9"><![endif]-->
<!--[if IE 8 ]>   <html dir="ltr" lang="en" class="no-js ie ie8 lte8 lte9"><![endif]-->
<!--[if IE 9 ]>   <html dir="ltr" lang="en" class="no-js ie ie9 lte9"><![endif]-->
<!--[if (gt IE 9)|!(IE)]><!-->
<html lang="en"><!--<![endif]--><head>
<meta http-equiv="Content-Type" content="<?php bloginfo( 'html_type' ); ?>; charset=<?php bloginfo( 'charset' ); ?>" />
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="format-detection" content="telephone=no" />
	<meta name="viewport" content="width=device-width, minimum-scale=1.0, maximum-scale=1.0" />
	<?php include ( get_stylesheet_directory() . '/functions/needed/seo.php' ); ?>
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700,400italic' rel='stylesheet' type='text/css'>
	<?php wp_head(); ?>
	<!--[if IE 8 ]> 
		<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
	<![endif]-->
</head>
<body <?php body_class(); ?>>
	<div class="clearfix wrap">
		<header class="clearfix header">

			<h1 class="logo">
				<a href="<?php echo home_url(); ?>">
					<img class="d" alt="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>" src="<?php echo get_template_directory_uri(); ?>/images/logo.png">
					<img class="m" alt="<?php bloginfo('name'); ?> - <?php bloginfo('description'); ?>" src="<?php echo get_template_directory_uri(); ?>/images/logo-m.png">
				</a>
			</h1>
			
			<nav class="head-menu">
				<?php wp_nav_menu( array( 'menu' => 'Head Menu', 'container' => '') ); ?>
			</nav>
			
			<label class="search" for="s">
				<form method="get" id="searchform" name="deals" action="<?php echo home_url( '/' ); ?>">
					<input type="text" value="<?php //echo $_GET['s']; ?>" name="s" id="s" placeholder="" />
					<button type="submit" id="searchsubmit" value="<?php echo 'Search'; ?>" />SEARCH</button>
				</form>
			</label>
			
			<nav class="main-navi">
				<h1 class="mobile-menu">Navigation</h1>
				<?php wp_nav_menu( array( 'menu' => 'Main Navi', 'container' => '') ); ?>
			</nav>
		</header>
		<!-- //END HEADER -->
		
		<div class="clearfix container">