<?php if(have_rows('brands_slider')): ?>
    <div class="heroBrands__slider">
        <?php while(have_rows('brands_slider')): the_row(); 
            $bg = get_sub_field('background_image');
            $logo = get_sub_field('logo');
            $description = get_sub_field('description');
            $link = get_sub_field('link');
            if($logo || $bg || $description || $link):
            ?>
                <div class="heroBrands__sliderItem__wrapper">
                    <div class="heroBrands__sliderItem">
                        <?php if($bg): ?>
                            <div class="heroBrands__sliderItem__bg"><img src="<?php echo $bg['url']; ?>" alt="<?php echo $bg['title']; ?>"></div>
                        <?php endif; ?>
                        <?php if($logo): ?>
                            <div class="heroBrands__sliderItem__logo"><img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['title']; ?>"></div>
                        <?php endif; ?>
                        <?php if($description): ?>
                            <div class="heroBrands__sliderItem__description"><?php echo $description; ?></div>
                        <?php endif; ?>
                        <?php if($link): ?>
                            <div class="heroBrands__sliderItem__link"><a href="<?php echo $link['url']; ?>" class="link"><?php echo $link['title']; ?></a></div>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endwhile; ?>
    </div>
<?php endif; ?>