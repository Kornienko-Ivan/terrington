<?php 
$args = array(
    'post_type' => 'brand',
    'posts_per_page' => -1,
);
$the_query = new WP_Query($args);
if($the_query->have_posts()):
?>
<div class="brands">
    <div class="container container--narrow">
        <div class="manfacturers__list brands__list">
            <?php while($the_query->have_posts()): $the_query->the_post(); ?>
                <?php
                $bg = get_field('brand__image') ? get_field('brand__image') : get_template_directory_uri() . '/assets/images/placeholder-image.webp';
                $logo = get_the_post_thumbnail_url();
                ?>
                <a href="<?php the_permalink(); ?>" class="manfacturers__listItem">
                    <img src="<?php echo $bg['url']; ?>" class="manfacturers__listItem__bg" alt="<?php echo $bg['title']; ?>">
                    <?php if($logo): ?>
                       <img src="<?php echo $logo; ?>" class="manfacturers__listItem__logo" alt="<?php echo $logo; ?>">
                    <?php endif; ?>
                </a>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    </div>
</div>
<?php endif; ?>