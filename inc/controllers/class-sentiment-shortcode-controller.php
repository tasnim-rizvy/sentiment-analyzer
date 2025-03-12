<?php

namespace Sentiment_Analyzer\Controllers;

if (! defined('ABSPATH')) {
    exit;
}

class Sentiment_Shortcode_Controller {
    public function __construct() {
        add_shortcode( 'sentiment_filter', array( $this, 'sentiment_filter_posts' ) );
    }

    public function sentiment_filter_posts( $atts ) {
        $attributes = shortcode_atts(['sentiment' => 'neutral'], $atts, 'sentiment_filter');
        $sentiment = explode("|", $attributes['sentiment']);
        $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

        $query = new \WP_Query([
            'post_type' => 'post',
            'posts_per_page' => 5,
            'meta_query' => array(
                array(
                    'key' => 'post-sentiment',
                    'value' => $sentiment,
                    'compare' => 'IN',
                ),
            ),
            'paged' => $paged,
        ]);

        ob_start();
        if ($query->have_posts()) {
            echo '<h4>Posts with sentiment: ' . implode(', ', $sentiment) . '</h4>';
            $output = '<ul>';
            while ($query->have_posts()) {
                $query->the_post();
                $output .= '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
            }
            $output .= '</ul>';

            echo $output;
        } else {
            $output = '<p>No posts found with sentiment: ' . $sentiment . '</p>';
        }

        wp_reset_postdata();
        return ob_get_clean();
    }
}

new Sentiment_Shortcode_Controller();