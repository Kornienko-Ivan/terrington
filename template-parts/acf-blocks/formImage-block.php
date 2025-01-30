<?php 
?>
<section class="section--spacing--lg formImage">
    <div class="container">
        <div class="row row--y--middle">
            <div class="col-12 col-lg-4 col-md-5  formImage__content">
                <?php 
                $heading = get_sub_field('heading');
                $text = get_sub_field('text');
                $form = get_sub_field('form');
                ?>
                    <div class="formImage__content__inner">
                        <?php if($subheading): ?>
                            <h3 class="text--style--2 formImage__content__subheading appear fade-up"><?php echo $subheading; ?></h3>
                        <?php endif; ?>
                        <?php if($heading): ?>
                            <h2 class="text--color--secondary font--weight--medium text--size--28 formImage__content__heading appear fade-up"><?php echo $heading; ?></h2>
                        <?php endif; ?>
                        <?php if($text): ?>
                            <div class="content-block text--color--secondary--txt pt-20 formImage__content__text appear fade-up" appear fade-up><?php echo $text; ?></div>
                        <?php endif; ?>
                        <?php if($form): ?>
                            <div class="form form--contact pt-20 appear fade-up">
                                <?php echo do_shortcode($form); ?>
                            </div>        
                        <?php endif; ?>
                    </div>
            </div>
            <div class="col-12 col-lg-7 offset-lg-1 col-md-7 formImage__image">
                <?php 
                $image = get_sub_field('image');
                if( $image ): ?>
                    <div class="formImage__image__inner appear fade-up">
                        <img class="formImage__image__img lazy-img" data-src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" />
                    </div>    
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>