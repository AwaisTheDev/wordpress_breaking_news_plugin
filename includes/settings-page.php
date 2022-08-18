<?php

/**
 * This find will create a new admin subpage under posts menu. This page will have plgin settings
 */

function ttbn_plugin_settings_page()
{
    //add settings page for the plugin settings
    add_submenu_page(
        'edit.php',
        __('Breaking News Setting', 'ttbn'),
        __('Breaking News', 'ttbn'),
        'manage_options',
        'ttbn_breaking_news',
        'ttbn_breaking_news_options_page'
    );

    add_action('admin_init', 'ttbn_plugin_settings');
}

add_action('admin_menu', 'ttbn_plugin_settings_page');

function ttbn_breaking_news_options_page()
{
    require_once TTBN_PLUGIN_PATH . 'includes/templates/settings-page-content.php';
}

function ttbn_plugin_settings()
{

    /**
     * This will create a section on the page
     */
    //add_settings_section( $id:string, $title:string, $callback:callable, $page:string )
    add_settings_section('general_settings', __('General Settings', 'ttbn'), 'general_settings_callback', 'ttbn_breaking_news');

    /**
     * This will register a new settings option
     */
    //register_setting($option_group, $option_name, $sanitize_callback)
    register_setting('ttbn_settings_group', 'ttbn_breaking_news_title');
    register_setting('ttbn_settings_group', 'ttbn_breaking_background_color');
    register_setting('ttbn_settings_group', 'ttbn_breaking_text_color');
    register_setting('ttbn_settings_group', 'ttbn_frontend_custom_selector');
    register_setting('ttbn_settings_group', 'ttbn_edit_breaking_news_link');

    //add_settings_field($id, $title, $callback, $page, $section, $args)
    add_settings_field('ttbn_breaking_news_title_field', __('Section Title', 'ttbn'), 'ttbn_breaking_news_title_callback', 'ttbn_breaking_news', 'general_settings');
    add_settings_field('breaking_news_bg_color_field', __('Background Color', 'ttbn'), 'ttbn_breaking_news_background_color_callback', 'ttbn_breaking_news', 'general_settings');
    add_settings_field('breaking_news_text_color_field', __('Text Color', 'ttbn'), 'ttbn_breaking_news_text_color_callback', 'ttbn_breaking_news', 'general_settings');
    add_settings_field('ttbn_frontend_custom_selector_field', __('Custom selector for frontend widget(Optional)', 'ttbn'), 'ttbn_breaking_news_custom_selector', 'ttbn_breaking_news', 'general_settings');
    add_settings_field('breaking_news_edit_link', __('Active Breaking news', 'ttbn'), 'ttbn_edit_breaking_news_link_callback', 'ttbn_breaking_news', 'general_settings');

}

function general_settings_callback()
{
    echo "Here you can change the breaking news section settings. You can change title and section colors.";
}

/* Breaking news widget title field*/
function ttbn_breaking_news_title_callback()
{
    $value = get_option('ttbn_breaking_news_title');

    echo "<input type='text' name='ttbn_breaking_news_title' value='$value'>";

}

/* Breaking news widget background color field*/
function ttbn_breaking_news_background_color_callback()
{
    $value = get_option('ttbn_breaking_background_color');

    echo "<input type='text' class='ttbn-color-picker' name='ttbn_breaking_background_color' value='$value'>";

}

/* Breaking news widget text color field*/
function ttbn_breaking_news_text_color_callback()
{
    $value = get_option('ttbn_breaking_text_color');

    echo "<input type='text' class='ttbn-color-picker' name='ttbn_breaking_text_color' value='$value'>";

}

/* Breaking news custom class for frontend widget*/
function ttbn_breaking_news_custom_selector()
{
    $value = get_option('ttbn_frontend_custom_selector');

    echo "<label>Enter a custom selector here if you want to show the breaking news widget on a different location or the widget doesn't display at desired
    location automatically.
    <br>Note: This will display the widget after this selector. eg #navigation, .my-header </label><br>";
    echo "<input type='text' name='ttbn_frontend_custom_selector' value='$value'>";

}

/* Breaking news post edit link field*/

function ttbn_edit_breaking_news_link_callback()
{
    $args = array(
        'post_type' => 'post',
        'post_status' => 'publish',
        'posts_per-page' => 1,
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
        while ($breaking_news->have_posts()) {
            $breaking_news->the_post();

            echo get_the_title();
            echo "<br>";
            edit_post_link('Edit post');

        }
    } else {
        echo __("Currently there is no active breaking news. You can set a post as active breaking news on the post edit page.");
    }

}