<?php 
$title = get_sub_field('title');
$background_image = get_sub_field('background_image');
$logo = get_sub_field('logo');
?>
<?php if($title || $logo || $background_image): ?>
    <div class="heroAdvertising__wrapper">
        <?php if($background_image): ?>
            <div class="heroAdvertising__bg"><img src="<?php echo $background_image['url']; ?>" alt="<?php echo $background_image['title']; ?>"></div>
        <?php endif; ?>
        <?php if($title): ?>
            <div class="heroAdvertising__title"><?php echo $title; ?></div>
        <?php endif; ?>
        <?php if($logo): ?>
            <div class="heroAdvertising__logo"><img src="<?php echo $logo['url']; ?>" alt="<?php echo $logo['title']; ?>"></div>
        <?php endif; ?>
    </div>
<?php endif; ?>