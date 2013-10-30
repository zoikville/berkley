<aside class="sidebar">

	<section class="clearfix module mod-contact">
		<header>
			<h1>Contact</h1>
		</header>
		<ul>
		<?php
			$offices = get_terms('office', 'hide_empty=0');
			foreach ($offices as $office) {

				$office_list .= '<li class="menu-'. $office->slug .'">';
				$office_list .= '<h2><a href="#'. $office->slug .'">'. $office->name .'</a></h2>';
				$office_list .= '<div class="meta-box">';
				$office_list .= '<div class="info"><p class="address">'. get_tax_meta($office->term_id,'office_address'). '</p>';
				$office_list .= '<p class="tel"><strong>Tel: '. get_tax_meta($office->term_id,'office_tel'). '</strong></p>';
				$office_list .= '<p class="fax">Fax: '. get_tax_meta($office->term_id,'office_fax'). '</p></div>';
				$office_list .= '<h3 class="button"><a href="'. home_url() .'/office/'. $office->slug .'/">See All '. $office->name .' Staff</a></h3>';
				$office_list .= stripslashes(get_tax_meta($office->term_id,'office_map'));
				$office_list .= '<h3 class="button"><a target="_blank" href="'. get_tax_meta($office->term_id,'office_map_link') .'/">Large Google Map</a></h3>';
				$office_list .= '</div></li>';
				
				// break;
			}
			echo $office_list;
		?> 
		</ul>
	</section>
	
	<section class="clearfix module mod-company">
		<a href="/w-r-berkley-corporation/">A Berkley Company</a>
	</section>
	
	<?php if (is_home()) { ?>
	<section class="clearfix module mod-stock">
		<header>
			<h1>Stock Price</h1>
		</header>
		<article>
			<header>
				<h1>NYSE: WRB</h1>
				<time id="LastTradeDate"><?php //echo @date('d M Y h:i A'); ?></time>
			</header>
			<div id="PrevClose" class="left"></div>
			<div id="DaysRange" class="right"><!-- 0.64 -1.53% --></div>
			<div id="StockRange" class="icon"></div>
		</article>
	</section>
	<?php }; ?>
	
</aside>