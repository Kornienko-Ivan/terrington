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
                    <h2><?php echo esc_html($title); ?></h2>
                <?php endif; ?>
                <?php if ($the_query->have_posts()): ?>
                    <div class="services__list">
                        <?php while ($the_query->have_posts()): $the_query->the_post();
                            $image_id = get_post_thumbnail_id();
                            $placeholder = get_template_directory_uri() . '/assets/images/placeholder-image.webp';

                            $image_data = $image_id ? wp_get_attachment_image_src($image_id, 'custom_500x500') : null;
                            $image_url = $image_data ? $image_data[0] : $placeholder;
                            ?>
                            <a href="<?php the_permalink(); ?>" class="services__listItem">
                                <h4><?php the_title(); ?></h4>
                                <img src="<?php echo esc_url($image_url); ?>" alt="<?php the_title_attribute(); ?>">
                            </a>
                        <?php endwhile;
                        wp_reset_postdata(); ?>
                    </div>
                <?php endif; ?>

            </div>
        </div>
    </div>
</div>
