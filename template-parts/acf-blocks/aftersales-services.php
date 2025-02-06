<?php 
$title = get_field('aftersales_services_title', 'options');
$args = array(
    'post_type' => 'services',
    'posts_per_page' => -1,
);
$the_query = new WP_Query($args);
?>
<?php if($title): ?>
    <h2 class="services__title"><?php echo $title; ?></h2>
<?php endif; ?>
<?php if($the_query->have_posts()): ?>
    <div class="services__list">
        <?php while($the_query->have_posts()): $the_query->the_post(); 
            $image = get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : get_template_directory() . '/assets/images/placeholder-image.webp';
            ?>
            <div class="services__listItem__wrapper">
                <div class="services__listItem">
                    <div class="services__listItem__title"><?php the_title(); ?></div>
                    <div class="services__listItem__image"><img src="<?php echo $image; ?>" alt=""></div>
                </div>
            </div>
        <?php endwhile; wp_reset_postdata(); ?>
    </div>
<?php endif; ?>