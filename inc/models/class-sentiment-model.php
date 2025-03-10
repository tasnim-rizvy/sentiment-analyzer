<?php 

namespace Sentiment_Analyzer\Models;

if (! defined('ABSPATH')) {
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
    public static function get_keywords() {
        return get_option('sentiment_keywords');
    }

    public static function sentiment_analysis($post_content): string {
        $keywords = self::get_keywords();
        $content = strtolower(strip_tags($post_content));

        $sentiment_counts = array(
            'positive' => 0,
            'negative' => 0,
        );

        foreach ($keywords as $sentiment => $words) {
            foreach ($words as $word) {
                $sentiment_counts[$sentiment] += substr_count($content, $word);
            }
        };

        if ($sentiment_counts['positive'] > $sentiment_counts['negative']) {
            return 'positive';
        } elseif ($sentiment_counts['negative'] > $sentiment_counts['positive']) {
            return 'negative';
        } else {
            return 'neutral';
        }
    }
}