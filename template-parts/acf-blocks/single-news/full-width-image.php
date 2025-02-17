<?php 
$image = get_sub_field('full_width_image');
if($image):
?>

<section class="hero singleFullImage">
    <div class="hero__wrapper container container--wide">
        <?php if($image): ?>
            <div class="hero__image"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>"></div>
        <?php endif; ?>
    </div>
</section>
<?php endif; ?>