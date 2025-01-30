
<?php get_header(); ?>
    <div id="app-wrapper" role="main">
        <div id="app" class="app-container" data-namespace="blog-archive">
            <?php query_posts('post_type=post&post_status=publish&posts_per_page=12&paged='. get_query_var('paged')); ?>
            
            <?php 
                //breadcrumbs
                the_breadcrumb();
            ?>

            <?php if( have_posts() ): ?>
                <?php $post_counter = 0 ; ?>
                <?php $post_close_wrap = false ; ?>

    			<div class="filter" style="display: none">
        			<div class="filter-text">
            			<?php
            			$args = array(
            	           'show_option_all'    => '',
            	           'show_option_none'   => __('No categories'),
            	           'orderby'            => 'name',
            	           'order'              => 'ASC',
            	           'show_last_update'   => 0,
            	           'style'              => 'list',
            	           'show_count'         => 0,
            	           'hide_empty'         => 1,
            	           'use_desc_for_title' => 1,
            	           'hierarchical'       => true,
                        	'title_li'           => __( 'Filter:' ),
                        	'number'             => NULL,
                        	'echo'               => 1,
                        	'taxonomy'           => 'category',
                        	'walker'             => 'Walker_Category',
                        	'hide_title_if_empty' => false,
                        	'separator'          => '',
                        );
            			echo '<ul class="filter-categories-wrapper">';
            			wp_list_categories($args);
            			echo '</ul>';
                        ?>
    	           </div>
                </div>


                <div class="blog-archive-wrapper">
                    <div class="blog-archive">
                    <?php while( have_posts() ): the_post(); ?>
                    <div class="blog-archieve-article-wrapper">
                        <a href="<?php the_permalink(); ?>">
                            <div class="blog-archieve-article">
                                <div class="article-img-block" style="background-image:url(<?php echo get_the_post_thumbnail_url(get_the_ID(), 'full' ); ?>);"></div>
                                <div class="article-text-block"><span class="lifestyle-text"><?php 
    								$category = get_the_category();
    								if ( ! empty( $category ) ) echo esc_html( $category[0]->name );?></span>
                                    <h3><?php the_title(); ?></h3>
                                    <p class="article-excerpt"><?php echo get_field("excerpt"); ?></p>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php endwhile; ?>
                    <?php if($post_close_wrap){?>
                    </div>
                    <?php } ?>
                    </div>
                </div>


            <?php else: ?>
                <div id="post-404" class="noposts">
                    <p>
                        <?php _e('None found.','example'); ?>
                    </p>
                </div>
            <?php endif; wp_reset_query(); ?>
        </div>
    </div>
    <?php get_footer(); ?>