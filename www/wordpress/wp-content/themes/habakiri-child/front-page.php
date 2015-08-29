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
						<?php do_action( 'habakiri_prepend_entry_content_front_page_template' ); ?>
						<?php
							$get_page = get_page_by_path('home');
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
            			//$imgtag = wp_get_attachment_image( $attachment->ID, 'thumbnail' );//thumbnail, medium, large, full
									//$post_content = $attachment->post_content;
            			//$post_title = $attachment->post_title;
									$img = wp_get_attachment_image_src( $attachment->ID, 'full' );
            			$imgURL = $img[0];//取得したイメージのURL
            			$ID = $attachment->ID;//添付ID
            			$guid = $attachment->guid;
        				}
    					}
							?>
						<section class="jumbotron section-image section-fixed" style="background-image:url( <?php echo $guid ?> )"　id="home">
							<h1 class="text-center">SHIGEKI MORI</h1>
							<p class="text-center">
								<?php // home
								remove_filter('the_content', 'wpautop'); //pタグ削除して出力
								the_content();
								?>
							</p>
							<div class="row">
							<div class="col-md-6 col-md-offset-3">
							<a class="btn btn-default btn-block">作品紹介ページへ</a>
							</div>
							</div>
						</section>
							<?php //profile
							$get_page = get_page_by_path('home/profile');
							setup_postdata($get_page);
							?>
						<div class="section" id="<?php echo $get_page->post_name ?>">
							<h1 class="section-title"><?php echo $get_page->post_title ?></h1>
							<?php echo apply_filters('the_content', $get_page->post_content); ?>
						</div>
							<?php //lesson
							$get_page = get_page_by_path('home/lesson');
							setup_postdata($get_page);
							?>
						<section class="section" id="<?php echo $get_page->post_name ?>">
							<h1 class="section-title"><?php echo $get_page->post_title ?></h1>
							<p class="text-center"><?php echo apply_filters('the_content', $get_page->post_content); ?></p>
						</section>
							<?php //contact
							$get_page = get_page_by_path('home/contact');
							setup_postdata($get_page);
							?>
						<div class="section" id="<?php echo $get_page->post_name ?>">
							<h1 class="section-title"><?php echo $get_page->post_title ?></h1>
							<?php echo apply_filters('the_content', $get_page->post_content); ?>
						</div>
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
