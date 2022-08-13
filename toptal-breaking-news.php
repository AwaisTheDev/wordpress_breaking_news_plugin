<?php

/**
 * Plugin Name:       Toptal Breaking News
 * Plugin URI:        https://mdawais.com/wordpress/breaking-news
 * Description:       This plugin add the ability to set one of your posts as a breaking news and then display that breaking news below website header
 * Version:           1.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            Muhammad Awais
 * Author URI:        https://mdawais.com
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        https://example.com/my-plugin/
 * Text Domain:       ttbn
 * Domain Path:       /languages
 */

if (!defined('ABSPATH')) {
    die;
}

class ToptalBreakingNews
{

    public function activate()
    {
        //do something on plugin activation
    }

    public function deactivate()
    {
        //do something on plugin deactivation
    }

    public function uninstall()
    {
        //do something on plugin uninstall

    }
}

if (class_exists('ToptalBreakingNews')) {
    $toptalBreakingNews = new ToptalBreakingNews;
}

/**
 * Plugin activation hook
 */

register_activation_hook(__FILE__, array($toptalBreakingNews, 'activate'));

/**
 * Plugin activation hook
 */

register_deactivation_hook(__FILE__, array($toptalBreakingNews, 'deactivate'));