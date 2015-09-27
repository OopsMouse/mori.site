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

function custom_gallery_shortcode( $attr ) {
  $post   = get_post();
  $output = '';

  static $instance = 0;
  $instance++;

  if ( ! empty( $attr['ids'] ) ) {
    if ( empty( $attr['orderby'] ) ) {
      $attr['orderby'] = 'post__in';
    }
    $attr['include'] = $attr['ids'];
  }

  $output = apply_filters( 'post_gallery', '', $attr, $instance );
  if ( $output != '' ) {
    return $output;
  }

  $atts = shortcode_atts( array(
    'order'      => 'ASC',
    'orderby'    => 'menu_order ID',
    'id'         => $post ? $post->ID : 0,
    'columns'    => 4,
    'size'       => 'medium',
    'include'    => '',
    'exclude'    => '',
    'link'       => ''
  ), $attr, 'gallery' );

  $id = intval( $atts['id'] );

  if ( ! empty( $atts['include'] ) ) {
    $_attachments = get_posts( array( 'include' => $atts['include'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );

    $attachments = array();
    foreach ( $_attachments as $key => $val ) {
      $attachments[$val->ID] = $_attachments[$key];
    }
  } elseif ( ! empty( $atts['exclude'] ) ) {
    $attachments = get_children( array( 'post_parent' => $id, 'exclude' => $atts['exclude'], 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
  } else {
    $attachments = get_children( array( 'post_parent' => $id, 'post_status' => 'inherit', 'post_type' => 'attachment', 'post_mime_type' => 'image', 'order' => $atts['order'], 'orderby' => $atts['orderby'] ) );
  }

  if ( empty( $attachments ) ) {
    return '';
  }

  if ( is_feed() ) {
    $output = "\n";
    foreach ( $attachments as $att_id => $attachment ) {
      $output .= wp_get_attachment_link( $att_id, $atts['size'], true ) . "\n";
    }
    return $output;
  }

  $columns = intval( $atts['columns'] );

  $i = 0;
  $is_closed_div = true;

  var_dump($atts);

  if (12 % $columns == 0) {
    $md_columns = 12 / $columns;
    $sm_columns = $md_columns * 2;
  } else {
    $md_columns = 3;
    $sm_columns = 6;
  }

  foreach ( $attachments as $id => $attachment ) {
    if ($i % $columns == 0) {
      $output .= "<div class='row'>";
      $is_closed_div = false;
    }

    $img_url   = wp_get_attachment_url( $id );
    list( $thumb_url, $_width, $_height ) = wp_get_attachment_image_src( $id, $atts['size'] );

    $output .= "<div class='col-xs-12 col-sm-{$sm_columns} col-md-{$md_columns} portfolio-item'>";
    $output .= "<div class='portfolio-img'>";
    $output .= "<a href='{$img_url}' data-lightbox='portfolio' data-title=" . wptexturize($attachment->post_excerpt) . ">";
    $output .= "<img class='img-responsive img-rounded img-rectangle' src='{$thumb_url}'>";
    $output .= "<div class='overlay'>";
    $output .= "<div class='icon'>";
    $output .= "<p>";
    $output .= "<i class='fa fa-image fa-2x'></i>";
    $output .= "</p>";
    $output .= "</div>";
    $output .= "</div>";
    $output .= "</a>";
    $output .= "</div>";
    $output .= "<p class='portfolio-title'>";
    $output .= wptexturize($attachment->post_excerpt);
    $output .= "</p>";
    $output .= "</div>";

    if (($i + 1) % $columns == 0) {
      $output .= "</div>";
      $is_closed_div = true;
    }

    $i++;
  }

  if (!$is_closed_div) {
    $output .= "</div>";
  }

  return $output;
}

remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'custom_gallery_shortcode');
