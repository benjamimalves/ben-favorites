<?php

namespace Ben\WP\Favorites;

use Ben\WP\Favorites\FavoritesHook;

class FavoritesInterface {
	public static function admin_menu() {
		\add_menu_page('Favorites', 'Favorites', 7, __FILE__, '\Ben\WP\Favorites\FavoritesInterface::set_panel' );
	}

	public static function set_panel() {
		$favorites_display_options = FavoritesHook::get_favorites_display_options();
		echo '<div id="favorites-panel" class="wrap">';
			printf(
				'<h2>%s</h2>',
				__('Favorites options', 'favorites')
			);
			echo '<div id="dashboard-widgets-wrap">';
				echo '<div id="dashboard-widgets" class="metabox-holder columns-1">';
					echo '<div class="postbox-container">';
						echo '<div class="meta-box-sortables ui-sortable">';
							echo '<div id="dashboard_right_now" class="postbox" style="padding: 20px;">';
								if ( isset( $_GET['success'] ) ){
									echo '<div id="message" class="updated notice notice-success is-dismissible"><p>' . \__('Options saved sucessfully.', 'favorites') . '</p></div>';
								}
								echo '<form action="' . esc_url( admin_url('admin-post.php') ) . '" method="post">';
									echo '<input type="hidden" name="action" value="favorite_form">';
									// Button text
									echo '<div class="inside">';
										printf(
											'<h4>%s</h4>',
											__('Insert the text for your add button', 'favorites')
										);
										printf(
											'<p><input type="text" name="button_text_add" value="%s" style="width:400px;" /></p>',
											\esc_html( $favorites_display_options['button_text_add'] )
										);
										printf(
											'<h4>%s</h4>',
											__('Insert the text for your delete button', 'favorites')
										);
										printf(
											'<p><input type="text" name="button_text_delete" value="%s" style="width:400px;" /></p>',
											\esc_html( $favorites_display_options['button_text_delete'] )
										);
									echo '</div>';
									echo '<hr/>';
									// Button place
									echo '<div class="inside">';
										printf(
											'<h4>%s</h4>',
											__('Where do you want to put the button', 'favorites')
										);
										printf(
											'<p><input id="before_content" name="before_content" type="checkbox" value="1" %s /><label for="before_content">%s</label></p>',
											\checked( $favorites_display_options['before_content'], true, false ),
											\__('Before content', 'favorites')
										);
										printf(
											'<p><input id="after_content" name="after_content" type="checkbox" value="1" %s /><label for="after_content">%s</label></p>',
											\checked( $favorites_display_options['after_content'], true, false ),
											\__('After content', 'favorites')
										);
									echo '</div>';
									echo '<hr/>';
									// Button CSS
									echo '<div class="inside">';
										printf(
											'<h4>%s</h4>',
											__('If you want our button style leave the checkbox bellow checked', 'favorites')
										);
										printf(
											'<p><input id="include_css" name="include_css" type="checkbox" value="1" %s /><label for="include_css">%s</label></p>',
											\checked( $favorites_display_options['include_css'], true, false ),
											\__('Include CSS', 'favorites')
										);
									echo '</div>';
									echo '<hr/>';
									echo '<div class="inside">';
										printf(
											'<p><input type="submit" class="button button-large" value="%s"/>',
											\__('Save options', 'favorites')
										);
									echo '</div>';
								echo '</form>';
							echo '</div>';
						echo '</div>';
					echo '</div>';
				echo '</div>';
			echo '</div>';
			echo '<div class="clear"></div>';
		echo '</div>';
	}

	public static function on_save() {
		
		if ( 'favorite_form' == isset( $_POST['action'] ) ){
			$favorites_display_opts = array(
										'button_text_add' 		=> \strip_tags( $_POST['button_text_add'] ),
										'button_text_delete' 	=> \strip_tags( $_POST['button_text_delete'] ),
										'before_content' 		=> \strip_tags( $_POST['before_content'] ),
										'after_content' 		=> \strip_tags( $_POST['after_content'] ),
										'include_css' 			=> \strip_tags( $_POST['include_css'] )
									);
			\update_option( 'favorites_display', $favorites_display_opts );

			\wp_redirect( admin_url('admin.php?page=ben-favorites/lib/FavoritesInterface.php&success=true') );
		}
	}
}
