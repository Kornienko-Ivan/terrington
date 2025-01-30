<section class="section featuredCase">
    <div class="container">
        <div class="text--color--white featuredCase__inner appear fade-up">
            <div class="row row--y--middle featuredCase__row">
                <div class="col-12 col-lg-6 col-md-6 featuredCase__col featuredCase__col--icons featuredCase__iconBlocks">
                        <?php 
                        $iconBlocks = get_sub_field('icon_blocks');
                        ?>
                        <?php if($iconBlocks): ?>
                            <?php foreach($iconBlocks as $item): ?>
                                <?php 
                                $image = $item['icon'];
                                $heading = $item['heading'];
                                $subheading = $item['subheading'];
                                ?>
                                <div class="featuredCase__iconBlocks__item">
                                    <div class="featuredCase__iconBlocks__item__icon">
                                        <?php if($image): ?>
                                            <img class="lazy-img" data-src="<?php echo esc_url($image['url']); ?>" alt="<?php echo esc_attr($image['alt']); ?>" />
                                        <?php endif;?>
                                    </div>
                                    <div class="featuredCase__iconBlocks__item__content">
                                        <?php if($heading): ?>
                                            <h3 class="font--weight--regular text--size--78 appear fade-in"><?php echo $heading; ?></h3>
                                        <?php endif; ?>
                                        <?php if($subheading): ?>
                                            <h3 class="font--weight--regular text--size--17 appear fade-in"><?php echo $subheading; ?></h3>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                </div>
                <div class="col-12 col-lg-6 col-md-6 featuredCase__col featuredCase__col--content featuredCase__content">
                    <?php 
                    $heading = get_sub_field('heading');
                    $text = get_sub_field('text');
                    $button = get_sub_field('button');
                    $logo = get_sub_field('logo');
                    ?>
                    <?php if($heading): ?>
                        <h2 class="font--weight--medium text--size--28"><?php echo $heading; ?></h2>
                    <?php endif; ?>
                    <?php if($logo): ?>
                            <img class="lazy-img pt-50" data-src="<?php echo esc_url($logo['url']); ?>" alt="<?php echo esc_attr($logo['alt']); ?>" />
                    <?php endif;?>
                    <?php if($text): ?>
                        <div class="content-block pt-50" appear fade-up><?php echo $text; ?></div>
                    <?php endif; ?>
                    <?php if($button): ?>
                        <?php
                        $link_url = $button['url'];
                        $link_title = $button['title'];
                        $link_target = $button['target'] ? $button['target'] : '_self';
                        ?>
                        <a class="button button--lg mt-60" href="<?php echo esc_url( $link_url ); ?>" target="<?php echo esc_attr( $link_target ); ?>"><?php echo esc_html( $link_title ); ?></a>
                    <?php endif; ?>

                </div>
            </div>
        </div>
    </div>
</section>