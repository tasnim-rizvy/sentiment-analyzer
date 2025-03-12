<?php

namespace Sentiment_Analyzer\Models;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Sentiment_Model
 *
 * This class is responsible for handling sentiment analysis operations.
 * It provides methods to analyze text and determine the sentiment.
 *
 * @package sentiment-analyzer
 */
class Sentiment_Model {
	public static function sentiment_analysis( $post_content ): string {
		$keywords = get_option( 'sentiment_keywords' );
		$content  = strtolower( wp_strip_all_tags( $post_content ) );

		$sentiment_counts = array(
			'positive' => 0,
			'negative' => 0,
			'neutral'  => 0,
		);

		foreach ( $keywords as $sentiment => $words ) {
			foreach ( $words as $word ) {
				$sentiment_counts[ $sentiment ] += substr_count( $content, $word );
			}
		};

		if ( $sentiment_counts['positive'] === 0 && $sentiment_counts['negative'] === 0 && $sentiment_counts['neutral'] === 0 ) {
			return 'neutral';
		} else {
			return array_keys( $sentiment_counts, max( $sentiment_counts ) )[0];
		}
	}
}