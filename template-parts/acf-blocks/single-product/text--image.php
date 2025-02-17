<?php 
if(have_rows('text__image_list')):
?>
<section class="productTextImage">
    <div class="container">
        <div class="productTextImage__content">
            <?php while(have_rows('text__image_list')): the_row(); 
                $image_width = get_sub_field('image_width');
                $title = get_sub_field('title');
                $text = get_sub_field('text');
                $image = get_sub_field('image');
                if($image || $title || $text):
                ?>
                <div class="productTextImage__block">
                    <?php if($image): ?>
                        <div class="productTextImage__image image-<?php echo $image_width; ?>"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>"></div>
                    <?php endif; ?>
                    <?php if($title || $text): ?>
                        <div class="productTextImage__textWrapper">
                            <?php if($title): ?>
                                <h4 class="productTextImage__title"><?php echo $title; ?></h4>
                            <?php endif; ?>
                            <?php if($text): ?>
                                <div class="productTextImage__text"><?php echo $text; ?></div>
                            <?php endif; ?>
                        </div>
                    <?php endif; ?>
                </div>
                <?php endif; ?>
            <?php endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>