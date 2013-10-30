<?php get_header(); ?>
		<?php 
			
				global $wp_query;
				$currentCat = $wp_query->query_vars['category'];
				$obj2 = get_category_by_slug($currentCat);
				$obj = $wp_query->queried_object;//->category_parent;
				$parentCat = $obj->category_parent;
				
				$currentCatiD = $obj2->term_id;
				
				
				if ($parentCat) {
					$catNames = get_cat_name($parentCat) .' / '. $obj2->cat_name;
				} else {
					$catNames = $obj2->cat_name;
				}
				
				//print_r($parentCat);
			
		?> 





		<?php include ( get_stylesheet_directory() . '/include/cat.php' ); ?>
		
		<div class="main-content">
					
			
			<?php
			
			$isFirst = $_GET['page'];
			//print_r($isFirst);exit;
			
			
			if ( $isFirst == 'first' ) { 
			?>
			<div class="left-content">
				<section class="clearfix module mod-deals-list">
					<header>
						<h1><?php echo $catNames; ?> RECENT BOGO DEALS</h1>
					</header>
					
					<div class="list clearfix">
					<?php
					/*

						$dealsList = new WP_Query();
						$dealsList -> query( array(
							'post_type' => 'deals',
							'showposts' => 1,
							'cat' => $currentCatiD,
							'order' => 'DESC', 
							'orderby' => 'date')
						);
						
						if($dealsList->have_posts()) : while($dealsList->have_posts()): $dealsList->the_post(); 
						$post_id = get_the_ID();
						
					*/
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 0;
						$args = array( 
									'post_status' => 'publish',
									'post_type' => 'deals',
									'paged' => $paged,
									'cat' => $currentCatiD,
									'posts_per_page' => get_option('posts_per_page'), 
									'ignore_sticky_posts'=> 1
								);

						query_posts($args);
						if ( have_posts() ) : while ( have_posts() ) : the_post();
					?>
					
					<article class="post clearfix">
						<div>
							<a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail($post_id, 'in-post-2'); ?></a>
						</div>
						<h1><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h1>
					</article>
					
					<?php endwhile; else: ?>
						<p>No Posts</p>
					<?php endif; ?>
					</div>
					<?php of_pagenavi(3); ?>
					<?php rewind_posts(); ?>
					
				</section>
			</div>
			
			
			

			
			
			<?php }else{ ?>
		
			<?php include ( get_stylesheet_directory() . '/include/featured.php' ); ?>
			
			<section class="clearfix module mod-deals">
				<header>
					<h1><?php echo $catNames; ?> RECENT BOGO DEALS</h1>
				</header>
				
				<div class="list clearfix">
				<?php

					$charityPosts = new WP_Query();
					$charityPosts -> query( array(
						'post_type' => 'deals',
						'showposts' => 6,
						'cat' => $currentCatiD,
						'order' => 'DESC', 
						'orderby' => 'date')
					);
					
					if($charityPosts->have_posts()) : while($charityPosts->have_posts()): $charityPosts->the_post(); 
					$post_id = get_the_ID();

				?>
				
				<article class="post clearfix">
					<div>
						<a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail($post_id, 'thumbnail'); ?></a>
					</div>
					<div>
						<p>Category: <?php the_category(', ') ?></p>
						<h1><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h1>
					</div>
				</article>
				
				<?php endwhile; else: ?>
					<p>No Posts</p>
				<?php endif; ?>
				</div>
				<?php if( $charityPosts->have_posts() ) { ?>
					<a class="more" href="?page=first">View all <?php echo $catNames; ?> deals</a>
				<?php }; ?>
				<?php rewind_posts(); ?>
				
			</section>
			
			<section class="clearfix module mod-charity">
				<header>
					<h1>BOGO CHARITY</h1>
				</header>
				
				<div class="list">
				<?php

					$charityPosts = new WP_Query();
					$charityPosts -> query( array(
						'post_type' => 'charity',
						'showposts' => 1, 
						'order' => 'DESC', 
						'orderby' => 'date')
					);
					
					if($charityPosts->have_posts()) : while($charityPosts->have_posts()): $charityPosts->the_post(); 
					$post_id = get_the_ID();

				?>
				
				<article class="post clearfix">
					<div class="left">
						<a href="<?php echo get_permalink(); ?>"><?php echo get_the_post_thumbnail($post_id, 'thumbnail'); ?></a>
					</div>
					<div class="right">
						<h1><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h1>
						<time><?php the_date(); ?></time>
						<p>
						<?php my_content(get_the_content(), 350); ?>
						<span class="more"><a href="<?php echo get_permalink(); ?>">Read More ></a></span>
						</p>
						
					</div>
				</article>
				
				<?php endwhile; else: ?>
					<p>No Posts</p>
				<?php endif; ?>
				
					
				
				</div>
				<?php rewind_posts(); ?>
				
			</section>
			
			<?php }; ?>

		</div>






<?php get_footer(); ?>