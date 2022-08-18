<?php

/**
 * This function will be triggered on plugin activation
 */
function ttbn_activate_plugin()
{
    /**
     * Set global options for plugin on install
     */
    if (false === get_option('ttbn_breaking_news_title') && false === update_option('ttbn_breaking_news_title', false)) {
        add_option('ttbn_breaking_news_title', "Breaking News");
    }

    if (false === get_option('ttbn_breaking_text_color') && false === update_option('ttbn_breaking_text_color', false)) {
        add_option('ttbn_breaking_text_color', "#FFFFFF");
    }

    if (false === get_option('ttbn_breaking_background_color') && false === update_option('ttbn_breaking_background_color', false)) {
        add_option('ttbn_breaking_background_color', "#000000");
    }
    if (false === get_option('ttbn_frontend_custom_selector') && false === update_option('ttbn_frontend_custom_selector', false)) {
        add_option('ttbn_frontend_custom_selector', "");
    }

}

register_activation_hook(TTBN_PLUGIN_FILE, 'ttbn_activate_plugin');