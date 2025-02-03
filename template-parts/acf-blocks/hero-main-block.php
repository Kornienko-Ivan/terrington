<?php 
$left_bg = get_sub_field('left_part_bg');
$left_logo = get_sub_field('left_part_logo');
$left_description = get_sub_field('left_part_description');
$left_link = get_sub_field('left_part_link');
$middle_bg = get_sub_field('middle_part_bg');
$middle_logo = get_sub_field('middle_part_logo');
$middle_description = get_sub_field('middle_part_description');
$middle_link = get_sub_field('middle_part_link');
$right_bg = get_sub_field('right_part_bg');
$right_logo = get_sub_field('right_part_logo');
$right_description = get_sub_field('right_part_description');
$right_link = get_sub_field('right_part_link');

$title = get_sub_field('title');
$background_image = get_sub_field('background_image');
$logo = get_sub_field('logo');
$advertising_link = get_sub_field('link');

$brands = new WP_Query([
    'post_type'      => 'brand',
    'posts_per_page' => -1,
]);
?>
<div class="heroMain">
    <div class="container container--wide">
        <div class="heroMain__wrapper">

            <?php if($left_bg || $left_logo || $left_description || $left_link): ?>
                <div class="heroMain__leftPart__wrapper">
                    <?php if($left_link): ?>
                        <a href="<?php echo $left_link['url']; ?>" class="heroMain__leftPart__link">
                            <div class="heroMain__leftPart__inner">
                                <div class="heroMain__leftPart__front">
                                    <div class="heroMain__leftPart__col">
                                        <?php if($left_logo): ?>
                                            <div class="heroMain__leftPart__logo"><img src="<?php echo $left_logo['url']; ?>" alt="<?php echo $left_logo['title']; ?>"></div>
                                        <?php endif; ?>
                                    </div>
                                    <div class="heroMain__leftPart__col"></div>
                                    <?php if($left_bg): ?>
                                        <img class="heroMain__leftPart__bg" src="<?php echo $left_bg['url']; ?>" alt="<?php echo $left_bg['title']; ?>">
                                    <?php endif; ?>
                                </div>
                                <div class="heroMain__leftPart__backend">

                                    <div class="heroMain__leftPart__col">
                                        <?php if($left_logo): ?>
                                            <div class="heroMain__logo"><img src="<?php echo $left_logo['url']; ?>" alt="<?php echo $left_logo['title']; ?>"></div>
                                        <?php endif; ?>
                                        <?php if($left_description): ?>
                                            <div class="heroMain__leftPart__description"><?php echo $left_description; ?></div>
                                        <?php endif; ?>

                                        <div class="heroMain__leftPart__btn h6">
                                            <?php echo $left_link['title']; ?>
                                            <?php echo get_inline_svg('white-arrow') ?>
                                        </div>
                                    </div>
                                    <div class="heroMain__leftPart__col">

                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if($middle_bg || $middle_logo || $middle_description || $middle_link): ?>
                <div class="heroMain__middlePart__wrapper card">
                    <?php if($middle_link): ?>
                        <a href="<?php echo $middle_link['url']; ?>" class="card__link">
                            <div class="card__inner">
                                <div class="card__front">
                                    <?php if($middle_bg): ?>
                                        <img class="card__bg" src="<?php echo $middle_bg['url']; ?>" alt="<?php echo $middle_bg['title']; ?>">
                                    <?php endif; ?>
                                    <?php if($middle_logo): ?>
                                        <div class="card__logo"><img src="<?php echo $middle_logo['url']; ?>" alt="<?php echo $middle_logo['title']; ?>"></div>
                                    <?php endif; ?>
                                </div>
                                <div class="card__backend">
                                    <?php if($middle_logo): ?>
                                        <div class="card__logo"><img src="<?php echo $middle_logo['url']; ?>" alt="<?php echo $middle_logo['title']; ?>"></div>
                                    <?php endif; ?>
                                    <?php if($middle_description): ?>
                                        <div class="card__description"><?php echo $middle_description; ?></div>
                                    <?php endif; ?>
                                    <div class="card__btn h6">
                                        <?php echo $middle_link['title']; ?>
                                        <?php echo get_inline_svg('white-arrow') ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if($right_bg || $right_logo || $right_description || $right_link): ?>
                <div class="heroMain__rightPart__wrapper card">
                    <?php if($right_link): ?>
                        <a href="<?php echo $right_link['url']; ?>" class="card__link">
                            <div class="card__inner">
                                <div class="card__front">
                                    <?php if($right_bg): ?>
                                        <img class="card__bg" src="<?php echo $right_bg['url']; ?>" alt="<?php echo $right_bg['title']; ?>">
                                    <?php endif; ?>
                                    <?php if($right_logo): ?>
                                        <div class="card__logo"><img src="<?php echo $right_logo['url']; ?>" alt="<?php echo $right_logo['title']; ?>"></div>
                                    <?php endif; ?>
                                </div>
                                <div class="card__backend">
                                    <?php if($right_logo): ?>
                                        <div class="card__logo"><img src="<?php echo $right_logo['url']; ?>" alt="<?php echo $right_logo['title']; ?>"></div>
                                    <?php endif; ?>
                                    <?php if($right_description): ?>
                                        <div class="card__description"><?php echo $right_description; ?></div>
                                    <?php endif; ?>
                                    <div class="card__btn h6">
                                        <?php echo $right_link['title']; ?>
                                        <?php echo get_inline_svg('white-arrow') ?>
                                    </div>
                                </div>
                            </div>
                        </a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if($title || $logo || $background_image): ?>
            <?php if ($advertising_link): ?>
            <a href="<?php echo esc_url($advertising_link); ?>" class="heroAdvertising__wrapper">
                <?php else: ?>
                <div class="heroAdvertising__wrapper">
                    <?php endif; ?>

                    <?php if ($background_image): ?>
                        <div class="heroAdvertising__bg">
                            <img src="<?php echo esc_url($background_image['url']); ?>" alt="<?php echo esc_attr($background_image['title']); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="heroAdvertising__card">
                        <?php if ($title): ?>
                            <h3><?php echo esc_html($title); ?></h3>
                        <?php endif; ?>
                    </div>

                    <?php if ($logo): ?>
                        <div class="heroAdvertising__logo">
                            <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['title']); ?>">
                        </div>
                    <?php endif; ?>

                    <?php if ($advertising_link): ?>
            </a>
            <?php else: ?>
        </div>
        <?php endif; ?>
            <?php endif; ?>
        </div>
        <div class="heroMain--mobile">
            <?php
            if ($brands->have_posts()) : ?>
                <div class="heroMain__slider">
                    <div class="heroMain__slider__wrapper heroMain__slider--js">
                        <?php while ($brands->have_posts()) : $brands->the_post(); ?>
                            <?php
                            $brand_image = get_field('brand__image');
                            if ($brand_image) :
                                ?>
                                <div class="heroMain__slider__slide brand">
                                    <div class="brand__bg">
                                        <img src="<?php echo esc_url($brand_image['url']); ?>" alt="<?php echo esc_attr(get_the_title()); ?>">
                                    </div>
                                    <div class="brand__logo">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </div>
                                </div>
                            <?php endif; ?>
                        <?php endwhile; ?>

                    </div>
                    <div class="heroMain__slider__prev">
                        <?php echo get_inline_svg('slider-arrow') ?>
                    </div>
                    <div class="heroMain__slider__next">
                        <?php echo get_inline_svg('slider-arrow') ?>
                    </div>
                    <?php wp_reset_postdata(); ?>
                </div>
            <?php endif; ?>

            <?php if($title || $logo || $background_image): ?>

            <?php if ($advertising_link): ?>
            <a href="<?php echo esc_url($advertising_link); ?>" class="heroAdvertising__wrapper heroAdvertising__wrapper--mobile">
                <?php else: ?>
                <div class="heroAdvertising__wrapper heroAdvertising__wrapper--mobile">
                    <?php endif; ?>

                    <?php if ($background_image): ?>
                        <div class="heroAdvertising__bg">
                            <img src="<?php echo esc_url($background_image['url']); ?>" alt="<?php echo esc_attr($background_image['title']); ?>">
                        </div>
                    <?php endif; ?>

                    <div class="heroAdvertising__card">
                        <?php if ($title): ?>
                            <h3><?php echo esc_html($title); ?></h3>
                        <?php endif; ?>
                    </div>

                    <?php if ($logo): ?>
                        <div class="heroAdvertising__logo">
                            <img src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['title']); ?>">
                        </div>
                    <?php endif; ?>

                    <?php if ($advertising_link): ?>
                            </a>
                            <?php else: ?>
                        </div>
                    <?php endif; ?>
            <?php endif; ?>

</div>

