<?php 

/* Template Name: Home Page */ 

?>

<?php get_header(); ?>
<div id="app-wrapper" role="main">
    <?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
	
	<?php /*==============================================*/ ?>	
	<?php /*===============CHANGABLE PART=================*/ ?>
	<?php /*
		Dont forget to change data-namespace
	*/ ?>	
    <div id="app" class="app-container" data-namespace="home">
    	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  		<?php /*=====WRITE YOUR CODE HERE=====*/ ?>
			

		<?php 
		if(get_field('enable_banner')):
			get_template_part('template-parts/acf-blocks/banner');
		endif;
		?>
		
		<?php the_acf_loop(); ?>



		<?php /*=====END OF YOUR CODE=====*/ ?>
		</div>
    </div>
    <?php /*==============================================*/ ?>

    <?php endwhile; endif; ?>
</div>
<?php get_footer(); ?>