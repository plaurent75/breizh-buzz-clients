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
 * Version:           2.1.0
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
$configBBZ = array(
		            'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
		            'proper_folder_name' => 'breizh-buzz-clients-master', // this is the name of the folder your plugin lives in
		            'api_url' => 'https://api.github.com/repos/plaurent75/breizh-buzz-clients', // the GitHub API url of your GitHub repo
		            'raw_url' => 'https://raw.github.com/plaurent75/breizh-buzz-clients/master', // the GitHub raw url of your GitHub repo
		            'github_url' => 'https://github.com/plaurent75/breizh-buzz-clients', // the GitHub url of your GitHub repo
		            'zip_url' => 'https://github.com/plaurent75/breizh-buzz-clients/zipball/master', // the zip url of the GitHub repo
		            'sslverify' => true, // whether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
		            'requires' => '4.0', // which version of WordPress does your plugin require?
		            'tested' => '4.4.1', // which versionof WordPress is your plugin tested up to?
		            'readme' => 'README.md', // which file to use as the readme for the version number
		            'access_token' => ''
		            );
new WP_GitHub_Updater($configBBZ);
