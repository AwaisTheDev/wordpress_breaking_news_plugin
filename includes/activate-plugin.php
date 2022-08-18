<?php

/**
 * This function will be triggered on plugin activation
 */
function ttbn_activate_plugin()
{
    /**
     * Set global options for plugin on install
     */
    if (false === get_option('breaking_news_title') && false === update_option('breaking_news_title', false)) {
        add_option('breaking_news_title', "Breaking News");
    }

    if (false === get_option('breaking_text_color') && false === update_option('breaking_text_color', false)) {
        add_option('breaking_text_color', "#FFFFFF");
    }

    if (false === get_option('breaking_background_color') && false === update_option('breaking_background_color', false)) {
        add_option('breaking_background_color', "#000000");
    }

}

register_activation_hook(TTBN_PLUGIN_FILE, 'ttbn_activate_plugin');