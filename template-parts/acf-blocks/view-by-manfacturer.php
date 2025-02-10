<?php 
$title = get_sub_field('title');
$args = array(
    'post_type' => 'brand',
    'posts_per_page' => -1,
);
$the_query = new WP_Query($args);
?>
<div class="manfacturers">
    <div class="container container--narrow">
        <?php if($title || $the_query->have_posts()): ?>
            <?php if($title): ?>
                <h5><?php echo $title; ?></h5>
            <?php endif; ?>
            <?php if($the_query->have_posts()): ?>
                <div class="manfacturers__list">
                    <?php while($the_query->have_posts()): $the_query->the_post(); ?>
                        <?php
                        $bg = get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : get_template_directory_uri() . '/assets/images/placeholder-image.webp';
                        $logo = get_field('brand__image');
                        ?>
                        <a href="<?php the_permalink(); ?>" class="manfacturers__listItem">
                            <img src="<?php echo $bg; ?>" class="manfacturers__listItem__bg" alt="">
                            <?php if($logo): ?>
                               <img src="<?php echo $logo['url']; ?>" class="manfacturers__listItem__logo" alt="<?php echo $logo['title']; ?>">
                            <?php endif; ?>
                        </a>
                    <?php endwhile; wp_reset_postdata(); ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
