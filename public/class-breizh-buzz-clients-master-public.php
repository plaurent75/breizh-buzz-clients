<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://www.patricelaurent.net
 * @since      1.0.0
 *
 * @package    Breizh_Buzz_Clients_Master
 * @subpackage Breizh_Buzz_Clients_Master/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Breizh_Buzz_Clients_Master
 * @subpackage Breizh_Buzz_Clients_Master/public
 * @author     LAURENT Patrice <dede@yopmail.com>
 */
class Breizh_Buzz_Clients_Master_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}


	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Breizh_Buzz_Clients_Master_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Breizh_Buzz_Clients_Master_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/breizh-buzz-clients-master-public.js', array( 'jquery' ), $this->version, false );

	}

	//Custom CSS Login
	public function bbz_custom_login() {
		wp_enqueue_style( 'bbz-custom-login-css', plugin_dir_url( __FILE__ ) . 'css/login.css');
	}

	//Custom Logo URL
	public function bbz_url_login(){
		return 'http://breizhbuzz.com';
	}

	//Custom Logo Title
	public function bbz_login_logo_url_title() {
		return 'Une création BreizhBuzz.com';
	}

}
