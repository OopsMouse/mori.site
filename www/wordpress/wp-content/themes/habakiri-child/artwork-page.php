<?php
/**
 * Template Name: For Artwork Page
 *
 * Version      : 0.0.1
 * Author       : Noda Shimpei
 * Author URI   : https://github.com/OopsMouse/
 * License      : MIT
 */
?>
<?php get_header(); ?>

<link href="<?php echo get_stylesheet_directory_uri(); ?>/bower_components/font-awesome/css/font-awesome.min.css" rel="stylesheet">
<link href="<?php echo get_stylesheet_directory_uri(); ?>/bower_components/lightbox2/dist/css/lightbox.css" rel="stylesheet">

<?php Habakiri::the_bread_crumb(); ?>
<?php while ( have_posts() ) : the_post(); ?>
  <?php get_template_part( 'content', 'page' ); ?>
<?php endwhile; ?>

<script src="<?php echo get_stylesheet_directory_uri(); ?>/bower_components/lightbox2/dist/js/lightbox.min.js"></script>
<script src="<?php echo get_stylesheet_directory_uri(); ?>/bower_components/jQuery.within/dist/jquery.within-1.0.min.js"></script>

<?php get_footer(); ?>
