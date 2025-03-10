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
 * Update URI:        https://example.com/my-plugin/
 */

if (! defined('ABSPATH')) {
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
		$this->sa_constants();
		$this->sa_load_files();
		register_activation_hook(__FILE__, [$this, 'sa_activate']);
	}

	/**
	 * Initializes a singleton instance
	 *
	 * @return self
	 */
	public static function init(): self {
		static $instance = false;

		if (! $instance) {
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
		define('PLUGIN_PATH', plugin_dir_path(__FILE__));
		define('PLUGIN_URL', plugin_dir_url(__FILE__));
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
			'positive' => array('good', 'great', 'awesome', 'fantastic'),
			'negative' => array('bad', 'terrible', 'awful', 'worst'),
		));
	}
}

/**
 * Initializes the main plugin
 *
 * @return Sentiment_Analyzer
 */
Sentiment_Analyzer::init();