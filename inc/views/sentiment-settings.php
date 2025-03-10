<?php $keywords = get_option('sentiment_keywords'); ?>

<div class="wrap">
    <h2><?php esc_html_e('Sentiment Analyzer Settings', 'sentiment-analyzer') ?></h2>
    <form method="post">
	    <?php  wp_nonce_field('sentiment_nonce_action', 'sentiment_nonce'); ?>

        <table class="form-table" role="presentation">
            <tbody>
                <tr>
                    <th scope="row">
                        <label><?php esc_html_e('Positive Keywords', 'sentiment-analyzer') ?></label>
                    </th>
                    <td>
                        <textarea name="positive_keywords" rows="10" cols="50" class="large-text"><?php echo implode(', ', $keywords['positive']) ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <label><?php esc_html_e('Negative Keywords', 'sentiment-analyzer') ?></label>
                    </th>
                    <td>
                        <textarea name="negative_keywords" rows="10" cols="50" class="large-text"><?php echo implode(', ', $keywords['negative']) ?></textarea>
                    </td>
                </tr>
                <tr>
                    <th scope="row">
                        <input type="submit" value="<?php esc_attr_e('Save Settings', 'sentiment-analyzer') ?>" class="button-primary">
                    </th>
                </tr>
            </tbody>
        </table>
    </form>
</div>