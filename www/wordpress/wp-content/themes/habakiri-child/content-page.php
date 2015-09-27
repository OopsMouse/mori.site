<?php
/**
 * Author       : Noda Shimpei
 * Author URI   : https://github.com/OopsMouse/
 * License      : MIT
*/
?>
<article class="artwork">
  <div class="entry">
    <div class="container">
      <?php
      if ( Habakiri::get( 'is_displaying_page_header' ) === 'false' ) {
      ?>
        <div class="col-md-12">
          <div class="text-center">
            <?php Habakiri::the_title(); ?>
          </div>
        </div>
      <?php
      }
      ?>
      <div class="col-md-12">
        <?php the_content(); ?>
      </div>
    </div>
  </div>
</article>
