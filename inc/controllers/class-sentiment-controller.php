<?php

namespace Sentiment_Analyzer\Controllers;

use Sentiment_Analyzer\Models\Sentiment_Model;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sentiment_Controller {
	public function __construct() {
		add_action( 'save_post', array( $this, 'get_post_sentiment' ) );
		add_filter( 'post_class', array( $this, 'add_sentiment_class' ) );
	}

	public function get_post_sentiment( $post_id ): void {

		if ( wp_is_post_revision( $post_id ) || wp_is_post_autosave( $post_id ) ) {
			return;
		}

		$content   = get_post_field( 'post_content', $post_id );
		$sentiment = Sentiment_Model::sentiment_analysis( $content );

		update_post_meta( $post_id, 'post-sentiment', $sentiment );
	}

	public function add_sentiment_class( $classes ): array {
		$sentiment = get_post_meta( get_the_ID(), 'post-sentiment', true );

		if ( $sentiment ) {
			$classes[] = 'post-sentiment-' . $sentiment;
		}

		return $classes;
	}
}

new Sentiment_Controller();
