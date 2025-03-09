<?php

namespace Sentiment_Analyzer\Controllers;

use Sentiment_Analyzer\Models\Sentiment_Model;

if (! defined('ABSPATH')) {
    exit;
}

class Sentiment_Controller {
    public function __construct() {
        add_action('save_post', array($this, 'get_post_sentiment'));
    }

    public function get_post_sentiment($post_id) {
        if (wp_is_post_revision($post_id) || wp_is_post_autosave($post_id)) {
            return;
        }

        $content = get_the_content($post_id);
        $sentiment = Sentiment_Model::sentiment_analysis($content);

        update_post_meta($post_id, 'post-sentiment', $sentiment);
    }
}

new Sentiment_Controller();
