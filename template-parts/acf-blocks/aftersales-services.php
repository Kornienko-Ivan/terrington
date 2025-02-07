<?php 
$title = get_field('aftersales_services_title', 'options');
$args = array(
    'post_type' => 'services',
    'posts_per_page' => -1,
);
$the_query = new WP_Query($args);
?>
<div class="services">
    <div class="container">
        <div class="services__wrapper">
            <div class="container container--narrow">
                <?php if($title): ?>
                    <h2><?php echo $title; ?></h2>
                <?php endif; ?>
                <?php if($the_query->have_posts()): ?>
                    <div class="services__list">
                        <?php while($the_query->have_posts()): $the_query->the_post();
                            $image = get_the_post_thumbnail_url() ? get_the_post_thumbnail_url() : get_template_directory() . '/assets/images/placeholder-image.webp';
                            ?>
                            <div class="services__listItem">
                                <h4><?php the_title(); ?></h4>
                               <img src="<?php echo $image; ?>" alt="">
                            </div>
                        <?php endwhile; wp_reset_postdata(); ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

