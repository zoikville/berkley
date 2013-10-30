<?php 
	get_header(); 

	global $wp_query;

	$currentCatName = $wp_query->queried_object->name;
	$currentCatId = $wp_query->queried_object->term_id;
?>



	<div class="main-content">
		<section class="clearfix sub-page page-staff">
			<header class="page-title">
				<h1><?php echo $currentCatName; ?> Staff</h1>
			</header>
			<section class="staff-list clearfix">

				
				<?php
					$args = array( 
						'post_status' => 'publish',
						'post_type' => 'staff',
						'orderby' => 'menu_order',
						'order' => 'ASC',
						'tax_query' => array(
							array(
								'taxonomy' => 'office',
								'terms' => $currentCatId
							)
						),
						'posts_per_page' => 999,
						'ignore_sticky_posts'=> 1
					);

					$i = 1;
					query_posts($args);	
					if ( have_posts() ) : while ( have_posts() ) : the_post();
					
					$post_id = get_the_ID();
					$jobtitle = get_post_meta($post_id, 'x_staff_job_title', true);
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
