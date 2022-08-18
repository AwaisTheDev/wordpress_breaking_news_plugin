<?php
/**
 * This function will be triggered on plugin deactivation
 */
function ttbn_deactivate_plugin()
{

}
register_deactivation_hook(TTBN_PLUGIN_FILE, 'ttbn_deactivate_plugin');