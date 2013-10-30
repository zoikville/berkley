<?php


function of_pagenavi( $settings ) {
	$s = wp_parse_args( $settings, array(
		'range' => '5',
		'before' => '',
		'after' => '',
	) );
	$range = intval( $s['range'] );
	global $paged, $wp_query;
	if ( ! $max_page ) {
		$max_page = $wp_query->max_num_pages;
	}
	if( $max_page > 1 ) {
		echo $s['before'];
		echo '<nav class="pagenavi">';
		if( ! $paged ) {
			$paged = 1;
		}
		previous_posts_link( ' &lsaquo; ' );
		if( $max_page > $range ) {
			if( $paged < $range ) {
				for( $i = 1; $i <= ( $range + 1 ); $i++ ) {
					$classes = array( 'page' );
					$href = get_pagenum_link($i);
					if( $i == $paged )
						$classes[] = 'current';
					printf( '<a href="%s" class="%s">%s</a>', $href, implode( ' ', $classes ), $i );
				}
			} elseif( $paged >= ( $max_page - ceil( ( $range/2 ) ) ) ) {
				for( $i = $max_page - $range; $i <= $max_page; $i++ ) {
					$classes = array( 'page' );
					$href = get_pagenum_link($i);
					if( $i == $paged )
						$classes[] = 'current';
					printf( '<a href="%s" class="%s">%s</a>', $href, implode( ' ', $classes ), $i );
				}
			} elseif( $paged >= $range && $paged < ( $max_page - ceil( ( $range/2 ) ) ) ) {
				for( $i = ( $paged - ceil( $range/2 ) ); $i <= ( $paged + ceil( ( $range/2 ) ) ); $i++ ) {
					$classes = array( 'page' );
					$href = get_pagenum_link($i);
					if( $i == $paged )
						$classes[] = 'current';
					printf( '<a href="%s" class="%s">%s</a>', $href, implode( ' ', $classes ), $i );
				}
			}
		} else {
			for( $i = 1; $i <= $max_page; $i++ ) {
				$classes = array( 'page' );
				$href = get_pagenum_link($i);
				if( $i == $paged )
					$classes[] = 'current';
				printf( '<a href="%s" class="%s">%s</a>', $href, implode( ' ', $classes ), $i );
			}
		}
		next_posts_link(' &rsaquo; ');
		echo '</nav><!-- .wp-pagenavi -->';
		echo $s['after'];
	}
}

function of_previous_posts_link_attributes() {
	return 'class="prev"';
}
add_filter( 'previous_posts_link_attributes', 'of_previous_posts_link_attributes' );

function of_next_posts_link_attributes() {
	return 'class="next"';
}
add_filter( 'next_posts_link_attributes', 'of_next_posts_link_attributes' );

