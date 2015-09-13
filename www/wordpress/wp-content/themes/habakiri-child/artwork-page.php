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

<link rel="stylesheet" type="text/css" href="<?php echo get_stylesheet_directory_uri(); ?>/bower_components/Formstone/dist/css/lightbox.css">
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/bower_components/Formstone/dist/js/core.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/bower_components/Formstone/dist/js/touch.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/bower_components/Formstone/dist/js/transition.js'></script>
<script type='text/javascript' src='<?php echo get_stylesheet_directory_uri(); ?>/bower_components/Formstone/dist/js/lightbox.js'></script>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <main id="main" role="main">
        <div class="GITheWall">
        <?php Habakiri::the_bread_crumb(); ?>
        <?php while ( have_posts() ) : the_post(); ?>
          <?php get_template_part( 'content', 'page' ); ?>
        <?php endwhile; ?>
        </div>
      </main>
    </div>
  </div>
</div>

<script type="text/javascript">
  jQuery(function($) {
    $(".lightbox").lightbox();
  })

</script>

<?php get_footer(); ?>
