<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       http://www.patricelaurent.net
 * @since      1.0.0
 *
 * @package    Breizh_Buzz_Clients_Master
 * @subpackage Breizh_Buzz_Clients_Master/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Breizh_Buzz_Clients_Master
 * @subpackage Breizh_Buzz_Clients_Master/includes
 * @author     LAURENT Patrice <dede@yopmail.com>
 */
class Breizh_Buzz_Clients_Master {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Breizh_Buzz_Clients_Master_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->plugin_name = 'breizh-buzz-clients-master';
		$this->version = '2.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Breizh_Buzz_Clients_Master_Loader. Orchestrates the hooks of the plugin.
	 * - Breizh_Buzz_Clients_Master_i18n. Defines internationalization functionality.
	 * - Breizh_Buzz_Clients_Master_Admin. Defines all hooks for the admin area.
	 * - Breizh_Buzz_Clients_Master_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-breizh-buzz-clients-master-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-breizh-buzz-clients-master-i18n.php';

		/**
		 * The class responsible for the update from GitHub
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/updater.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-breizh-buzz-clients-master-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-breizh-buzz-clients-master-public.php';



		$this->loader = new Breizh_Buzz_Clients_Master_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Breizh_Buzz_Clients_Master_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Breizh_Buzz_Clients_Master_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Breizh_Buzz_Clients_Master_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_filter( 'tiny_mce_before_init', $plugin_admin, 'breizhbuzz_custom_tinymce' );
		$this->loader->add_filter( 'default_hidden_meta_boxes', $plugin_admin, 'breizhbuzz_hidden_meta_boxes' ,10,2);
		$this->loader->add_filter( 'tiny_mce_before_init', $plugin_admin, 'breizhbuzz_enhance_editor' );
		$this->loader->add_filter( 'mce_buttons_2', $plugin_admin, 'bbz_mce_buttons' );
		//$this->loader->add_action('welcome_panel', $plugin_admin, 'breizhbuzz_remove_meta_boxes',10,2);
		$this->loader->add_filter( 'admin_menu', $plugin_admin, 'breizhbuzz_remove_version_footer' );
		$this->loader->add_filter( 'admin_footer_text', $plugin_admin, 'breizhbuzz_remove_footer_admin' );
		$this->loader->add_action( 'wp_dashboard_setup', $plugin_admin, 'breizhbuzz_add_dashboard_widgets' );
		$this->loader->add_action( 'wp_dashboard_setup', $plugin_admin, 'breizhbuzz_remove_dashboard_widgets' );
		$this->loader->add_action( 'admin_bar_menu', $plugin_admin, 'breizhbuzz_remove_wp_logo',999 );
		$this->loader->add_action( 'admin_bar_menu', $plugin_admin, 'bbz_link_to_mypage',999 );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'allowMenuEditor' );
		//YOAST
		$this->loader->add_filter( 'wpseo_use_page_analysis',$plugin_admin, 'disable_wpseo_use_page_analysis' );
		$this->loader->add_filter( 'wpseo_metabox_prio',$plugin_admin, 'breizhbuzz_yoast_bottom' );
		$this->loader->add_action( 'admin_init',$plugin_admin, 'seo_bbz_ignore_tour' ,999);
		$this->loader->add_action( 'admin_bar_menu',$plugin_admin, 'bbz_seo_remove_adminbar_settings' ,999);
		//JetPack
		$this->loader->add_filter( 'jetpack_get_default_modules',$plugin_admin, 'bbz_auto_activate_stats' );
		$this->loader->add_filter( 'jetpack_get_available_modules',$plugin_admin, 'bbz_allow_jetpack_modules' );
		$this->loader->add_action( 'admin_menu',$plugin_admin, 'bbz_jetpack_rm_menu' );
		$this->loader->add_action( 'admin_head',$plugin_admin, 'bbz_jetpack_rm_icon' );


		$config = array(
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
new WP_GitHub_Updater($config);

}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Breizh_Buzz_Clients_Master_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'login_head', $plugin_public, 'bbz_custom_login' );
		$this->loader->add_filter( 'login_headerurl', $plugin_public, 'bbz_url_login' );
		$this->loader->add_filter( 'login_headertitle', $plugin_public, 'bbz_login_logo_url_title' );
		//$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		//$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Breizh_Buzz_Clients_Master_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
