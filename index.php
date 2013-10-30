<?php get_header(); ?>

		<section class="clearfix featured">

			<div class="list">
				<div id="featured">
				<?php

					$featuredPosts = new WP_Query();
					$featuredPosts -> query( array(
						'post_type' => 'slider',
						'showposts' => 999, 
						'order' => 'ASC', /*DESC*/
						'ignore_sticky_posts'=> 1,
						'orderby' => 'date')
					);
					
					$cunt;
					
					if($featuredPosts->have_posts()) : while($featuredPosts->have_posts()): $featuredPosts->the_post(); 
					$post_id = get_the_ID();
					
					$subHeading = get_post_meta($post_id, 'x_slider_sub_title', true);
					$description = get_post_meta($post_id, 'x_slider_description', true);
					$linkText = get_post_meta($post_id, 'x_slider_link_text', true);
					$linkUrl = get_post_meta($post_id, 'x_slider_link', true);

					$featuredImageSrc = get_post_meta($post_id, 'x_slider_image', true);
					$featuredImageId = get_attachment_id_from_src($featuredImageSrc);
					if( $featuredImageId ) {
						$thumbnail = wp_get_attachment_image_src($featuredImageId, 'featured');
						$featuredImage = $thumbnail[0];
					} else {
						$featuredImage = $featuredImageSrc;
					};
					
					$cunt ++;

				?>
				
				<article class="clearfix" id="featured-post-<?php echo $cunt; ?>" data-index="<?php echo $cunt; ?>">
					<div class="box">
						<h1><?php the_title(); ?></h1>
						<h2><?php echo $subHeading; ?></h2>
						<p><?php echo $description; ?></p>
						<strong class="more"><a href="<?php echo $linkUrl; ?>"><?php echo $linkText; ?></a></strong>
					</div>
					<img src="<?php echo $featuredImage; ?>" />
				</article>
				
				<?php endwhile; else: ?>
					<p>No Posts</p>
				<?php endif; ?>
				</div>
			</div>
			<div id="featured-navi" class="navi"></div>

		</section>
			
			
		<div class="clearfix main-content">

			<section class="clearfix module mod-about">
				<article class="post clearfix">
					<?php options('of_about'); ?>
				</article>
			</section>

			<section class="clearfix module mod-products">
				<header>
					<h1>Our Products</h1>
				</header>
				<article class="post clearfix">
					<h2><?php options('of_products_subheading'); ?></h2>
					<div class="text"><?php options('of_products_desc'); ?></div>
					<strong class="more"><a href="/our-products/">more</a></strong>
				</article>
			</section>

			<div class="clearfix news-box">
				

				<section class="clearfix module mod-news">
					<header>
						<h1>Our News</h1>
					</header>
					<?php
					$charityPosts = new WP_Query();
					$charityPosts -> query( array(
							'post_status' => 'publish',
							'post_type' => 'news',
							'posts_per_page' => 1, 
							'ignore_sticky_posts'=> 1
					));
					
					if($charityPosts->have_posts()) : while($charityPosts->have_posts()): $charityPosts->the_post(); 
					$post_id = get_the_ID();
					?>
					
					<article class="post clearfix">
						<header>
							<h1><?php my_content(get_the_title(), 28); ?></h1>
							<time><?php the_date('M d, Y'); ?></time>
						</header>
						<div class="text"><?php my_content(get_the_content(), 160); ?></div>
						<strong class="more"><a href="<?php echo get_permalink(); ?>">more</a></strong>
					</article>
					
					<?php endwhile; else: ?>
						<article class="post clearfix">
							<h1>No New Post</h1>
						</article>
					<?php endif; ?>
					<?php rewind_posts();  wp_reset_postdata(); ?>
					
					

				</section>

				<?php
				$rss = simplexml_load_file('http://www.insuranceinsider.com/news/rss/35');
				foreach($rss->channel->item as $key => $item){ 
					$new_title = $item->title;
					$new_date = $item->pubDate;
					$new_desc = $item->description;
					$new_link = $item->link;
					break;
				}
				$new_date = strtotime($new_date);
				
				?> 
				<section class="clearfix module mod-insider">
					<header>
						<h1>Insurance Insider</h1>
					</header>
					<article class="post clearfix">
						<header>
							<h1><?php my_content($new_title, 28); ?></h1>
							<time><?php echo @date('d M Y', $new_date); ?></time>
						</header>
						<div class="text"><?php my_content($new_desc, 120); ?></div>
						<strong class="more"><a href="<?php bloginfo('url'); ?>/insurance">more</a></strong>
					</article>
				</section>
				
			</div>

		</div>
		<?php get_sidebar(); ?>


<?php get_footer(); ?>

