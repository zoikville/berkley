			<section class="clearfix module featured-deals">
				<header>
					<?php if(is_category()){ ?>
						<h1>[<?php echo $catNames; ?>] BOGO DEALS</h1>
					<?php }else{ ?>
						<h1>TODAY’S BOGO DEALS</h1>
					<?php }; ?>
				</header>
				
				<div class="featured">
				<div id="featured-deals">
				<?php
					$totalNumberOfDay = date('Y-m-d', time());
					$totalNumberOfSeconds = strtotime($totalNumberOfDay) - 86399;

					$featuredPosts = new WP_Query();
					$featuredPosts -> query( array(
						'post_type' => 'deals',
						'showposts' => 20, 
						'meta_key' => 'x_space_featured', 
						'meta_value' => 1, 
						'meta_query' => array(
							array(
								'key' => 'x_expires_date',
								'value' => $totalNumberOfSeconds,
								'compare' => '>',
							)
						),
						'order' => 'DESC', 
						'orderby' => 'date')
					);
					
					$cunt;
					
					if($featuredPosts->have_posts()) : while($featuredPosts->have_posts()): $featuredPosts->the_post(); 
					$post_id = get_the_ID();
					
					$dealDate = get_post_meta($post_id, 'x_deal_date', true);
					$expiresDate = get_post_meta($post_id, 'x_expires_date', true);
					//$vendor = get_post_meta($post_id, 'x_vendor', true);
					//$vendorLink = get_post_meta($post_id, 'x_vendor_link', true);
					
					
					$featuredImageSrc = get_post_meta($post_id, 'x_space_featured_image', true);
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
					<div class="left">
						<h1><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h1>
						<ul>
							<li>Deal Date: <?php echo @date('M d, Y', $dealDate); ?></li>
							<li>Expires: <?php echo @date('M d, Y', $expiresDate); ?></li>
							<li><?php echo get_the_term_list( $post_id, 'categorys', 'Category: ', ', ', '' ); ?></li>
							<li><?php echo get_the_term_list( $post_id, 'vendor', 'Vendor: ', ', ', '' ); ?></li>
						</ul>
						<p><?php my_content(get_the_content(), 100); ?></p>
						<span class="more"><a href="<?php echo get_permalink(); ?>">View Details</a></span>
					</div>
					<div class="right">
						<a href="<?php echo get_permalink(); ?>"><img height="275" width="470" src="<?php echo $featuredImage; ?>" /></a>
					</div>
				</article>
				
				<?php endwhile; else: ?>
					<p>No Posts</p>
				<?php endif; ?>
				</div>
				</div>
				<div class="featured-navi">
					<div class="box">
						<ul class="clearfix" id="featured-navi">
				
						<?php
							
							$cunt2;
						
							if($featuredPosts->have_posts()) : while($featuredPosts->have_posts()): $featuredPosts->the_post();  
							$post_id = get_the_ID();
							$featuredImageSrc = get_post_meta($post_id, 'x_space_featured_image', true);
							
							$featuredImageId = get_attachment_id_from_src($featuredImageSrc);
							if( $featuredImageId ) {
								$featuredT = wp_get_attachment_image_src($featuredImageId, 'featured-thum');
								$featuredThumbnai = $featuredT[0];
							} else {
								$featuredT = wp_get_attachment_image_src(get_post_thumbnail_id($post_id), 'featured-thum');
								$featuredThumbnai = $featuredT[0];
							};
							
							$cunt2 ++;
						?>

							<li id="featured-navi-<?php echo $cunt2; ?>" data-index="<?php echo $cunt2; ?>">
								<img src="<?php echo $featuredThumbnai; ?>" alt="image" />
								<h2><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h2>
							</li>

						<?php endwhile; else: ?>
							<p>No Posts</p>
						<?php endif; ?>
						</ul>
					</div>
					<b class="but but-next" id="featured-next">next</b>
					<b class="but but-prev" id="featured-prev">prev</b>
					<nav id="navi-log"><span>1 - 5</span> of <?php echo $cunt2; ?></nav>
				</div>
				<?php rewind_posts(); ?>

			</section>