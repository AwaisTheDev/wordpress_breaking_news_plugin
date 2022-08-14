<?php

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
    add_settings_section('general_settings', 'General Settings', 'general_settings_callback', 'ttbn_breaking_news');

    /**
     * This will register a new settings option
     */
    //register_setting($option_group, $option_name, $sanitize_callback)
    register_setting('ttbn_settings_group', 'breaking_news_title');
    register_setting('ttbn_settings_group', 'breaking_background_color');
    register_setting('ttbn_settings_group', 'breaking_text_color');

    //add_settings_field($id, $title, $callback, $page, $section, $args)
    add_settings_field('breaking_news_title_field', 'Section Title', 'breaking_news_title_callback', 'ttbn_breaking_news', 'general_settings');
    add_settings_field('breaking_news_bg_color_field', 'Background Color', 'breaking_news_background_color_callback', 'ttbn_breaking_news', 'general_settings');
    add_settings_field('breaking_news_text_color_field', 'Text Color', 'breaking_news_text_color_callback', 'ttbn_breaking_news', 'general_settings');
}

function general_settings_callback()
{
    echo "Here you can change the breaking news section settings. You can change title and section colors.";
}

function breaking_news_title_callback()
{
    $value = get_option('breaking_news_title');

    if ($value == null || $value == "") {
        $value = "Breaking News";
    }

    echo "<input type='text' name='breaking_news_title' value='$value'>";

}

function breaking_news_background_color_callback()
{
    $value = get_option('breaking_background_color');

    echo "<input type='text' class='ttbn-color-picker' name='breaking_background_color' value='$value'>";

}

function breaking_news_text_color_callback()
{
    $value = get_option('breaking_text_color');

    echo "<input type='text' class='ttbn-color-picker' name='breaking_text_color' value='$value'>";

}