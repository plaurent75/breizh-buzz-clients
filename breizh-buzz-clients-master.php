<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.patricelaurent.net
 * @since             1.0.0
 * @package           Breizh_Buzz_Clients_Master
 *
 * @wordpress-plugin
 * Plugin Name:       Breizh Buzz Clients
 * Plugin URI:        http://breizhbuzz.com
 * Description:       Fonctionnalité et filtre pour les sites clients de Breizh Buzz.
 * Version:           2.0
 * Author:            LAURENT Patrice
 * Author URI:        http://www.patricelaurent.net
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       breizh-buzz-clients-master
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-breizh-buzz-clients-master-activator.php
 */
function activate_breizh_buzz_clients_master() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-breizh-buzz-clients-master-activator.php';
	Breizh_Buzz_Clients_Master_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-breizh-buzz-clients-master-deactivator.php
 */
function deactivate_breizh_buzz_clients_master() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-breizh-buzz-clients-master-deactivator.php';
	Breizh_Buzz_Clients_Master_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_breizh_buzz_clients_master' );
register_deactivation_hook( __FILE__, 'deactivate_breizh_buzz_clients_master' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-breizh-buzz-clients-master.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_breizh_buzz_clients_master() {

	$plugin = new Breizh_Buzz_Clients_Master();
	$plugin->run();

}
run_breizh_buzz_clients_master();
