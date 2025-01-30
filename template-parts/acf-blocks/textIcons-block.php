<?php 
$heading = get_sub_field('heading');
$text = get_sub_field('text');
$button = get_sub_field('button');
$logos = get_sub_field('icon_blocks');
?>
<section class="section textIcons">
    <div class="container">
        <div class="row row--y--middle textIcons__row">
            <div class="col-12 col-lg-4 col-md-5 textIcons__col textIcons__content">
                <?php if($heading): ?>
                    <h2 class="text--color--secondary font--weight--medium text--size--28 textIcons__content__heading appear fade-up"><?php echo $heading; ?></h2>
                <?php endif; ?>
                <?php if($text): ?>
                    <div class="content-block text--color--secondary--txt pt-30 textIcons__content__text appear fade-up" appear fade-up><?php echo $text; ?></div>
                <?php endif; ?>
                <?php if($button): ?>
                        <?php
                        $link_url = $button['url'];
                        $link_title = $button['title'];
                        $link_target = $button['target'] ? $button['target'] : '_self';
                        ?>
                        <a class="button mt-40 appear fade-up" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                <?php endif; ?>
            </div>
            <div class="col-12 col-lg-8 col-md-7 textIcons__col textIcons__icons">
                <div class="row">
                    <?php if($logos): ?>
                        <?php foreach($logos as $item): ?>
                            <?php 
                            $image = $item['icon'];
                            $heading = $item['heading'];
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
                                    <?php if($heading): ?>
                                        <h3 class="text--center text--color--purple iconBlock__heading"><?php echo $heading; ?></h3>
                                    <?php endif; ?>
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