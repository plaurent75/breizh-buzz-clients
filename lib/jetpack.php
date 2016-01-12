<?php
/********************************************************
* Jetpack Publicize
*********************************************************/

// HashTags


//add_filter( 'wpas_default_suffix', 'breizhbuzz_default_publicize_hashtag_suffix', 10, 4 );
function breizhbuzz_default_publicize_hashtag_suffix() {
	$default_tags = ' #rosporden';
	return $default_tags;
}

/**
* Activate only this Jetpack's Modules
*/

function bbz_auto_activate_stats() {
    return array( 'protect','publicize','related-posts','sharedaddy','widgets' );
}
add_filter( 'jetpack_get_default_modules', 'bbz_auto_activate_stats' );

/**
* Just hide the unwanted modules
*/

add_filter( 'jetpack_get_available_modules', 'prefix_allow_jetpack_modules' );
/**
* Disable all non-whitelisted jetpack modules.
*
* As it's written, this will allow all of the currently available Jetpack
* modules to work display and be activated normally.
*
* If there's a module you'd like to disable, simply comment it out or remove it
* from the whitelist and it will no longer be available for activation.
*
* @author WP Site Care
* @link   http://www.wpsitecare.com/disable-jetpack-modules/
* @param  array $modules the existing list of Jetpack modules
* @return array $modules the amended list of Jetpack modules
*/
function prefix_allow_jetpack_modules( $modules ) {
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
	);
	return array_intersect_key( $modules, array_flip( $whitelist ) );
}

/**
* Jetpack Only for Admin
*/

function bbz_jetpack_rm_menu() {
	if( class_exists( 'Jetpack' ) && !current_user_can( 'manage_options' ) ) {

		// This removes the page from the menu in the dashboard
		remove_menu_page( 'jetpack' );
		remove_submenu_page( 'admin.php','sharing' );
		remove_submenu_page( 'options-general.php','sharing' );
		remove_menu_page( 'tools.php' );
	}
}
add_action( 'admin_init', 'bbz_jetpack_rm_menu' );

function bbz_jetpack_rm_icon() {
	if( class_exists( 'Jetpack' ) && !current_user_can( 'manage_options' ) ) {

		// This removes the small icon in the admin bar
		echo "\n" . '<style type="text/css" media="screen">#wp-admin-bar-notes { display: none; }</style>' . "\n";
	}
}
add_action( 'admin_head', 'bbz_jetpack_rm_icon' );
