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
delete_option('ttbn_breaking_news_title');
delete_option('ttbn_breaking_text_color');
delete_option('ttbn_breaking_background_color');
delete_option('ttbn_frontend_custom_selector');