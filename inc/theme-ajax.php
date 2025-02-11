<?php 
function newsLoadMore(){
    $postCount = $_POST['postsCount'] + 9;

    $args = array(
        'post_type' => 'post',
        'posts_per_page' => $postCount,
    );
    $the_query = new WP_Query($args);
    if($the_query->have_posts()):
        while($the_query->have_posts()): $the_query->the_post(); 
            get_template_part('template-parts/post/post-card'); 
        endwhile; 
    endif;
    die();
}

add_action('wp_ajax_newsLoadMore', 'newsLoadMore');
add_action('wp_ajax_nopriv_newsLoadMore', 'newsLoadMore');
