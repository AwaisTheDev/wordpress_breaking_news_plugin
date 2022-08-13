<?php

function ttbn_enqueue_plugin_scripts()
{

    // Add the color picker css file
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');

    wp_enqueue_style('ttbn_admin_style', TTBN_PLUGIN_URL . '/admin/css/style.css', array(), 1.0, 'all');
    wp_enqueue_script('ttbn_admin_script', TTBN_PLUGIN_URL . '/admin/js/main.js', array(), 1.0, 'all');

}

add_action('admin_enqueue_scripts', 'ttbn_enqueue_plugin_scripts');