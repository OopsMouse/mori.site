<?php
function habakiri_child_theme_setup() {
	class Habakiri extends Habakiri_Base_Functions {
		public function wp_enqueue_scripts() {
			wp_enqueue_style(
				get_template(),
				get_template_directory_uri() . '/style.min.css'
			);
			parent::wp_enqueue_scripts();
		}
	}
}
add_action( 'after_setup_theme', 'habakiri_child_theme_setup' );
