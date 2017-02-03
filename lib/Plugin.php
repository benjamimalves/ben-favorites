<?php

namespace Ben\WP\Favorites;

class Plugin {
	public function run() {
		if ( \is_admin() ) {
			
			\add_action( 'admin_menu', 						'\Ben\WP\Favorites\FavoritesInterface::admin_menu' );
			\add_action( 'admin_post_nopriv_favorite_form',	'\Ben\WP\Favorites\FavoritesInterface::on_save' );
			\add_action( 'admin_post_favorite_form', 		'\Ben\WP\Favorites\FavoritesInterface::on_save' );

		} else {

			\add_shortcode( 'favorites_render_button', 	'\Ben\WP\Favorites\FavoritesShortcode::add_button' );
			\add_shortcode( 'favorites_render_list', 	'\Ben\WP\Favorites\FavoritesShortcode::show_user_favorites' );

			\add_filter( 'the_content', 				'\Ben\WP\Favorites\FavoritesHook::render_content' );

			\add_action( 'wp_print_scripts', 			'\Ben\WP\Favorites\FavoritesHook::print_scripts' );


			\Ben\WP\Favorites\FavoritesRoutes::run();
		}

		\add_action( 'widgets_init', 	create_function('', 'return register_widget("\Ben\WP\Favorites\FavoritesWidget");'));
	}
}
