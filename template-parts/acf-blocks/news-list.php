<?php 
$count_posts = wp_count_posts( $post_type = 'post' );
$args = array(
    'post_type' => 'post',
    'posts_per_page' => 9,
);
$the_query = new WP_Query($args);
if($the_query->have_posts()):
?>
<section class="news">
    <div class="container container--narrow">
        <div class="news__list" data-posts-count="<?php echo $count_posts->publish; ?>">
            <?php while($the_query->have_posts()): $the_query->the_post(); ?>
                <?php get_template_part('template-parts/post/post-card'); ?>
            <?php endwhile; ?>
        </div>
        <?php if($count_posts->publish > 9): ?>
            <div class="news__loadMore"><a href="#" class="button">Load More</a></div>
        <?php endif; wp_reset_postdata(); ?>
    </div>
</section>
<?php endif; ?>
