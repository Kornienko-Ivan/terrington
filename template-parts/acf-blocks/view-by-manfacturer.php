<?php
$title = get_sub_field('title');
$args = array(
    'taxonomy' => 'products-brand',
    'orderby' => 'name',
    'order'   => 'ASC',
    'hide_empty' => false
);
$brands = get_terms($args);
?>
<div class="manfacturers">
    <div class="container container--narrow">
        <?php if($title || !empty($brands)): ?>
            <?php if($title): ?>
                <h5><?php echo $title; ?></h5>
            <?php endif; ?>
            <?php if(!empty($brands)): ?>
                <div class="manfacturers__list">
                    <?php foreach($brands as $brand): ?>
                        <?php
                        $bg_image = get_field('brand_bg_image', 'products-brand_' . $brand->term_id) ?: get_template_directory_uri() . '/assets/images/placeholder-image.webp';
                        $logo = get_field('brand_logo', 'products-brand_' . $brand->term_id);
                        ?>
                    <div class="manfacturers__listItem" data-slug="<?php echo esc_attr($brand->slug); ?>" onclick="window.location.href='<?php echo esc_url(home_url('/products-overview/')) . '?brand=' . esc_attr($brand->slug); ?>';">
                            <img src="<?php echo esc_url(get_custom_image($bg_image, 'custom_450x250')); ?>" class="manfacturers__listItem__bg" alt="<?php echo esc_attr($brand->name); ?>">
                            <div class="manfacturers__listItem__wrapper">
                                <?php if($logo): ?>
                                    <img src="<?php echo esc_url($logo['url']); ?>" class="manfacturers__listItem__logo" alt="<?php echo esc_attr($brand->name); ?>">
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
