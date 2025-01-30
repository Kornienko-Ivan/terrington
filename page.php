<?php get_header(); ?>
<div id="app-wrapper" role="main">
    
    <?php 
    /*==============================================*/ 
    /*===============CHANGABLE PART=================*/ 
    /* Dont forget to change dta-namespace */ 
    ?>   

    <div id="app" class="app-container" data-namespace="page">
        <?php /*=====WRITE YOUR CODE HERE=====*/ ?>
            
			<div id="post-<?php the_ID('default-page'); ?>" <?php post_class(); ?>>
				
                <?php 
                if ( ! post_password_required() ) :
                    // Your custom code should here
                    get_template_part('template-parts/page/content','page');
                    the_acf_loop();
                else :
                  // we will show password form here
                  echo get_the_password_form();
                endif;
              ?>
			</div>
            
        <?php /*=====END OF YOUR CODE=====*/ ?>
    </div>
    <?php /*==============================================*/ ?>

</div>
<?php get_footer(); ?>