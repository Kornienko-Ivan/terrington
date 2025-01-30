<?php
if( have_rows('blocks') ):
    while ( have_rows('blocks') ) : the_row();
        if( get_row_layout() == 'content_block' ):
            get_template_part('template-parts/acf-blocks/content','block');
        elseif( get_row_layout() == 'image_content_block' ): 
            get_template_part('template-parts/acf-blocks/contentImage','block');
        elseif( get_row_layout() == 'heading_block' ): 
            get_template_part('template-parts/acf-blocks/heading','block');
        elseif( get_row_layout() == 'blog_posts' ): 
            get_template_part('template-parts/acf-blocks/newsBlock','block');
        elseif( get_row_layout() == 'video' ): 
            get_template_part('template-parts/acf-blocks/video','block');
        elseif( get_row_layout() == 'image_block' ): 
            get_template_part('template-parts/acf-blocks/image','block');
        elseif( get_row_layout() == 'images_grid' ): 
            get_template_part('template-parts/acf-blocks/imagesGrid','block');
        elseif( get_row_layout() == 'buttons_block' ): 
            get_template_part('template-parts/acf-blocks/buttons','block');
        elseif( get_row_layout() == 'form_block' ): 
            get_template_part('template-parts/acf-blocks/form','block');
        elseif( get_row_layout() == 'text_logos_block' ): 
            get_template_part('template-parts/acf-blocks/textLogos','block');
        elseif( get_row_layout() == 'featured_case_study' ): 
            get_template_part('template-parts/acf-blocks/featuredCase','block');
        elseif( get_row_layout() == 'text_icons_block' ): 
            get_template_part('template-parts/acf-blocks/textIcons','block');
        elseif( get_row_layout() == 'news_block' ): 
            get_template_part('template-parts/acf-blocks/news','block');
        elseif( get_row_layout() == 'form_image_block' ): 
            get_template_part('template-parts/acf-blocks/formImage','block');
        
        elseif( get_row_layout() == 'divider_line' ): 
           ?>
            <div class="section appear fade-up">
                <span class="divider"></span>
            </div>
           <?php              
        endif;

    endwhile;

else :

endif;