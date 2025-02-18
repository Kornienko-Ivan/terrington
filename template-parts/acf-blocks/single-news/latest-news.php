<?php
$args = array(
    'post_type' => 'post',
    'posts_per_page' => 5,
);
$the_query = new WP_Query($args);
?>
<div class="latestNews">
    <div class="container">
        <div class="latestNews__wrapper">
            <div class="latestNews__row container container--narrow">
                <div class="latestNews__head">
                    <h2><?php echo _e('Latest News'); ?></h2>
                </div>
                <?php if ($the_query->have_posts()): ?>
                    <div class="latestNews__list news-slider--js">
                        <?php while ($the_query->have_posts()): $the_query->the_post(); ?>
                            <?php get_template_part('template-parts/post/post-card'); ?>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>


