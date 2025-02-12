<?php get_header(); ?>
<div id="app-wrapper" role="main">
  <?php 
    if( have_rows('single_news_blocks') ):
      while ( have_rows('single_news_blocks') ) : the_row();
        get_template_part('template-parts/acf-blocks/single-news/' . get_row_layout());
      endwhile;
    endif;
  ?>
  <?php 
  get_template_part('template-parts/acf-blocks/single-news/latest-news'); 
  get_template_part('template-parts/acf-blocks/get-in-touch-banner'); 
  ?>
</div>
<?php get_footer(); ?>