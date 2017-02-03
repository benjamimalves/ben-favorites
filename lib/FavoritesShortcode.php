<?php

namespace Ben\WP\Favorites;

use Ben\WP\Favorites\FavoritesHook;

class FavoritesShortcode {

	public static function add_button( ) {
		$favorites_display_options = FavoritesHook::get_favorites_display_options();

		if ( ! $favorites_display_options['button_text_add'] || ! $favorites_display_options['button_text_delete'] ) {
			return false;
		}

		$current_post_id 	= get_the_ID();
		$user_id 			= \get_current_user_id();
		$user_favorites 	= FavoritesHook::get_user_favorites( $user_id );

		if ( in_array( $current_post_id, $user_favorites ) ){
			$button_class 	= 'favorite_button_delete';
			$button_url 	= home_url( 'wp-json/favorites/delete/' . $current_post_id . '/' . $user_id );
			$button_label 	= $favorites_display_options['button_text_delete'];
		} else {
			$button_class 	= 'favorite_button_add';
			$button_url 	= home_url( 'wp-json/favorites/add/' . $current_post_id . '/' . $user_id );
			$button_label 	= $favorites_display_options['button_text_add'];
		}

		return '<a href="#' . $button_class . '" data-url="' . $button_url . '" class="favorite_button ' . $button_class . '">' . $button_label . '</a>';
	}

	public static function show_user_favorites( ) {
		$current_post_id 	= get_the_ID();
		$user_id 			= \get_current_user_id();
		$user_favorites 	= FavoritesHook::get_user_favorites( $user_id );

		$short_html = '';
		if ( $user_favorites && count( $user_favorites ) > 0 ){
			$short_html .= '<section>';
				$short_html .= '<h2>' . \__('My Favorites', 'favorites') . '</h2>';
				$short_html .= '<ul>';
					foreach ( $user_favorites as $favorite ) {
						$short_html .= '<li>';
							$short_html .= '<a href="' . get_the_permalink( $favorite ) . '">';
								$short_html .= get_the_title( $favorite );
							$short_html .= '</a>';
						$short_html .= '</li>';
					}
				$short_html .= '</ul>';
			$short_html .= '</section>';
		}
		return $short_html;
	}
}