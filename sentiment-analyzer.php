<?php

/**
 * Plugin Name
 *
 * @package           sentiment-analyzer
 * @author            Tasnim Rizvy
 * @copyright         2025 Tasnim Rizvy
 * @license           GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name:       Sentiment Analyzer
 * Plugin URI:        https://example.com/plugin-name
 * Description:       A plugin to analyze post contents for sentiment.
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Tasnim Rizvy
 * Author URI:        https://example.com
 * Text Domain:       sentiment-analyzer
 * License:           GPL v2 or later
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

final class Sentiment_Analyzer {
	/**
	 * Plugin version
	 *
	 * @return string
	 */
	public const VERSION = '1.0.0';

	/**
	 * Class constructor
	 */
	private function __construct() {
		self::sa_constants();
		self::sa_load_files();

		add_action( 'wp_enqueue_scripts', array( $this, 'sa_enqueue_assets' ) );
		register_activation_hook( __FILE__, array( $this, 'sa_activate' ) );
	}

	/**
	 * Initializes a singleton instance
	 *
	 * @return self
	 */
	public static function init(): self {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self();
		}

		return $instance;
	}

	/**
	 * Define the required constants
	 *
	 * @return void
	 */
	private function sa_constants(): void {
		define( 'PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
		define( 'PLUGIN_URL', plugin_dir_url( __FILE__ ) );
	}

	/**
	 * Load required plugin files
	 *
	 * @return void
	 */
	private function sa_load_files(): void {
		include PLUGIN_PATH . 'inc/models/class-sentiment-model.php';
		include PLUGIN_PATH . 'inc/controllers/class-sentiment-controller.php';
		include PLUGIN_PATH . 'inc/controllers/class-sentiment-admin-controller.php';
		include PLUGIN_PATH . 'inc/controllers/class-sentiment-shortcode-controller.php';
	}

	/**
	 * Enqueue plugin assets
	 *
	 * @return void
	 */
	public function sa_enqueue_assets(): void {
		wp_enqueue_style( 'sentiment-analyzer', PLUGIN_URL . 'assets/css/sentiment-analyzer.css', array(), filemtime( PLUGIN_PATH . 'assets/css/sentiment-analyzer.css' ) );
	}

	/**
	 * Action upon activation of the plugin.
	 *
	 * When the plugin is activated, this function adds the default sentiment keywords under 'sentiment_keywords' option.
	 *
	 * @return void
	 */
	public function sa_activate(): void {
		add_option( 'sentiment_keywords', array(
			'positive' => array( 'good', 'great', 'awesome', 'fantastic' ),
			'negative' => array( 'bad', 'terrible', 'awful', 'worst' ),
			'neutral'  => array( 'okay', 'fine', 'average', 'normal' ),
		) );
	}
}

/**
 * Initializes the main plugin
 *
 * @return Sentiment_Analyzer
 */
Sentiment_Analyzer::init();