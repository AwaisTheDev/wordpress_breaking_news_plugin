<?php

add_action('wp_footer', 'ttbn_add_breaking_news_to_header');

function ttbn_add_breaking_news_to_header()
{
    ob_start();

    /**
     * Search for breaking news post
     *
     */
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per_page' => 1,
        'ignore_sticky_posts' => 1,
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
        $background_color = get_option('ttbn_breaking_background_color');
        $text_color = get_option('ttbn_breaking_text_color');
        $widget_title = get_option('ttbn_breaking_news_title');
        $custom_selector = get_option('ttbn_frontend_custom_selector');

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

    wp_reset_postdata();

    $html = ob_get_clean();

    /**
     * Below code will check if the user has added a custom selector on the options page. if not it find the elements on the page in following priority
     * header, .header, .site-header, #masthead if one of the elements is found on the page it will add the breaking news section below that. if none of the
     * above elements is found we just add the widget to the top of body
     * */
    echo
        '<script>
        jQuery(document).ready(function($){
            var mainHeader = $("header").first();
            var headerClass = $(".header").first();
            var siteHeader = $(".site-header").first();
            var customSelector = $("' . $custom_selector . '").first();

            if(customSelector.length > 0){
                $( "' . $html . '" ).insertAfter( customSelector ).first();
            }else if(mainHeader.length > 0){
                $( "' . $html . '" ).insertAfter( mainHeader ).first();
            }else if(headerClass.length > 0){
                $( "' . $html . '" ).insertAfter( headerClass ).first();
            }else if(siteHeader.length > 0){
                $( "' . $html . '" ).insertAfter( siteHeader ).first();
            }else if(masthead.length > 0){
                $( "' . $html . '" ).insertAfter( masthead ).first();
            }else{
                $("body").prepend( "' . $html . '");
            }
        })
    </script>';

}

/**Load jquery if not already enqueued */

function ttbn_load_jquery()
{
    if (!wp_script_is('jquery', 'enqueued')) {

        //Enqueue
        wp_enqueue_script('jquery');

    }
}
add_action('wp_enqueue_scripts', 'ttbn_load_jquery');