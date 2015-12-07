<?php
/*
 * Plugin Name: Breizh Buzz Clients
 * Plugin URI: http://breizhbuzz.com
 * Description: Fonctionnalité et filtre pour les sites clients de Breizh Buzz
 * Author: Patrice LAURENT
 * Author URI: http://www.patricelaurent.net
 * Version: 1.1
 */
include_once('lib/updater.php');
if (is_admin()) { 
// note the use of is_admin() to double check that this is happening in the admin
	$config = array(
            'slug' => plugin_basename(__FILE__), // this is the slug of your plugin
            'proper_folder_name' => 'breizh-buzz-clients', // this is the name of the folder your plugin lives in
            'api_url' => 'https://api.github.com/repos/plaurent75/breizh-buzz-clients', // the GitHub API url of your GitHub repo
            'raw_url' => 'https://raw.github.com/plaurent75/breizh-buzz-clients/master', // the GitHub raw url of your GitHub repo
            'github_url' => 'https://github.com/plaurent75/breizh-buzz-clients', // the GitHub url of your GitHub repo
            'zip_url' => 'https://github.com/plaurent75/breizh-buzz-clients/zipball/master', // the zip url of the GitHub repo
            'sslverify' => true, // whether WP should check the validity of the SSL cert when getting an update, see https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/2 and https://github.com/jkudish/WordPress-GitHub-Plugin-Updater/issues/4 for details
            'requires' => '4.0', // which version of WordPress does your plugin require?
            'tested' => '4.31', // which version of WordPress is your plugin tested up to?
            'readme' => 'README.md', // which file to use as the readme for the version number
            'access_token' => ''
            );
new WP_GitHub_Updater($config);
}

/********************************************************
* Jetpack Publicize
*********************************************************/

// HashTags


//add_filter( 'wpas_default_suffix', 'breizhbuzz_default_publicize_hashtag_suffix', 10, 4 );
function breizhbuzz_default_publicize_hashtag_suffix() {
	$default_tags = ' #rosporden';
	return $default_tags;
}


/********************************************************
* ADMIN
*********************************************************/

// Hide TITLE 1 (NO H1 allowed)

function breizhbuzz_custom_tinymce($init) {

	$init['block_formats'] = 'Paragraph=p;Heading 2=h2;Heading 3=h3;Heading 4=h4;Preformated=pre';
	return $init;

}
add_filter('tiny_mce_before_init', 'breizhbuzz_custom_tinymce' );

// Hide some widget box for home admin
remove_action('welcome_panel', 'breizhbuzz_remove_meta_boxes');

function breizhbuzz_remove_meta_boxes() {
	remove_meta_box('dashboard_primary', 'dashboard', 'normal');
}

//hide some metabox in post/page
function breizhbuzz_hidden_meta_boxes($hidden, $screen) {
	if ( 'post' == $screen->base || 'page' == $screen->base ):
		$hidden = array('slugdiv', 'trackbacksdiv', 'commentstatusdiv', 'postcustom', 'commentsdiv', 'authordiv', 'revisionsdiv');
		// showed : postexcerpt
	endif;
	return $hidden;
}
add_filter('default_hidden_meta_boxes', 'breizhbuzz_hidden_meta_boxes', 10, 2);

// Force activate 2nd line editor
function breizhbuzz_enhance_editor($in) {

	$in['wordpress_adv_hidden'] = FALSE;

	return $in;
}
add_filter('tiny_mce_before_init', 'breizhbuzz_enhance_editor');

// Remove Version in footer
function breizhbuzz_remove_version_footer() {
	remove_filter( 'update_footer', 'core_update_footer' );
}
add_action( 'admin_menu', 'breizhbuzz_remove_version_footer' );

function breizhbuzz_remove_footer_admin() {
	return 'Site réalisé par <a href="http://breizhbuzz.com" target="_blank">Breizh Buzz</a> | <a target="_blank" href="http://support.breizhbuzz.com">Support & Services Clients</a> | support par email : <a href="mailto:supportbbz@breizhbuzz.com">supportbbz@breizhbuzz.com</a>';
}
add_filter('admin_footer_text', 'breizhbuzz_remove_footer_admin');

//favicon dans l'admin
function breizhbuzz_admin_favicon() {
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_stylesheet_directory_uri().'/dist/images/favicon.png" />';
}
add_action('admin_head', 'breizhbuzz_admin_favicon');

// Display BreizhBuzz Widget
function breizhbuzz_dashboard_widget()
{
	//get RSS from Breizhbuzz.com
	$value = "http://breizhbuzz.com/feed/?cat=22";

	wp_widget_rss_output(array(
		'url' => $value,
		'items' => 5,
		'show_summary' => 1
		));
}
function breizhbuzz_add_dashboard_widgets() {
	wp_add_dashboard_widget('breizhbuzz_summary_dashboard_widget', 'Informations Breizh Buzz', 'breizhbuzz_dashboard_widget');
}
add_action('wp_dashboard_setup', 'breizhbuzz_add_dashboard_widgets' );

