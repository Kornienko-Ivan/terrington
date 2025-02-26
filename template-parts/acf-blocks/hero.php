<?php
$title = get_sub_field('title');
$bg_image = get_sub_field('background_image');

if (is_tax('products-brand')) {
    $brand_logo = get_field('brand_logo', get_queried_object());
}
?>
<?php if($title || $bg_image || $brand_logo): ?>

    <div class="hero">
        <div class="hero__wrapper container container--wide">
            <?php if(is_tax('products-brand') && $brand_logo): ?>
                <div class="hero__logo">
                    <img src="<?php echo esc_url($brand_logo['url']); ?>" alt="<?php echo esc_attr($brand_logo['alt']); ?>">
                </div>
            <?php elseif($title): ?>
                <h1 class="hero__title"><?php echo esc_html($title); ?></h1>
            <?php endif; ?>

            <?php if($bg_image): ?>
                <div class="hero__image">
                    <img src="<?php echo esc_url(get_custom_image($bg_image, 'custom_1650x500')); ?>" alt="<?php echo esc_attr($bg_image['title']); ?>">
                </div>
            <?php endif; ?>
        </div>
    </div>

<?php endif; ?>
