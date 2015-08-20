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

function my_contact_enqueue_scripts(){
  wp_deregister_script('contact-form-7');
  wp_deregister_style('contact-form-7');
  if (is_page('contact'||'home')) {
	   if (function_exists( 'wpcf7_enqueue_scripts')) {
          wpcf7_enqueue_scripts();
	       }
	        if ( function_exists( 'wpcf7_enqueue_styles' ) ) {
	             wpcf7_enqueue_styles();
	            }
        }
}
add_action( 'wp_enqueue_scripts', 'my_contact_enqueue_scripts');

//親子関係を確認する関数
function is_subpage() { //子ページならfalseを返す
  global $post;
  if (is_page() && $post->post_parent){
    $parentID = $post->post_parent;
    return $parentID;
  } else {
    return false;
  };
};
