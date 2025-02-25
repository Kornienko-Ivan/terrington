<?php
if(have_rows('images_slider')):
?>
<section class="productImageSlider">
    <div class="">
        <div class="productImageSlider__list productImageSlider--js">
            <?php while(have_rows('images_slider')): the_row();
                $image = get_sub_field('image');
                if($image):
            ?>
                <div class="productImageSlider__listItem">
                    <img src="<?php echo esc_url(get_custom_image($image, 'custom_1200x600')); ?>" alt="<?php echo esc_attr($image['title']); ?>">
                </div>
            <?php endif; endwhile; ?>
        </div>
        <div class="productImageSlider__prev"><?php echo get_inline_svg('slider-arrow') ?></div>
        <div class="productImageSlider__next"><?php echo get_inline_svg('slider-arrow') ?></div>
    </div>
</section>
<?php endif; ?>