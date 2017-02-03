<?php

namespace Ben\WP\Favorites;

use Ben\WP\Favorites\FavoritesHook;

class FavoritesRoutes {
	public static $current_user_id;

	public static function run() {
		$user_id = \get_current_user_id();
		static::$current_user_id = $user_id;
		static::register_api_routes();
	}

	protected function register_api_routes() {
		\add_action( 'rest_api_init', '\Ben\WP\Favorites\FavoritesRoutes::route_add_favorites_to_user' );
		\add_action( 'rest_api_init', '\Ben\WP\Favorites\FavoritesRoutes::route_delete_favorites_to_user' );
	}

	public static function route_add_favorites_to_user( ) {

		register_rest_route( 'favorites', '/add/(?P<postid>\d+)/(?P<userid>\d+)', array(
			'methods' 	=> 'GET',
			'callback' 	=> '\Ben\WP\Favorites\FavoritesHook::add_favorites_to_user',
			'args' 		=> array(
								'postid' => array(
									'validate_callback' => function($param, $request, $key) {
										return is_numeric( $param );
									}
								),
								'userid' => array(
									'validate_callback' => function($param, $request, $key) {
										if ( static::$current_user_id !== intval( $param ) ){
											die();
										} 
										return is_numeric( $param );
									}
								)
							),
						) );
	}

	public static function route_delete_favorites_to_user( ) {

		register_rest_route( 'favorites', '/delete/(?P<postid>\d+)/(?P<userid>\d+)', array(
			'methods' 	=> 'GET',
			'callback' 	=> '\Ben\WP\Favorites\FavoritesHook::delete_favorites_to_user',
			'args' 		=> array(
								'postid' => array(
									'validate_callback' => function($param, $request, $key) {
										return is_numeric( $param );
									}
								),
								'userid' => array(
									'validate_callback' => function($param, $request, $key) {
										if ( static::$current_user_id !== intval( $param ) ){
											die();
										} 
										return is_numeric( $param );
									}
								)
							),
						) );
	}
}