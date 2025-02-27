<?php
$term_id = get_queried_object_id();
$post_id = is_tax() ? 'term_' . $term_id : get_the_ID();

if( have_rows('content_blocks', $post_id) ):
    while ( have_rows('content_blocks', $post_id) ) : the_row();

        get_template_part('template-parts/acf-blocks/' . get_row_layout());

    endwhile;

else :

endif;