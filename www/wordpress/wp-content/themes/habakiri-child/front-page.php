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
							$attachment_id = 16; // 添付ID
							$image_attributes = wp_get_attachment_image_src( $attachment_id,"full","");
							?>
						<section class="section section-image section-fixed" style="background-image:url( <?php echo $image_attributes[0] ?> )"　id="home">
						<h1 class="section-title">タイトル</h1>
						<p class="text-center">サンプルです</p>
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
