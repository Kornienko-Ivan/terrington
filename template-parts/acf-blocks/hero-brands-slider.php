<?php if(have_rows('brands_slider')): ?>
    <div class="heroBrands">
        <div class="container container--wide">
            <div class="heroBrands__wrapper">
                <div class="heroBrands__slider heroBrands__slider--js">
                    <?php while(have_rows('brands_slider')): the_row();
                        $bg = get_sub_field('background_image');
                        $logo = get_sub_field('logo');
                        $description = get_sub_field('description');
                        $link = get_sub_field('link');
                        if($logo || $bg || $description || $link):
                            ?>
                            <a href="<?php echo $link['url']; ?>" class="heroBrands__sliderItem__link">
                                <div class="heroBrands__sliderItem">
                                    <div class="heroBrands__inner">
                                        <div class="heroBrands__front">
                                            <?php if ($bg): ?>
                                                <img class="heroBrands__bg" src="<?php echo get_custom_image($bg, 'custom_450x250'); ?>" alt="<?php echo esc_attr($bg['title']); ?>">
                                            <?php endif; ?>

                                            <?php if($logo): ?>
                                                <div class="heroBrands__logo"><img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['title']; ?>"></div>
                                            <?php endif; ?>
                                        </div>
                                        <div class="heroBrands__backend">
                                            <?php if($description): ?>
                                                <div class="heroBrands__description"> <?php echo $description; ?> </div>
                                            <?php endif; ?>
                                            <div class="heroBrands__btn h6">
                                                <?php echo $link['title']; ?>
                                                <?php echo get_inline_svg('white-arrow'); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        <?php endif; ?>
                    <?php endwhile; ?>
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
