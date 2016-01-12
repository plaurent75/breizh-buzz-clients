<?php

/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       http://www.patricelaurent.net
 * @since      1.0.0
 *
 * @package    Breizh_Buzz_Clients_Master
 * @subpackage Breizh_Buzz_Clients_Master/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Breizh_Buzz_Clients_Master
 * @subpackage Breizh_Buzz_Clients_Master/includes
 * @author     LAURENT Patrice <dede@yopmail.com>
 */
class Breizh_Buzz_Clients_Master_i18n {


	/**
	 * Load the plugin text domain for translation.
	 *
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain() {

		load_plugin_textdomain(
			'breizh-buzz-clients-master',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}



}
