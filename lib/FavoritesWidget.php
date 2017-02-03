<?php

namespace Ben\WP\Favorites;

use Ben\WP\Favorites\FavoritesHook;

class FavoritesWidget extends \WP_Widget {

	public function __construct(){

		$widget_ops = array( 
			'classname' => 'Favorites',
			'description' => 'List Current User Favorites',
		);
		parent::__construct( 'favorites_widget', 'Favorites Widget', $widget_ops );
	}

	public function form ( $instance ){	

		if( $instance ) {
			$title 		= \esc_attr( $instance['title'] );
			$text 		= \esc_attr( $instance['text'] );
		} else {
			$title 		= \__('My favorites posts', 'favorites');
			$text 		= \__('I saved this posts', 'favorites');
		}

		// Title
		echo '<p>';
			printf(
				'<label for="%s">%s</label>',
				$this->get_field_id('title'),
				\__('Widget Title', 'favorites')
			);
			printf(
				'<input class="widefat" id="%s" name="%s" type="text" value="%s" />',
				$this->get_field_id('title'),
				$this->get_field_name('title'),
				$title
			);
		echo '</p>';

		// Text
		echo '<p>';
			printf(
				'<label for="%s">%s</label>',
				$this->get_field_id('text'),
				\__('Widget text', 'favorites')
			);
			printf(
				'<input class="widefat" id="%s" name="%s" type="text" value="%s" />',
				$this->get_field_id('text'),
				$this->get_field_name('text'),
				$text
			);
		echo '</p>';
	}

	public function update ( $new_instance, $old_instance ){

		$instance = $old_instance;

		$instance['title'] 	= strip_tags( $new_instance['title'] );
		$instance['text'] 	= strip_tags( $new_instance['text'] );
		return $instance;
	}

	public function widget( $args, $instance ){

		extract( $args );

		$title 				= apply_filters('widget_title', $instance['title']);
		$text 				= $instance['text'];
		$user_id 			= \get_current_user_id();
		$user_favorites 	= FavoritesHook::get_user_favorites( $user_id );

		echo $before_widget;
			echo '<div class="widget-text wp_widget_plugin_box">';

				if ( $title ) {
					echo $before_title . $title . $after_title;
				}

				if( $text ) {
					echo '<p class="wp_widget_plugin_text">'.$text.'</p>';
				}

				if ( $user_favorites && count( $user_favorites ) > 0 ){
					echo '<ul class="wp_widget_plugin_list_favorites">';
						foreach ( $user_favorites as $favorite ) {
							echo '<li>';
								echo '<a href="' . get_the_permalink( $favorite ) . '">';
									echo get_the_title( $favorite );
								echo '</a>';
							echo '</li>';
						}
					echo '</ul>';
				} else {
					'<p>' . \__('No favorite found yet.') . '</p>';
				}

			echo '</div>';
		echo $after_widget;
	}
}