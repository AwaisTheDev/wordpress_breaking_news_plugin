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

define('TTBN_PLUGIN_NAME', plugin_basename(__FILE__));

define('TTBN_PLUGIN_PATH', trailingslashit(plugin_dir_path(__FILE__)));
define('TTBN_PLUGIN_URL', trailingslashit(plugins_url('/', __FILE__)));

/**
 * include plugin activate function
 */
require_once plugin_dir_path(__FILE__) . 'includes/activate-plugin.php';

/**
 * include plugin deactivate function
 */

require_once plugin_dir_path(__FILE__) . 'includes/deactivate-plugin.php';

/**
 * include css and js
 */

require_once plugin_dir_path(__FILE__) . 'includes/enqueue-scripts.php';

/**
 * include plugin plugin settings page
 */

require_once plugin_dir_path(__FILE__) . 'includes/settings-page.php';

/**
 * include plugin plugin settings link
 */

require_once plugin_dir_path(__FILE__) . 'includes/settings-link.php';

/**
 * Include post metabox
 */

require_once plugin_dir_path(__FILE__) . 'includes/post-metabox.php';

/**
 * include helper functions
 */

require_once plugin_dir_path(__FILE__) . 'includes/load-widget-frontend.php';