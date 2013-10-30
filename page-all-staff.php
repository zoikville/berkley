<?php
/*
	Template Name: All Staff
*/
?>
<?php 
	get_header(); 

	$terms = get_terms("office", "hide_empty=0");
?>



	<div class="main-content">
		<section class="clearfix sub-page page-staff">

			<?php

				if(!empty($terms))
				{
					foreach ($terms as $key => $term) 
					{
						$args = array( 
							'post_status' => 'publish',
							'post_type' => 'staff',
							'orderby' => 'menu_order',
							'order' => 'ASC',
							'tax_query' => array(
								array(
									'taxonomy' => 'office',
									'terms' => $term->term_id
								)
							),
							'posts_per_page' => 999,
							'ignore_sticky_posts'=> 1
						);

						echo '<header class="page-title">
								<h1>'.$term->name.'</h1>
							</header>';

						echo '<section class="staff-list clearfix" style="margin-bottom: 15px;">';

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

						<?php

						echo '</section>';
					}
				}
			?>
			
		</section>


	</div>
	<?php get_sidebar(); ?>
		
<?php get_footer(); ?>
