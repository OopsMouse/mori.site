<?php
/**
 * Template Name: For Front Page
 *
 * Version      : 1.1.0
 * Author       : inc2734
 * Author URI   : http://2inc.org
 * Created      : April 17, 2015
 * Modified     : July 1, 2015
 * License      : GPLv2
 * License URI  : license.txt
 */
?>
<?php get_header(); ?>

<div class="container-fluid">
	<div class="row">
		<main id="main" role="main">
			<?php while ( have_posts() ) : the_post(); ?>
			<article class="article">
				<?php do_action( 'habakiri_before_entry_content' ); ?>
				<div class="entry">
					<?php Habakiri::the_title(); ?>
					<div class="entry__content entry-content">
						<?php
							$the_slug = 'home';
							$arg = array(
								'name'           => $the_slug,
								'post_type'      => 'post',
								'post_status'    => 'publish',
								'posts_per_page' => 1
							);
							$my_posts = get_posts( $arg ); //slugのページID取得

							$args = array(
    						'numberposts' => -1,//取得件数（初期値は5件、-1で全添付を取得）
  							//'order' => 'ASC',//並び順
  							//'orderby' => 'menu_order',//並び順の規準
        				'post_type' => 'attachment',
        				'post_mime_type' => 'image',
        				'post_parent' => $my_posts//帰属する投稿ID
    					);
							$attachments = get_posts( $args );
							if ( $attachments ) {
								foreach ( $attachments as $attachment ) {
            			$imgtag = wp_get_attachment_image( $attachment->ID, 'thumbnail' );//thumbnail, medium, large, full
            			$img = wp_get_attachment_image_src( $attachment->ID, 'thumbnail' );//thumbnail, medium, large, full
            			$imgURL = $img[0];//取得したイメージのURL
            			$imgWidth = $img[1];//取得したイメージの幅
            			$imgHeight = $img[2];//取得したイメージの高さ
            			$ID = $attachment->ID;//添付ID
            			$post_author = $attachment->post_author;//投稿者ID
            			$post_content = $attachment->post_content;//「説明」
            			$post_title = $attachment->post_title;//「タイトル」初期値はファイル名
            			$post_excerpt = $attachment->post_excerpt;//「キャプション」
            			$post_parent = $attachment->post_parent;//帰属する投稿ID
            			$guid = $attachment->guid;//オリジナル画像のURL
        				}
    					}
							$attachment_id = $ID; // 添付ID
							$image_attributes = wp_get_attachment_image_src( $attachment_id,"full","");
							?>
						<section class="jumbotron section-image section-fixed" style="background-image:url( <?php echo $image_attributes[0]; ?> )"　id="home">
							<h1 class="text-center">SHIGEKI MORI</h1>
							<p class="text-center">三重県四日市市在住 画家:森重樹氏のホームページになります。</p>
							<div class="row">
							<div class="col-md-6 col-md-offset-3">
							<a class="btn btn-default btn-block">作品紹介ページへ</a>
							</div>
							</div>
						</section>
						<section class="section" id="profile">
							<h1 class="section-title">PROFILE</h1>
							<p class="text-center">サンプルです</p>
						</section>
						<section class="section" id="lesson">
							<h1 class="section-title">LESSSON</h1>
							<p class="text-center">サンプルです</p>
						</section>
						<section class="section" id="contact">
							<h1 class="section-title">CONTACT</h1>
							<p class="text-center">サンプルです</p>
						</section>
						<?php do_action( 'habakiri_prepend_entry_content_front_page_template' ); ?>
						<?php the_content(); ?>
						<?php do_action( 'habakiri_append_entry_content_front_page_template' ); ?>
					<!-- end .entry-content --></div>
					<?php do_action( 'habakiri_after_entry_content' ); ?>
				<!-- end .entry --></div>
			</article>
			<?php endwhile; ?>
		<!-- end #main --></main>
	<!-- end .row --></div>
<!-- end .container-fluid --></div>

<?php get_footer(); ?>
