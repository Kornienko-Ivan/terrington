<?php
$image = get_the_post_thumbnail_url(get_the_ID(), 'custom_500x500') ?: get_template_directory_uri() . '/assets/images/elementor-placeholder-image.webp';
?>
<a href="<?php the_permalink(); ?>" class="post-card">
    <div class="post-card__image">
        <img src="<?php echo esc_url($image); ?>" alt="<?php the_title_attribute(); ?>">
    </div>
    <div class="post-card__body">
        <h6 class="post-card__title"><?php the_title(); ?></h6>
        <div class="post-card__text"><?php the_excerpt(); ?></div>
        <div class="post-card__icon">
            <?php echo get_inline_svg('arrow-btn'); ?>
        </div>
    </div>
</a>
