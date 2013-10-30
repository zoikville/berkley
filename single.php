<?php 
	get_header(); 

	global $wp_query;
	
	$currentCat = get_the_terms( get_the_ID() , 'office' );
	$keys = array_keys($currentCat);
	$keys = $keys[0];
	
	$currentCatName = $currentCat[$keys]->name;
	$currentCatId = $currentCat[$keys]->term_id;
?>



	<div class="main-content">
		<section class="clearfix sub-page page-staff">
			<header class="page-title">
				<h1><?php echo $currentCatName; ?> Staff</h1>
			</header>
			
			
			<article class="staff-content">
				<?php 
				if (have_posts()) : while (have_posts()) : the_post();
					$post_id = get_the_ID();
					$staff_title = get_post_meta($post_id, 'x_staff_job_title', true);
					$staff_direct = get_post_meta($post_id, 'x_staff_direct', true);
					$staff_mobile = get_post_meta($post_id, 'x_staff_mobile', true);
					$staff_email = get_post_meta($post_id, 'x_staff_email', true);
					
					$subheading = get_post_meta($post_id, 'x_staff_subheading', true);
					$description = get_post_meta($post_id, 'x_staff_description', true);

					$photo = get_post_meta($post_id, 'x_staff_photo', true);
					$photoId = get_attachment_id_from_src($photo);
					if( $photoId ) {
						$thumbnail = wp_get_attachment_image_src($photoId, 'staff-photo');
						$photoSrc = $thumbnail[0];
					} else {
						$photoSrc = $photo;
					};
				?>
				
				<header>
					<h1><?php the_title(); ?></h1>
					<ul>
						<li class="job"><?php echo $staff_title; ?></li>
						<li class="tel"><strong><a href="tel:<?php echo $staff_direct; ?>"><?php echo $staff_direct; ?></a></strong></li>
						<li class="mob"><a href="tel:<?php echo $staff_mobile; ?>"><?php echo $staff_mobile; ?></a></li>
						<li class="mail"><a href="mailto:<?php echo $staff_email; ?>"><?php echo $staff_email; ?></a></li>
					</ul>
					<div class="photo">
						<?php if ($photoSrc) { ?>
							<img src="<?php echo $photoSrc; ?>" />
						<?php }; ?>
					</div>
				</header>
				
				<h2 class="subheading"><?php echo $subheading; ?></h2>
				<div class="desc">
					<?php echo $description; ?>
				</div>

				<?php endwhile; else: ?>
					<p>Sorry, no posts matched your criteria.</p>
				<?php  endif; ?>
				<?php rewind_posts(); ?>
				
			</article>
			
			<section class="staff-list clearfix">
				<header class="page-title">
				</header>
				
				<?php
					

					$charityPosts = new WP_Query();
					$charityPosts -> query( array(
						'post_status' => 'publish',
						'post_type' => 'staff',
						'orderby' => 'menu_order',
						'order' => 'ASC',
						'post__not_in' => array($post_id),
						'tax_query' => array(
							array(
								'taxonomy' => 'office',
								'terms' => $currentCatId
							)
						),
						'showposts' => 999
						)
					);
					
					$i = 1;
					if($charityPosts->have_posts()) : while($charityPosts->have_posts()): $charityPosts->the_post(); 
					$postid = get_the_ID();
					$jobtitle = get_post_meta($postid, 'x_staff_job_title', true);
				?>
				
				<article class="post <?php if($i%2 == 1) echo "odd"; ?>">
					<a href="<?php echo get_permalink(); ?>">
						<h1><?php the_title(); ?></h1>
						<p><?php echo $jobtitle; ?></p>
						<strong>View Profile</strong>
					</a>
				</article>
				
				<?php $i++; endwhile; else: ?>
					<p><!-- No Staff --></p>
				<?php endif; ?>
				<?php rewind_posts(); ?>
			</section>
		</section>


	</div>
	<?php get_sidebar(); ?>
		
<?php get_footer(); ?>
