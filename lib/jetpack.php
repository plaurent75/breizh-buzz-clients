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

add_filter( 'jetpack_get_available_modules', 'prefix_hide_jetpack_modules' );
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
function prefix_hide_jetpack_modules( $modules ) {
	// A list of Jetpack modules which are allowed to activate.
	$whitelist = array(
		'carousel',
		'comments',
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
