<?php

add_action('wp_head', 'ttbn_add_breaking_news_to_header');

function ttbn_add_breaking_news_to_header()
{

    /**
     * Search for breaking news post
     *
     */
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'meta_query' => array(
            array(
                'key' => 'is-breaking-news',
                'value' => '1',
                'compare' => 'LIKE',
            ),
        ),
    );

    $breaking_news = new WP_Query($args);

    if ($breaking_news->have_posts()) {

        /**
         * Get global options for the widget like title, text-color and background-color and set a custom value if options are not
         * set on the options page
         */
        $background_color = get_option('breaking_background_color');
        $text_color = get_option('breaking_text_color');
        $widget_title = get_option('breaking_news_title');

        if ($background_color == null || $background_color == "") {
            $background_color = "black";
        }

        if ($text_color == null || $text_color == "") {
            $text_color = "White";
        }

        if ($widget_title == null || $widget_title == "") {
            $widget_title = "Breaking News";
        }

        echo "<div class='ttbn-breaking-news-wrapper' style='background:$background_color; color:$text_color'> ";

        echo "<span class='ttbn_title'>$widget_title: </span>";

        while ($breaking_news->have_posts()) {
            $breaking_news->the_post();

            $custom_title = get_post_meta(get_the_ID(), 'custom-title', true);

            /**
             * Check if there is a custom title for the post and display custom title if not dialay post title
             */

            $permalink = get_the_permalink();
            echo "<a href='$permalink' style='color:$text_color'>";
            if ($custom_title != null || $custom_title != "") {
                echo $custom_title;
            } else {
                echo get_the_title();
            }
            echo "<span class='ttbn_right_icon'>→</span>";
            echo "</a>";

        }
        echo "</div>";

    }

}