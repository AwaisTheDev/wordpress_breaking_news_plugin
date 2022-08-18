<?php

/**
 * Trigger this file on plugin uninstall
 */

if (!defined('WP_INSTALL_PLUGIN')) {
    die;
}

/**
 * Remove plugin options on install
 */
delete_option('breaking_background_color');
delete_option('breaking_text_color');
delete_option('breaking_news_title');