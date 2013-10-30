<?php 
	get_header();
?> 
	<div class="main-content">

		<section class="clearfix sub-page">
			
			<header class="page-title">
				<h1>Search results</h1>
			</header>

					
			<div class="search-list clearfix">
			<?php
				if ( have_posts() ) : while ( have_posts() ) : the_post();
				
				$title = get_the_title();
				$content = get_the_content();
				$keys= explode(" ",$s);
				$title = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-highlight">\0</strong>', $title);
				$content = preg_replace('/('.implode('|', $keys) .')/iu', '<strong class="search-highlight">\0</strong>', $content);
				
			?>
			
			<article class="post clearfix">
				<h1><a href="<?php echo get_permalink(); ?>"><?php echo $title; ?></a></h1>
				<div class="content"><?php echo $content; ?></div>
			</article>
			
			<?php endwhile; else: ?>
				<p>No Posts</p>
			<?php endif; ?>
			
			</div>
			<?php of_pagenavi(3); ?>
			<?php rewind_posts(); ?>

		</section>

	</div>
	<?php get_sidebar(); ?>

<?php get_footer(); ?>