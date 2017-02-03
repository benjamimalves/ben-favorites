<?php
/* 
Plugin Name: User Favorite Posts
Plugin URI: http://www.benjamimalves.com
Description: Plugin to add favorite button to posts
Version: 1.0.0 
Author: Benjamim Alves
Author URI: http://www.benjamimalves.com 
License: GPLv2 or later.
*/

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Autoload Composer dependencies, if found:
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

\register_activation_hook( __FILE__, '\Ben\WP\Favorites\Activator::activate' );

/**
 * Begins execution of the plugin.
 *
 * @since    1.0.0
 */
\add_action( 'plugins_loaded', function () {
	$plugin = new \Ben\WP\Favorites\Plugin();
	$plugin->run();
} );
?>