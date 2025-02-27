<?php
$brands_terms = get_sub_field('brands_terms');
?>

<?php if ($brands_terms): ?>
    <div class="heroBrands">
        <div class="container container--wide">
            <div class="heroBrands__wrapper">
                <div class="heroBrands__slider heroBrands__slider--js">
                    <?php
                    foreach ($brands_terms as $term):
                        $bg          = get_field('brand_bg_image', $term);
                        $logo        = get_field('brand_logo', $term);
                        $description = $term->description;

                        $link = [
                            'url'   => get_term_link($term),
                            'title' => $term->name,
                        ];

                        if($bg || $logo || $description || $link):
                            ?>
                            <a href="<?php echo esc_url($link['url']); ?>" class="heroBrands__sliderItem__link">
                                <div class="heroBrands__sliderItem">
                                    <div class="heroBrands__inner">
                                        <div class="heroBrands__front">
                                            <?php if ($bg): ?>
                                                <img class="heroBrands__bg"
                                                     src="<?php echo esc_url(get_custom_image($bg, 'custom_450x250')); ?>"
                                                     alt="<?php echo esc_attr($bg['title'] ?? ''); ?>">
                                            <?php endif; ?>

                                            <?php if ($logo): ?>
                                                <div class="heroBrands__logo">
                                                    <img src="<?php echo esc_url($logo['url']); ?>"
                                                         alt="<?php echo esc_attr($logo['title'] ?? ''); ?>">
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="heroBrands__backend">
                                            <?php if ($description): ?>
                                                <div class="heroBrands__description">
                                                    <?php echo esc_html(truncate_text($description, 150)); ?>
                                                </div>
                                            <?php endif; ?>

                                            <div class="heroBrands__btn h6">
                                                <?php echo 'Find out more' ?>
                                                <?php echo get_inline_svg('white-arrow'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <div class="heroBrands__slider__prev">
                    <?php echo get_inline_svg('slider-arrow'); ?>
                </div>
                <div class="heroBrands__slider__next">
                    <?php echo get_inline_svg('slider-arrow'); ?>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
