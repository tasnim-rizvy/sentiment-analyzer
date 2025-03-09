<?php 

namespace Sentiment_Analyzer\Controllers;

if (! defined('ABSPATH')) {
    exit;
}

class Sentiment_Admin_Controller {
    public function __construct() {
        add_action('admin_menu', array($this, 'sentiment_admin_menu'));
    }

    public function sentiment_admin_menu() {
        add_options_page(
            'Sentiment Analyzer',
            'Sentiment Analyzer',
            'manage_options',
            'sentiment-analyzer',
            array($this, 'sentiment_settings_page'),
            'dashicons-admin-comments',
            20
        );
    }

    public function sentiment_settings_page() {
        if(!empty($_POST) && $_POST['positive_keywords'] && $_POST['negative_keywords']) {
            $positive_keywords = explode(',', $_POST['positive_keywords']);
            $negative_keywords = explode(',', $_POST['negative_keywords']);

            $keywords = array(
                'positive' => array_map('trim', $positive_keywords),
                'negative' => array_map('trim', $negative_keywords),
            );

            update_option('sentiment_keywords', $keywords);
            echo '<div class="updated"><p>Settings saved.</p></div>';
        }
        include_once PLUGIN_PATH . 'inc/views/sentiment-settings.php';
    }
}

new Sentiment_Admin_Controller();