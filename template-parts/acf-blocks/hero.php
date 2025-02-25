<?php 
$title = get_sub_field('title');
$bg_image = get_sub_field('background_image');
?>
<?php if($title || $bg_image): ?>

<div class="hero">
    <div class="hero__wrapper container container--wide">
        <?php if($title): ?>
            <h1 class="hero__title"><?php echo $title; ?></h1>
        <?php endif; ?>
        <?php if($bg_image): ?>
            <div class="hero__image">
                <img src="<?php echo esc_url(get_custom_image($bg_image, 'custom_1650x500')); ?>" alt="<?php echo $bg_image['title']; ?>">
            </div>
        <?php endif; ?>
    </div>
</div>

<?php endif; ?>