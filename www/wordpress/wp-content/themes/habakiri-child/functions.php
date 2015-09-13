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

function custom_get_attachment_link( $id = 0, $size = 'thumbnail', $permalink = false, $icon = false, $text = false, $attr = '' ) {
  $id = intval( $id );
  $_post = get_post( $id );

  if ( empty( $_post ) || ( 'attachment' != $_post->post_type ) || ! $url = wp_get_attachment_url( $_post->ID ) )
    return __( 'Missing Attachment' );

  if ( $permalink )
    $url = get_attachment_link( $_post->ID );

  if ( $text ) {
    $link_text = $text;
  } elseif ( $size && 'none' != $size ) {
    $link_text = wp_get_attachment_image( $id, $size, $icon, $attr );
  } else {
    $link_text = '';
  }

  if ( trim( $link_text ) == '' )
    $link_text = $_post->post_title;

  /**
   * Filter a retrieved attachment page link.
   *
   * @since 2.7.0
   *
   * @param string      $link_html The page link HTML output.
   * @param int         $id        Post ID.
   * @param string      $size      Image size. Default 'thumbnail'.
   * @param bool        $permalink Whether to add permalink to image. Default false.
   * @param bool        $icon      Whether to include an icon. Default false.
   * @param string|bool $text      If string, will be link text. Default false.
   */
  return apply_filters( 'wp_get_attachment_link', "<a href='$url' class='lightbox' data-lightbox-gallery='photo_gallery'>$link_text</a>", $id, $size, $permalink, $icon, $text );
}

function custom_gallery_shortcode( $attr ) {
  $post = get_post();

  static $instance = 0;
  $instance++;

  if ( ! empty( $attr['ids'] ) ) {
    // 'ids' is explicitly ordered, unless you specify otherwise.
    if ( empty( $attr['orderby'] ) ) {
      $attr['orderby'] = 'post__in';
    }
    $attr['include'] = $attr['ids'];
  }

  /**
   * Filter the default gallery shortcode output.
   *
   * If the filtered output isn't empty, it will be used instead of generating
   * the default gallery template.
   *
   * @since 2.5.0
   * @since 4.2.0 The `$instance` parameter was added.
   *
   * @see gallery_shortcode()
   *
   * @param string $output   The gallery output. Default empty.
   * @param array  $attr     Attributes of the gallery shortcode.
   * @param int    $instance Unique numeric ID of this gallery shortcode instance.
   */
  $output = apply_filters( 'post_gallery', '', $attr, $instance );
  if ( $output != '' ) {
    return $output;
  }

  $html5 = current_theme_supports( 'html5', 'gallery' );
  $atts = shortcode_atts( array(
    'order'      => 'ASC',
    'orderby'    => 'menu_order ID',
    'id'         => $post ? $post->ID : 0,
    'itemtag'    => 'li',
    'icontag'    => 'p',
    'captiontag' => 'p',
    'columns'    => 3,
    'size'       => 'thumbnail',
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

  $itemtag = tag_escape( $atts['itemtag'] );
  $captiontag = tag_escape( $atts['captiontag'] );
  $icontag = tag_escape( $atts['icontag'] );
  $valid_tags = wp_kses_allowed_html( 'post' );
  if ( ! isset( $valid_tags[ $itemtag ] ) ) {
    $itemtag = 'li';
  }
  if ( ! isset( $valid_tags[ $captiontag ] ) ) {
    $captiontag = 'p';
  }
  if ( ! isset( $valid_tags[ $icontag ] ) ) {
    $icontag = 'p';
  }

  $columns = intval( $atts['columns'] );
  $itemwidth = $columns > 0 ? floor(100/$columns) : 100;
  $float = is_rtl() ? 'right' : 'left';

  $selector = "gallery-{$instance}";

  $gallery_style = '';

  /**
   * Filter whether to print default gallery styles.
   *
   * @since 3.1.0
   *
   * @param bool $print Whether to print default gallery styles.
   *                    Defaults to false if the theme supports HTML5 galleries.
   *                    Otherwise, defaults to true.
   */
  if ( apply_filters( 'use_default_gallery_style', ! $html5 ) ) {
    $gallery_style = "
    <style type='text/css'>
      #{$selector} {
        margin: auto;
      }
      #{$selector} .gallery-item {
        float: {$float};
        margin-top: 10px;
        text-align: center;
        width: {$itemwidth}%;
      }
      #{$selector} img {
        border: 2px solid #cfcfcf;
      }
      #{$selector} .gallery-caption {
        margin-left: 0;
      }
      /* see gallery_shortcode() in wp-includes/media.php */
    </style>\n\t\t";
  }

  $size_class = sanitize_html_class( $atts['size'] );
  $gallery_div = "<div id='$selector' class='gallery galleryid-{$id} gallery-columns-{$columns} gallery-size-{$size_class}'>";

  /**
   * Filter the default gallery shortcode CSS styles.
   *
   * @since 2.5.0
   *
   * @param string $gallery_style Default CSS styles and opening HTML div container
   *                              for the gallery shortcode output.
   */
  $output = apply_filters( 'gallery_style', $gallery_style . $gallery_div );

  $i = 0;
  foreach ( $attachments as $id => $attachment ) {

    $attr = ( trim( $attachment->post_excerpt ) ) ? array( 'aria-describedby' => "$selector-$id" ) : '';
    if ( ! empty( $atts['link'] ) && 'file' === $atts['link'] ) {
      $image_output = custom_get_attachment_link( $id, $atts['size'], false, false, false, $attr );
    } elseif ( ! empty( $atts['link'] ) && 'none' === $atts['link'] ) {
      $image_output = custom_get_attachment_link( $id, $atts['size'], false, $attr );
    } else {
      $image_output = custom_get_attachment_link( $id, $atts['size'], true, false, false, $attr );
    }
    $image_meta  = wp_get_attachment_metadata( $id );

    $orientation = '';
    if ( isset( $image_meta['height'], $image_meta['width'] ) ) {
      $orientation = ( $image_meta['height'] > $image_meta['width'] ) ? 'portrait' : 'landscape';
    }
    $output .= "<{$itemtag} class='gallery-item'>";
    $output .= "
      <{$icontag} class='gallery-icon {$orientation}'>
        $image_output
      </{$icontag}>";
    if ( $captiontag && trim($attachment->post_excerpt) ) {
      $output .= "
        <{$captiontag} class='wp-caption-text gallery-caption' id='$selector-$id'>
        " . wptexturize($attachment->post_excerpt) . "
        </{$captiontag}>";
    }
    $output .= "</{$itemtag}>";
    if ( ! $html5 && $columns > 0 && ++$i % $columns == 0 ) {
      $output .= '<br style="clear: both" />';
    }
  }

  if ( ! $html5 && $columns > 0 && $i % $columns !== 0 ) {
    $output .= "
      <br style='clear: both' />";
  }

  $output .= "
    </div>\n";

  return $output;
}

remove_shortcode('gallery', 'gallery_shortcode');
add_shortcode('gallery', 'custom_gallery_shortcode');

