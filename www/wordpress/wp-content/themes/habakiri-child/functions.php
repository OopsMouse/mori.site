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

//contact,home(slugID)の時のみスクリプト読み込む
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

function my_habakiri_prepend_entry_content_front_page_template(){

}
add_action( 'habakiri_prepend_entry_content_front_page_template', 'my_habakiri_prepend_entry_content_front_page_template');

/**コピーライトを変更
 * @param string $copyright
 * @return string
 */
function my_habakiri_copyright( $copyright ) {
	$copyright = ""; //初期化
	$copyright .= sprintf('Copyright © Atolle Mori 2015');
	return $copyright;
}
add_filter( 'habakiri_copyright', 'my_habakiri_copyright' );

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

//ショートコード...profileページの画像を生成
function shortcode_getImg($atts) {
	extract(
		shortcode_atts(array('slugID' => 'home/profile'),$atts)
	);
	$get_page = get_page_by_path($slugID);
	$get_pageID = $get_page->ID;
	$arg = array(
		'numberposts' => -1,//取得件数（初期値は5件、-1で全添付を取得）
		'post_type' => 'attachment',
		'post_mime_type' => 'image',
		'post_parent' => $get_pageID//帰属する投稿ID
	);
	$attachments = get_posts( $arg );
	if ( $attachments ) {
		foreach ( $attachments as $attachment ) {
			$img = wp_get_attachment_image_src( $attachment->ID, 'full' );
			$imgURL = $img[0];//取得したイメージのURL
			$ID = $attachment->ID;//添付ID
		}
	}
$result = sprintf('<img class="img-thumbnail" src=%s >',$imgURL);
return $result;
}
add_shortcode('getImg', 'shortcode_getImg');
