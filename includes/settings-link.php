<?php

add_filter("plugin_action_links_" . TTBN_PLUGIN_NAME, 'ttbn_settings_link');

function ttbn_settings_link($links)
{
    $settings_link = '<a href="edit.php?page=ttbn_breaking_news">Settings</a>';

    array_push($links, $settings_link);
    return $links;
}