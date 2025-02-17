<?php if(have_rows('images_grid')): ?>
    <section class="singleImagesGrid">
        <div class="container container--narrow">
            <div class="singleImagesGrid__list">
                <?php while(have_rows('images_grid')): the_row(); 
                    $image = get_sub_field('image');
                    $width = get_sub_field('width');
                    if($image):
                    ?>
                        <div class="singleImagesGrid__listItem width-<?php echo $width; ?>"><img src="<?php echo $image['url'] ?>" alt="<?php echo $image['title'] ?>"></div>
                    <?php endif; ?>
                <?php endwhile; ?>
            </div>
        </div>
    </section>
<?php endif; ?>