//Disable Some Widget
function breizhbuzz_remove_dashboard_widgets() {
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
add_action('wp_dashboard_setup', 'breizhbuzz_remove_dashboard_widgets' );

//Remove elements from WordPress admin bar
add_action( 'admin_bar_menu', 'breizhbuzz_remove_wp_logo', 999 );
function breizhbuzz_remove_wp_logo( $wp_admin_bar ) {
	$wp_admin_bar->remove_node( 'wp-logo' );
	$wp_admin_bar->remove_menu('wpseo-menu');

}

//ADD Our Own element to admin Bar
add_action( 'admin_bar_menu', 'bbz_link_to_mypage', 999 );

function bbz_link_to_mypage( $wp_admin_bar ) {
	$args = array(
		'id'    => 'bbz_site',
		'title' => 'Breizh Buzz',
		'href'  => 'http://breizhbuzz.com',
		'meta'  => array( 'target' => 'blank' )
		);
	$wp_admin_bar->add_node( $args );
	$wp_admin_bar->add_node( bbz_make_parent_node('support','Support et Service Clients','http://support.breizhbuzz.com') );
	$wp_admin_bar->add_node( bbz_make_parent_node('support_mail','Contactez nous par email','mailto:supportbbz@breizhbuzz.com') );
}

function bbz_make_parent_node( $id='',$title,$href='',$parent='bbz_site' ) {
	$args = array(
		'id'     => $id, 
		'title'  => $title, 
		'href'  => $href,
		'meta'  => array( 'target' => 'blank' ),
		'parent' => $parent
		);
	return $args;
}

// Enable font size & font family selects in the editor
function bbz_mce_buttons( $buttons ) {
		array_unshift( $buttons, 'fontselect' ); // Add Font Select
		array_unshift( $buttons, 'fontsizeselect' ); // Add Font Size Select
		return $buttons;
	}

	add_filter( 'mce_buttons_2', 'bbz_mce_buttons' );


/********************************************************
* TOOLS
*********************************************************/

// retirer accent des url des images
add_filter( 'sanitize_file_name', 'remove_accents' );

//Remove Get Shortlink
add_filter( 'pre_get_shortlink', '__return_empty_string' );

//Custom CSS Login
function bbz_custom_login() {
	wp_enqueue_style( 'bbz-custom-login-css', plugins_url('css/login.css', __FILE__));
}
add_action('login_head', 'bbz_custom_login');
//Custom Logo URL
function bbz_url_login(){
	return 'http://breizhbuzz.com';
}
add_filter('login_headerurl', 'bbz_url_login');
//Custom Logo Title
function bbz_login_logo_url_title() {
	return 'Une création BreizhBuzz.com';
}
add_filter( 'login_headertitle', 'bbz_login_logo_url_title' );

//Give More rights To Editor

function allowMenuEditor() {

	global $wp_admin_bar;
	$role_object=get_role('editor');

	if (!$role_object->has_cap( 'edit_theme_options' ) )
	{
		$role_object->add_cap('edit_theme_options');
		remove_submenu_page('themes.php','themes.php' );
		remove_submenu_page('themes.php','theme-editor.php' );
	}

}
add_action('admin_init','allowMenuEditor');

/**
* YOAST
*/

//disable yoast informations in admin post

add_filter( 'wpseo_use_page_analysis', '__return_false' );

//Yoast Metabox at bottom

function breizhbuzz_yoast_bottom() {
	return 'low';
}
add_filter( 'wpseo_metabox_prio', 'breizhbuzz_yoast_bottom');

function seo_bbz_ignore_tour() {
	update_user_meta( get_current_user_id(), 'wpseo_ignore_tour', true );
}
add_action( 'admin_init', 'seo_bbz_ignore_tour', 999 ); // since 1.4

// Remove Settings submenu in admin bar
// also shows how to remove other menus
// @since 1.3 - inspired by [Lee Rickler](https://profiles.wordpress.org/lee-rickler/)
function bbz_seo_remove_adminbar_settings() {
	global $wp_admin_bar;
	// remove the entire menu
	//$wp_admin_bar->remove_node( 'wpseo-menu' );
	// remove WordPress SEO Settings
	$wp_admin_bar->remove_node( 'wpseo-settings' );
	// remove keyword research information
	//$wp_admin_bar->remove_node( 'wpseo-kwresearch' );
}
add_action( 'admin_bar_menu', 'bbz_seo_remove_adminbar_settings', 999 ); // since 1.3
