<?php

namespace Sentiment_Analyzer\Controllers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sentiment_Shortcode_Controller {
	public function __construct() {
		add_shortcode( 'sentiment_filter', array( $this, 'sentiment_filter_posts' ) );
	}

	public function sentiment_filter_posts( $atts ): bool|string {
		$attributes = shortcode_atts( [ 'sentiment' => 'neutral' ], $atts, 'sentiment_filter' );
		$sentiment  = explode( "|", $attributes['sentiment'] );
		$paged      = max( 1, get_query_var( 'paged', 1 ) );

		$query = new \WP_Query( [
			'post_type'           => 'post',
			'posts_per_page'      => 10,
			'ignore_sticky_posts' => 1,
			'paged'               => $paged,
			'meta_query'          => array(
				array(
					'key'     => 'post-sentiment',
					'value'   => $sentiment,
					'compare' => 'IN',
				),
			),
		] );

		ob_start();
		if ( $query->have_posts() ) {
			echo '<h4>' . __( 'Posts with sentiment', 'sentiment-analyzer' ) . ': ' . implode( ', ', $sentiment ) . '</h4>';
			$output = '<ul>';
			while ( $query->have_posts() ) {
				$query->the_post();
				$output .= '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
			}
			$output .= '</ul>';

			if ( $query->max_num_pages > 1 ) {
				$output .= paginate_links(
					array(
						'current'  => max( 1, $paged ),
						'total'    => $query->max_num_pages,
						'mid_size' => 3,
						'format'   => '?query-sentiment-page=%#%',
					)
				);
			}
			echo $output;
		} else {
			$output = '<p>' . __( 'No posts found with sentiment', 'sentiment-analyzer' ) . ': ' . implode( ', ', $sentiment ) . '</p>';
			echo $output;
		}

		wp_reset_postdata();

		return ob_get_clean();
	}
}

new Sentiment_Shortcode_Controller();