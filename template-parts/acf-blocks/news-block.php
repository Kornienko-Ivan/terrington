<?php 
$heading = get_sub_field('heading');
$subheading = get_sub_field('subheading');
$posts = get_sub_field('posts');
if(!$posts):
    $posts = get_posts( array(
        'numberposts' => 3,
        'category'    => 0,
        'orderby'     => 'date',
        'order'       => 'DESC',
        'include'     => array(),
        'exclude'     => array(),
        'meta_key'    => '',
        'meta_value'  =>'',
        'post_type'   => 'post',
    ) );
endif;
?>
<section id="block-<?php echo $args['id'];?>" class="section newsBlock">
    <div class="container">
        <div class="headingBlock newsBlock__headingBlock pb-50">
            <?php if($heading): ?>
                <h2 class="text--color--secondary font--weight--medium text--size--28  appear fade-up"><?php echo $heading; ?></h2>
            <?php endif;?>
            <?php if($subheading): ?>
                <div class="content-block pt-30 text--size--16 appear fade-up"><?php echo $subheading; ?></div>
            <?php endif;?>
        </div>
        <?php
        if( $posts): ?>
            <ul class="row newsBlock__list">
						<?php foreach($posts as $post): ?>
                            <?php 
                            setup_postdata($post); 
                            $permalink = get_permalink( );
                            $title = get_the_title(  );
                            $excerpt = geT_the_excerpt();
                            $image = get_the_post_thumbnail_url(get_the_ID(), 'full');
							$date = get_the_date('d F Y',$item->ID);
                            $categories = wp_get_post_categories( get_the_ID() , array('fields' => 'all') );
                            $categoriesString = '';
                            foreach( $categories as $cat ){
                                $icon = get_field('icon',$cat);
                                if($icon): 
                                    $categoriesString.= '<a href="'.get_term_link($cat->term_id, 'category').'"><span class="icon">'.file_get_contents(esc_url(wp_get_original_image_path($icon['id']))).'</span>'.$cat->name.'</a>';
                                else:
                                    $categoriesString.= '<a href="'.get_term_link($cat->term_id, 'category').'">'.$cat->name.'</a>';
                                endif;
                                break;
                            }
							?>
							<li class="col-12 col-md-6 col-lg-4 newsBlock__item appear fade-up">
								<div class="newsBlock__item__inner">
                                    <a href="<?php echo $permalink; ?>" class="newsBlock__item__image" <?php echo get_field('open_on_external_link')?'target="_starter"':''; ?>>
										<?php if($image): ?>
											<img class="newsBlock__item__bg lazy-img" data-src="<?php echo $image; ?>" alt="<?php echo $title; ?>" />
										<?php endif; ?>
                                    </a>
									<div class="newsBlock__item__content">
                                        <a class="newsBlock__item__content__link" href="<?php echo $permalink; ?>" <?php echo get_field('open_on_external_link')?'target="_starter"':''; ?>>
                                            <h3 class="text--color--secondary text--size--20 font--weight--medium pt-35 newsBlock__item__content__heading"><?php echo $title; ?></h3>
                                            <?php if($excerpt):?>
                                                <p class="text--color--secondary--txt pt-35 "><?php echo $excerpt; ?></p>
                                            <?php endif; ?>
                                        </a>
                                        <div class="newsBlock__item__content__footer">
                                            <?php $tags = get_the_tags(get_the_ID()); 
                                            if($tags):
                                            ?>
                                            <ul class="newsBlock__item__tags">
                                            <?php foreach ( $tags as $tag ): ?>
                                                <li class="newsBlock__item__tags__item">
                                                    <a href="<?php echo get_tag_link( $tag->term_id ); ?> " rel="tag"><?php echo $tag->name; ?></a>
                                                </li>
                                            <?php endforeach ?>
                                            </ul>  
                                            <?php endif; ?>

                                            <span class="text--color--secondary--txt text--size--13 newsBlock__item__content__date"><?php echo $date; ?></span>
                                        </div>
									</div>
								</div>
							</li>
						<?php endforeach; ?>
			</ul>
            <?php 
            // Reset the global post object so that the rest of the page works correctly.
            wp_reset_postdata(); ?>
        <?php endif; ?>
        <ul class="row newsBlock__list">
               
        </ul>
    </div>
</section>