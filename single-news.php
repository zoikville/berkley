<?php get_header(); ?>
	<div class="main-content">
		<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
		<article class="clearfix sub-page">
			<header class="page-title" style="height:auto">
				<time class="newtime"><?php the_date('M d, Y'); ?></time>
				<h1><?php the_title(); ?></h1>
				
			</header>
			<div class="page-col">
				<?php the_content(); ?>
			</div>
		</article>
		<?php endwhile; else: ?>
			<article class="clearfix sub-page"><h1>Sorry, no posts matched your criteria.</h1></article>
		<?php  endif; ?>
		<?php rewind_posts(); ?>
	</div>
	<?php get_sidebar(); ?>
<?php get_footer(); ?>