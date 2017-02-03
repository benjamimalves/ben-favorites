<?php

namespace Ben\WP\Favorites;

class Activator {
	/**
	 * Setups Wordpress,
	 * Should be called on plugin activation
	 * @return void
	 */
	public static function activate() {
		static::setup_options();
	}

	/**
	 * Setup wordpress options
	 * @return void
	 */
	protected static function setup_options() {
		if ( ! get_option('favorites_display') && "" !== get_option('favorites_display') ){
			$favorites_display_opts = array(
										'button_text_add' 		=> \__('Add Favorite', 'favorites'),
										'button_text_delete' 	=> \__('Remove Favorite', 'favorites'),
										'before_content' 		=> 1,
										'after_content' 		=> 1,
										'include_css' 			=> 1
									);
			\update_option( 'favorites_display', $favorites_display_opts );
		}
	}
}