<?php 

namespace SentimentAnalyzer\Models;

if (! defined('ABSPATH')) {
    exit;
}

class Sentiment {
    public static function get_keywords() {
        return get_option('sentiment_keywords');
    }

    public static function sentiment_analysis() {
        $keywords = self::get_keywords();
        $content = strtolower(strip_tags(get_the_content()));

        $sentiment_counts = array(
            'positive' => 0,
            'negative' => 0,
            'neutral' => 0,
        );

        foreach ($keywords as $sentiment => $words) {
            foreach ($words as $word) {
                $sentiment_counts[$sentiment] += substr_count($content, $word);
            }
        }

        if ($sentiment_counts['positive'] > $sentiment_counts['negative']) {
            return 'positive';
        } elseif ($sentiment_counts['negative'] > $sentiment_counts['positive']) {
            return 'negative';
        } else {
            return 'neutral';
        }
    }
}