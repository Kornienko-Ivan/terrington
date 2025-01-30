<?php 
$heading = get_sub_field('heading');
$text = get_sub_field('text');
$logos = get_sub_field('logos');
?>
<section class="section textLogos">
    <div class="container">
        <div class="row row--y--middle">
            <div class="col-12 col-lg-3 col-md-5">
                <?php if($heading): ?>
                    <h2 class="text--color--secondary font--weight--medium text--size--28 contentImageBlock__content__heading appear fade-up"><?php echo $heading; ?></h2>
                <?php endif; ?>
                <?php if($text): ?>
                    <div class="content-block text--color--secondary--txt pt-30 contentImageBlock__content__text appear fade-up" appear fade-up><?php echo $text; ?></div>
                <?php endif; ?>
            </div>
            <div class="col-12 col-lg-8 offset-lg-1 col-md-7 textLogos__col--logos">
                <div class="row">
                    <?php if($logos): ?>
                        <?php foreach($logos as $item): ?>
                            <?php 
                            $image = $item['image'];
                            $link = $item['link'];
                            ?>
                            <div class="col-6 col-lg-4 iconBlock__wrapper appear fade-in d-1">
                                <?php if($link): ?>
                                    <?php
                                    $link_url = $link['url'];
                                    $link_title = $link['title'];
                                    $link_target = $link['target'] ? $link['target'] : '_self';
                                    ?>
                                    <a class="iconBlock" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>">
                                <?php else: ?>
                                    <div class="iconBlock">
                                <?php endif; ?>
                                    <div class="iconBlock__icon">
                                        <?php if($image): ?>
                                            <img class="lazy-img" data-src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                                        <?php endif;?>
                                    </div>
                                <?php if($link):?>
                                    </a>
                                <?php else: ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>