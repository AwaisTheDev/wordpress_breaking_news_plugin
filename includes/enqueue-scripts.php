<?php

function ttbn_enqueue_plugin_scripts()
{

    /* Load color picker CSS and JS files which are pre-registered in wordpress*/
    wp_enqueue_style('wp-color-picker');
    wp_enqueue_script('wp-color-picker');

    /* Load custom CSS and JS files for the plugin */
    wp_enqueue_style('ttbn_admin_style', TTBN_PLUGIN_URL . '/admin/css/style.css', array(), 1.0, 'all');
    wp_enqueue_script('ttbn_admin_script', TTBN_PLUGIN_URL . '/admin/js/main.js', array(), 1.0, 'all');

    // Load the datepicker script (pre-registered in WordPress).
    wp_enqueue_script('jquery-ui-datepicker');
    wp_register_style('jquery-ui', 'https://code.jquery.com/ui/1.12.1/themes/smoothness/jquery-ui.css');
    wp_enqueue_style('jquery-ui');

    /* jQuery time pick scripts */
    wp_enqueue_style('jquery-timepicker', '//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.css', array(), "1.0", 'all');

    wp_enqueue_script('jquery-time-picker', '//cdnjs.cloudflare.com/ajax/libs/timepicker/1.3.5/jquery.timepicker.min.js', array(), '1.0', true);
}

add_action('admin_enqueue_scripts', 'ttbn_enqueue_plugin_scripts');