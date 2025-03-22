<?php

namespace Sentiment_Analyzer\Controllers;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Sentiment_Admin_Controller {
	public function __construct() {
		add_action( 'admin_menu', array( $this, 'sentiment_admin_menu' ) );
	}

	public function sentiment_admin_menu(): void {
		add_options_page(
			'Sentiment Analyzer',
			'Sentiment Analyzer',
			'manage_options',
			'sentiment-analyzer',
			array( $this, 'sentiment_settings_page' ),
			'dashicons-admin-comments',
			20
		);
	}

	public function sentiment_settings_page(): void {
		if ( isset( $_SERVER['REQUEST_METHOD'] ) && $_SERVER['REQUEST_METHOD'] === 'POST' ) {
			if ( ! isset( $_POST['sentiment_nonce'] ) && ! wp_verify_nonce( wp_unslash( $_POST['sentiment_nonce'] ), 'sentiment_nonce_action' ) ) {
				wp_die( __( 'Security check failed', 'sentiment-analyzer' ) );
			}

			$positive_keywords = explode( ',', wp_unslash( $_POST['positive_keywords'] ) );
			$negative_keywords = explode( ',', wp_unslash( $_POST['negative_keywords'] ) );
			$neutral_keywords  = explode( ',', wp_unslash( $_POST['neutral_keywords'] ) );

			$keywords = array(
				'positive' => array_map( 'trim', $positive_keywords ),
				'negative' => array_map( 'trim', $negative_keywords ),
				'neutral'  => array_map( 'trim', $neutral_keywords ),
			);

			update_option( 'sentiment_keywords', $keywords );
			echo '<div class="updated"><p>' . __( 'Settings saved.', 'sentiment-analyzer' ) . '</p></div>';
		}

		include_once PLUGIN_PATH . 'inc/views/sentiment-settings.php';
	}
}

new Sentiment_Admin_Controller();