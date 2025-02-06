<?php
$title = get_field('latest_news_title', 'options');
$button = get_field('latest_news_button', 'options');

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 3,
);
$the_query = new WP_Query($args);
?>
<?php if ($title || $button && $the_query->have_posts()): ?>

<div class="latestNews">
    <div class="container">
        <div class="latestNews__wrapper">
            <div class="latestNews__row container container--narrow">
                <?php if ($title || $button): ?>
                    <div class="latestNews__head">
                        <?php if ($title): ?>
                            <h2><?php echo esc_html($title); ?></h2>
                        <?php endif; ?>
                        <?php if ($button): ?>
                            <a href="<?php echo esc_url($button['url']); ?>" class="button">
                                <?php echo esc_html($button['title']); ?>
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <?php if ($the_query->have_posts()): ?>
                    <div class="latestNews__list">
                        <?php while ($the_query->have_posts()): $the_query->the_post(); ?>
                            <?php get_template_part('template-parts/post/post-card'); ?>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                <?php endif; ?>

                <?php if ($button): ?>
                    <a href="<?php echo esc_url($button['url']); ?>" class="button button--mobile">
                        <?php echo esc_html($button['title']); ?>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>
<?php endif; ?>


