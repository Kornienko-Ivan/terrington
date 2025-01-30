<?php 
$imagePosition = get_sub_field('image_position');
$imageOutside = get_sub_field('image_outside_wrapper');
$imageWidth = get_sub_field('image_width');
$verticalAlign = get_sub_field('vertical_align');
?>
<section class="section contentImageBlock <?php echo $imagePosition =='left'?'contentImageBlock__imageLeft':'';?>">
    <div class="container">
        <div class="row row--y--<?php echo $verticalAlign; ?>">
            <div class="col-12 col-lg-<?php echo 12-$imageWidth; ?> col-md-<?php echo 12-$imageWidth; ?>  contentImageBlock__content">
                <?php 
                $heading = get_sub_field('heading');
                $subheading = get_sub_field('subheading');
                $text = get_sub_field('text');
                $button = get_sub_field('button');
                ?>
                    <div class="contentImageBlock__content__inner">
                        <?php if($subheading): ?>
                            <h3 class="text--style--2 contentImageBlock__content__subheading appear fade-up"><?php echo $subheading; ?></h3>
                        <?php endif; ?>
                        <?php if($heading): ?>
                            <h2 class="text--color--secondary font--weight--medium text--size--28 contentImageBlock__content__heading appear fade-up"><?php echo $heading; ?></h2>
                        <?php endif; ?>
                        <?php if($text): ?>
                            <div class="content-block text--color--secondary--txt pt-30 contentImageBlock__content__text appear fade-up" appear fade-up><?php echo $text; ?></div>
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
            </div>
            <div class="col-12 col-md-<?php echo $imageWidth; ?> contentImageBlock__image <?php if($imageOutside) echo 'contentImageBlock__image--outside';?>">
                <?php 
                $image = get_sub_field('image');
                if( $image ): ?>
                    <div class="contentImageBlock__image__inner appear fade-up">
                        <img class="lazy-img" data-src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                    </div>    
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>