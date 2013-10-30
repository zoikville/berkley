<?php get_header(); ?>
	<div class="main-content">

		<section class="clearfix sub-page">
			
			<header class="page-title">
				<h1>NEWS</h1>
			</header>

			<div class="sub-news-list">
					<?php
						$paged = (get_query_var('paged')) ? get_query_var('paged') : 0;
					
						$args = array( 
							'post_status' => 'publish',
							'post_type' => 'news',
							'paged' => $paged,
							'posts_per_page' => 10, 
							'ignore_sticky_posts'=> 1
						);

						query_posts($args);
						if ( have_posts() ) : while ( have_posts() ) : the_post();
					?>
					<article class="post clearfix">
						<time><?php echo get_the_date('M d, Y'); ?></time>
						<h1><a href="<?php echo get_permalink(); ?>"><?php the_title(); ?></a></h1>
					</article>
					
					<?php endwhile; else: ?>
						<p>No Posts</p>
					<?php endif; ?>
					<?php of_pagenavi(2); ?>
					<?php rewind_posts(); ?>
					
					
					
					
				<?php
				/*
				$rss = simplexml_load_file('http://www.insuranceinsider.com/news/rss/35');
				$news_page = $_GET['news-page'];
				
				if ($news_page == '2') {
					$pageCount = 9;
				} else {
					$pageCount = 0;
				}
				
				$news = $rss->channel->item;
				// count($news)

				for ($i = $pageCount ; $i <= ($pageCount + 10); $i++) {

					$new_title = $news[$i]->title;
					$new_date = $news[$i]->pubDate;
					$new_link = $news[$i]->link;
					$new_date = strtotime($new_date);
					
					?>
					<article class="post clearfix">
						<time><?php echo @date('M d, Y', $new_date); ?></time>
						<h1><a href="<?php echo $new_link; ?>"><?php echo $new_title; ?></a></h1>
					</article>
					<?php
				}
				
				<nav class="pagenavi">
					<a class="prev" href="/news-archive/"></a>
					<a class="page <?php if ($news_page == '') echo 'current'; ?>" href="/news-archive/">1</a>
					<a class="page <?php if ($news_page == '2') echo 'current'; ?>" href="/news-archive/?news-page=2">2</a>
					<a class="next" href="/news-archive/?news-page=2"></a>
				</nav>
				*/
				
				?>
			</div>
			


			
		</section>

	</div>
	<?php get_sidebar(); ?>

<?php get_footer(); ?>