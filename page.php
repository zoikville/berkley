<?php get_header(); ?>
	<div class="main-content">

		<article class="clearfix sub-page">
			<?php 
			if (have_posts()) : while (have_posts()) : the_post(); ?>
			
			<header class="page-title">
				<h1><?php the_title(); ?></h1>
			</header>

			<div class="page-col">
				<?php the_content(); ?>
			</div>

			<?php endwhile; else: ?>
				<p>Sorry, no posts matched your criteria.</p>
			<?php  endif; ?>
			<?php rewind_posts(); ?>
			
		</article>

	</div>
	<?php get_sidebar(); ?>

<?php get_footer(); ?>
