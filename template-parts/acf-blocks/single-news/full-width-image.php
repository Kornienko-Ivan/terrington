<?php 
$image = get_sub_field('full_width_image');
if($image):
?>
<section class="singleFullImage">
    <div class="container">
        <div class="singleFullImage__picture"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>"></div>
    </div>
</section>
<?php endif; ?>