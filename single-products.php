<?php get_header(); ?>
<div id="app-wrapper" role="main">
  <?php 
    if( have_rows('product_page_blocks') ):
      while ( have_rows('product_page_blocks') ) : the_row();
        get_template_part('template-parts/acf-blocks/single-product/' . get_row_layout());
      endwhile;
    endif;
  ?>
  <?php 
  get_template_part('template-parts/acf-blocks/get-in-touch-banner'); 
  ?>
</div>
<?php get_footer(); ?>