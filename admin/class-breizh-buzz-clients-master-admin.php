<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://www.patricelaurent.net
 * @since      1.0.0
 *
 * @package    Breizh_Buzz_Clients_Master
 * @subpackage Breizh_Buzz_Clients_Master/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Breizh_Buzz_Clients_Master
 * @subpackage Breizh_Buzz_Clients_Master/admin
 * @author     LAURENT Patrice <dede@yopmail.com>
 */
class Breizh_Buzz_Clients_Master_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

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

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/breizh-buzz-clients-master-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
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

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/breizh-buzz-clients-master-admin.js', array( 'jquery' ), $this->version, false );

	}

	// Hide TITLE 1 (NO H1 allowed)
	public function breizhbuzz_custom_tinymce($init) {

		$init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Preformated=pre';
		return $init;
	}

	//hide some metabox in post/page
	public function breizhbuzz_hidden_meta_boxes($hidden, $screen) {
		if ( 'post' == $screen->base || 'page' == $screen->base ):
			$hidden = array('trackbacksdiv', 'commentstatusdiv', 'postcustom', 'commentsdiv', 'revisionsdiv');
		// showed : postexcerpt
		endif;
		return $hidden;
	}

	// Force activate 2nd line editor
	public function breizhbuzz_enhance_editor($in) {

		$in['wordpress_adv_hidden'] = FALSE;

		return $in;
	}

	// Enable font size & font family selects in the editor
	function bbz_mce_buttons( $buttons ) {
		array_unshift( $buttons, 'fontselect' ); // Add Font Select
		array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
		return $buttons;
	}

	// Hide some widget box for home admin
	public function breizhbuzz_remove_meta_boxes() {
		remove_meta_box('dashboard_primary', 'dashboard', 'normal');
	}

	// Remove Version in footer
	public function breizhbuzz_remove_version_footer() {
		remove_filter( 'update_footer', 'core_update_footer' );
	}

	public function breizhbuzz_remove_footer_admin() {
		return 'Site réalisé par <a href="http://breizhbuzz.com" target="_blank">Breizh Buzz</a> | <a target="_blank" href="http://support.breizhbuzz.com">Support & Services Clients</a> | support par email : <a href="mailto:supportbbz@breizhbuzz.com">supportbbz@breizhbuzz.com</a>';
	}

	// Display BreizhBuzz Widget
	public function breizhbuzz_dashboard_widget()
	{
	//get RSS from Breizhbuzz.com
		$value = "http://breizhbuzz.com/feed/?cat=22";

		wp_widget_rss_output(array(
			'url' => $value,
			'items' => 5,
			'show_summary' => 1
			));
	}
	public function breizhbuzz_add_dashboard_widgets() {
		add_meta_box('breizhbuzz_summary_dashboard_widget', 'Informations Breizh Buzz', array($this,'breizhbuzz_dashboard_widget'),'dashboard','side','high');
	}

	//Disable Some Widget
	public function breizhbuzz_remove_dashboard_widgets() {
		global $wp_meta_boxes;
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press']);
		//unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_incoming_links']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_plugins']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_drafts']);
		unset($wp_meta_boxes['dashboard']['normal']['core']['dashboard_recent_comments']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']);
		unset($wp_meta_boxes['dashboard']['side']['core']['dashboard_secondary']);
		remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );
	}

	//Remove elements from WordPress admin bar
	public function breizhbuzz_remove_wp_logo( $wp_admin_bar ) {
		$wp_admin_bar->remove_node( 'wp-logo' );
		$wp_admin_bar->remove_menu('wpseo-menu');
	}

	public function bbz_link_to_mypage( $wp_admin_bar ) {
		$args = array(
			'id'    => 'bbz_site',
			'title' => '<img src="'.plugin_dir_url( __FILE__ ) . 'css/images/bbz-hand.png" width="16px" height="16px" />&nbsp;Breizh Buzz // SERVICES&nbsp;&#9660;',
			);
		$wp_admin_bar->add_node( $args );
		$wp_admin_bar->add_node( $this->bbz_make_parent_node('support','Support et Service Clients','http://support.breizhbuzz.com') );
		$wp_admin_bar->add_node( $this->bbz_make_parent_node('support_mail','Contactez nous par email','mailto:supportbbz@breizhbuzz.com') );
		$wp_admin_bar->add_node( $this->bbz_make_parent_node('cloozi','Cloozi : Plateforme Collaborative','http://www.cloozi.com') );
		$wp_admin_bar->add_node( $this->bbz_make_parent_node('site_url','BreizhBuzz.com','http://breizhbuzz.com') );

	}

	public function bbz_make_parent_node( $id='',$title,$href='',$parent='bbz_site' ) {
		$args = array(
			'id'     => $id,
			'title'  => $title,
			'href'  => $href,
			'meta'  => array( 'target' => 'blank' ),
			'parent' => $parent
			);
		return $args;
	}

	//Give More rights To Editor
	public function allowMenuEditor() {

		global $wp_admin_bar;
		$role_object=get_role('editor');

		if (!$role_object->has_cap( 'edit_theme_options' ) )
		{
			$role_object->add_cap('edit_theme_options');
			remove_submenu_page('themes.php','themes.php' );
			remove_submenu_page('themes.php','theme-editor.php' );
		}

	}

	// Remove Settings submenu in admin bar
	// also shows how to remove other menus
	// @since 1.3 - inspired by [Lee Rickler](https://profiles.wordpress.org/lee-rickler/)
	public function bbz_seo_remove_adminbar_settings() {
		global $wp_admin_bar;
		// remove the entire menu
		//$wp_admin_bar->remove_node( 'wpseo-menu' );
		// remove WordPress SEO Settings
		$wp_admin_bar->remove_node( 'wpseo-settings' );
		// remove keyword research information
		//$wp_admin_bar->remove_node( 'wpseo-kwresearch' );
	}

	/**
	* YOAST
	*/

	//Yoast Metabox at bottom
	public function breizhbuzz_yoast_bottom() {
		return 'low';
	}

	public function seo_bbz_ignore_tour() {
		update_user_meta( get_current_user_id(), 'wpseo_ignore_tour', true );
	}

	public function disable_wpseo_use_page_analysis(){
		return false;
	}

	/********************************************************
	* Jetpack
	*********************************************************/

	//Activate only this Jetpack's Modules
	public function bbz_auto_activate_stats() {
		return array( 'protect','publicize','related-posts','sharedaddy','widgets','manage' );
	}

	//hide the unwanted modules
	public function bbz_allow_jetpack_modules( $modules ) {
	// A list of Jetpack modules which are allowed to activate.
		$whitelist = array(
			'carousel',
			'comments',
			'contact-form',
			'enhanced-distribution',
			'photon',
			'protect',
			'publicize',
			'related-posts',
			'sharedaddy',
			'subscriptions',
			'tiled-gallery',
			'widget-visibility',
			'widgets',
			'manage',
			);
		return array_intersect_key( $modules, array_flip( $whitelist ) );
	}

	//Jetpack Only for Admin
	public function bbz_jetpack_rm_menu() {
		remove_menu_page( 'tools.php' );
	if( class_exists( 'Jetpack' ) && !current_user_can( 'manage_options' ) ) {

		// This removes the page from the menu in the dashboard
		remove_menu_page( 'jetpack' );
		remove_submenu_page( 'admin.php','sharing' );
		remove_submenu_page( 'options-general.php','sharing' );
		}
	}

	function bbz_jetpack_rm_icon() {
	if( class_exists( 'Jetpack' ) && !current_user_can( 'manage_options' ) ) {

		// This removes the small icon in the admin bar
		echo "\n" . '<style type="text/css" media="screen">#wp-admin-bar-notes { display: none; }</style>' . "\n";
		}
	}
}
