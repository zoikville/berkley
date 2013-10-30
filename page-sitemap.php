<?php get_header(); ?>
	<div class="main-content">

		<section class="clearfix sub-page">
			
			<header class="page-title">
				<h1><?php the_title(); ?></h1>
			</header>

			<div class="sitemap-col">

				
				<nav class="sitemap-item">
					<?php wp_nav_menu( array( 'menu' => 'Sitemap', 'container' => '') ); ?>
				</nav>


			</div>

		</section>

	</div>
	<?php get_sidebar(); ?>

<?php get_footer(); ?>

