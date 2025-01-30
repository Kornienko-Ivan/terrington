

<?php get_header(); ?>
<div id="app-wrapper" role="main">
   
	
	<?php /*==============================================*/ ?>	
	<?php /*===============CHANGABLE PART=================*/ ?>
	<?php /*
		Dont forget to change data-namespace
	*/ ?>	
    <div id="app" class="app-container" data-namespace="blog-archive">
    	<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
  		<?php /*=====WRITE YOUR CODE HERE=====*/ ?>
			

		
		


		<?php /*=====END OF YOUR CODE=====*/ ?>
		</div>
    </div>
    <?php /*==============================================*/ ?>

</div>
<?php get_footer(); ?>