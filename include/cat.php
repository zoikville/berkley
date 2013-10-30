		<nav class="category-menus">
			<h1>BOGO Deals from A to Z</h1>
			<ul>
			<?php 
			$args = array(
				'show_option_all'    => '',
				'orderby'            => 'name',
				'order'              => 'ASC',
				'style'              => 'list',
				'show_count'         => 0,
				'hide_empty'         => 0,
				'use_desc_for_title' => 0,
				'child_of'           => 0,
				'feed'               => '',
				'feed_type'          => '',
				'feed_image'         => '',
				'exclude'            => '',
				'exclude_tree'       => '',
				'include'            => '',
				'hierarchical'       => 1,
				'title_li'           => __( '' ),
				'show_option_none'   => __('No categories'),
				'number'             => null,
				'echo'               => 1,
				'depth'              => 0,
				'current_category'   => 0,
				'pad_counts'         => 0,
				'taxonomy'           => 'categorys',
				'walker'             => null
			);
			wp_list_categories($args);
			?>
			</ul>
		</nav>