<?php get_header(); ?>

<div id="app-wrapper" role="main">
	<?php if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>

	  <div id="app" class="app-container" data-namespace="index">
		<div id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<div class="content">
				<?php the_title(); ?>
				<?php the_content(); ?>
			</div>
		</div>
	  </div>
	  
	<?php endwhile; endif; ?>
</div>

<?php get_footer(); ?>
