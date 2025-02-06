<?php 
$title = get_field('latest_news_title', 'options');
$button = get_field('latest_news_button', 'options');

$args = array(
    'post_type' => 'post',
    'posts_per_page' => 3,
);
$the_query = new WP_Query($args);
?>
<?php if($title || $button): ?>
    <div class="latestNews__head">
        <?php if($title): ?>
            <h2 class="latestNews__title"><?php echo $title; ?></h2>
        <?php endif; ?>
        <?php if($button): ?>
            <div class="latestNews__button"><a href="<?php echo $button['url']; ?>" class="button"><?php echo $button['title']; ?></a></div>
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php if($the_query->have_posts()): ?>
    <div class="latestNews__list">
        <?php while($the_query->have_posts()): $the_query->the_post(); 
            $image = get_the_post_thumbnail_url(  ) ? get_the_post_thumbnail_url(  ) : get_template_directory_uri(  ) . '/assets/images/placeholder-image.webp';
            ?>
            <div class="latestNews__listItem">
                <div class="latestNews__listItem__image"><img src="<?php echo $image; ?>" alt=""></div>
                <div class="latestNews__listItem__body">
                    <div class="latestNews__listItem__title"><?php the_title(); ?></div>
                    <div class="latestNews__listItem__text"><?php the_excerpt(); ?></div>
                    <div class="latestNews__listItem__icon"></div>
                </div>
            </div>
        <?php endwhile; wp_reset_postdata(  ); ?>
    </div>
<?php endif; ?>