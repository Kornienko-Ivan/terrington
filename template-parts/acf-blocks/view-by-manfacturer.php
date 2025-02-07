<?php 
$title = get_sub_field('title');
$args = array(
    'post_type' => 'brand',
    'posts_per_page' => -1,
);
$the_query = new WP_Query($args);
?>
<?php if($title || $the_query->have_posts()): ?>
    <?php if($title): ?>
        <h5 class="manfacturers__title"><?php echo $title; ?></h5>
    <?php endif; ?>
    <?php if($the_query->have_posts()): ?>
        <div class="manfacturers__list">
            <?php while($the_query->have_posts()): $the_query->the_post(); ?>
                <?php 
                $bg = get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : get_template_directory_uri() . '/assets/images/placeholder-image.webp';
                $logo = get_field('brand__image');
                ?>
                <div class="manfacturers__listItemWrapper">
                    <a href="<?php the_permalink(); ?>" class="manfacturers__listItem">
                        <div class="manfacturers__listItem__bg"><img src="<?php echo $bg; ?>" alt=""></div>
                        <?php if($logo): ?>
                            <div class="manfacturers__listItem__logo"><img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['title']; ?>"></div>
                        <?php endif; ?>
                        <div class="manfacturers__listItem__name"><?php the_title(); ?></div>
                    </a>
                </div>
            <?php endwhile; wp_reset_postdata(); ?>
        </div>
    <?php endif; ?>
<?php endif; ?>