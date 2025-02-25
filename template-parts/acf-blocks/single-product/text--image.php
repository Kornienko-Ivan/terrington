<?php
$spacing = get_sub_field('text__image_spacing') == 'small' ? 'productTextImage--small' : 'productTextImage--big';

if(have_rows('text__image_list')):
    ?>
    <section class="productTextImage <?php echo $spacing ?>">
        <div class="container container--narrow">
            <div class="productTextImage__content">
                <?php
                $index = 0;
                while(have_rows('text__image_list')): the_row();
                    $image_width = get_sub_field('image_width');
                    $title = get_sub_field('title');
                    $text = get_sub_field('text');
                    $image = get_sub_field('image');
                    if($image || $title || $text):
                        ?>
                        <div class="productTextImage__block productTextImage__block--<?php echo $index; ?>">
                            <?php if($image): ?>
                                <div class="productTextImage__image image-<?php echo $image_width; ?>">
                                    <img src="<?php echo esc_url(get_custom_image($image, 'custom_500x500')); ?>" alt="<?php echo esc_attr($image['title']); ?>">
                                </div>
                            <?php endif; ?>
                            <?php if($title || $text): ?>
                                <div class="productTextImage__textWrapper">
                                    <?php if($title): ?>
                                        <h4><?php echo $title; ?></h4>
                                    <?php endif; ?>
                                    <?php if($text): ?>
                                        <div class="productTextImage__text"><?php echo $text; ?></div>
                                    <?php endif; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                        <?php
                        $index++;
                    endif;
                endwhile;
                ?>
            </div>
        </div>
    </section>
<?php endif; ?>
