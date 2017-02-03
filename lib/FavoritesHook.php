<?php

namespace Ben\WP\Favorites;

use Ben\WP\Favorites\FavoritesShortcode;

class FavoritesHook {

	public static function get_favorites_display_options() {
		return \get_option('favorites_display');
	}

	public static function render_content( $content ) {
		
		if ( is_single() ) {
			$new_content = static::render_button_before_content();
			$new_content .= $content;
			$new_content .= static::render_button_after_content();

			return $new_content;
		} else {

			return $content;
		}
	}

	public static function render_button_before_content( ) {
		$favorites_display_options = static::get_favorites_display_options();
		
		if ( $favorites_display_options['before_content'] ) {

			return \do_shortcode( '[favorites_render_button]' );
		}
	}

	public static function render_button_after_content( ) {
		$favorites_display_options = static::get_favorites_display_options();
		
		if ( $favorites_display_options['after_content'] ) {

			return \do_shortcode( '[favorites_render_button]' );
		}
	}

	public static function get_user_favorites( $user_id ) {
		$user_favorites = get_user_meta($user_id, 'user_favorites', true);

		if ( ! $user_favorites ){
			return array();
		}

		return $user_favorites;
	}

	public static function add_favorites_to_user( $request ) {
		$params 		= $request->get_params();
		$user_favorites = static::get_user_favorites( $params['userid'] );

		if ( ! in_array( $params['postid'], $user_favorites ) )	{
			array_push( $user_favorites, $params['postid'] );
			static::update_favorites_to_user( $params['userid'], $user_favorites );
		}

		die();
	}

	public static function delete_favorites_to_user( $request ) {
		$params 		= $request->get_params();
		$user_favorites = static::get_user_favorites( $params['userid'] );

		if ( in_array( $params['postid'], $user_favorites ) )	{
			$value_in_key = array_search( $params['postid'], $user_favorites );
			unset( $user_favorites[$value_in_key] );
			static::update_favorites_to_user( $params['userid'], $user_favorites );
		}
		
		die();
	}

	protected function update_favorites_to_user( $user_id, $args ) {
		update_user_meta($user_id, 'user_favorites', $args);
	}

	public static function print_scripts(){
		$favorites_display_options = FavoritesHook::get_favorites_display_options();

		wp_register_script('favorite-js', plugins_url('assets/js/favorites.js', __FILE__), 'jquery', '1.0.0', true);
		wp_enqueue_script('favorite-js');

		if ( $favorites_display_options['include_css'] ){
			wp_enqueue_style( 'favorite-css', plugins_url('assets/css/favorites.css', __FILE__), array(), '1.0.0', 'all' );
		}
	}
}