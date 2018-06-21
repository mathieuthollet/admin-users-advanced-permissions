<?php
/*
 Plugin Name: Admin users advanced permissions
 Plugin URI: https://wordpress.org/plugins/admin-users-advances-permissions/
 Description: Set up permissions for categories and taxonomies to admin users whose role is not "administrator"
 Version: 1.03
 Author: Mathieu Thollet
 Author URI: http://www.awebvision.fr
 Text Domain: admin-users-advances-permissions
 */


define('AUAP_PATH', plugin_dir_path(__FILE__));
define('AUAP_WEB_PATH', plugin_dir_url(__FILE__));
define('AUAP_I18N_DOMAIN', 'admin-users-advances-permissions');

require_once (AUAP_PATH.'inc/admin-restrict-cat-tax.php');
require_once (AUAP_PATH.'inc/admin-users.php');
require_once (AUAP_PATH.'inc/functions.php');

load_plugin_textdomain(AUAP_I18N_DOMAIN , false , dirname(plugin_basename( __FILE__ )).'/lang/');

/** Plugin install */
function auap_install() {
	// Nothing to do !
}
register_activation_hook(__FILE__,'auap_install');



/** Plugin uninstall */
function auap_uninstall() {
	// Nothing to do !
}
register_deactivation_hook(__FILE__,'auap_uninstall');



?>