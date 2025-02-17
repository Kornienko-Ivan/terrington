<?php 
if(have_rows('images_slider')):
?>
<section class="productImageSlider">
    <div class="container">
        <div class="productImageSlider__list">
            <?php while(have_rows('images_slider')): the_row(); 
                $image = get_sub_field('image');
                if($image):
            ?>
                <div class="productImageSlider__listItem"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>"></div>
            <?php endif; endwhile; ?>
        </div>
    </div>
</section>
<?php endif; ?>