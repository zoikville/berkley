<?php
/*
	Template Name: Insurance
*/
?>
<?php get_header(); ?>
	<div class="main-content">

		<section class="clearfix sub-page">
			
			<header class="page-title">
				<h1>INSURANCE INSIDER</h1>
			</header>

			<div class="sub-news-list">
					
				<?php
				
				$rss = simplexml_load_file('http://www.insuranceinsider.com/news/rss/35');
				$news_page = $_GET['news-page'];
				
				$news = $rss->channel->item;
				// count($news)

				for ($i = 0 ; $i <= 9; $i++) {

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
				}?>
				
				
			</div>
			


			
		</section>

	</div>
	<?php get_sidebar(); ?>

<?php get_footer(); ?>