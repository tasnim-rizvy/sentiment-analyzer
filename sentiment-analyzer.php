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

define('PLUGIN_PATH', plugin_dir_path(__FILE__));
define('PLUGIN_URL', plugin_dir_url(__FILE__));

/**
 * Action upon activation of the plugin.
 *
 * When the plugin is activated, this function adds the default sentiment keywords under 'sentiment_keywords' option.
 *
 * @return void
 */
function sa_plugin_activate() {
    add_option( 'sentiment_keywords', array(
        'positive' => array('good', 'great', 'awesome', 'fantastic'),
        'negative' => array('bad', 'terrible', 'awful', 'worst'),
        'neutral' => array('okay', 'fine', 'average', 'alright'),
    ));
}

register_activation_hook(__FILE__, 'sa_plugin_activate');