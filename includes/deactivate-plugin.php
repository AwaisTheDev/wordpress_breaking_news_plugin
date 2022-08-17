<?php
/**
 * This function will be triggered on plugin deactivation
 */
function ttbn_deactivate_plugin()
{

}
register_deactivation_hook(__FILE__, 'ttbn_deactivate_plugin');