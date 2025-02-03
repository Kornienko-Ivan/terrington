<?php 
$title = get_sub_field('title');
$bg_image = get_sub_field('background_image');
?>
<?php if($title): ?>
    <h1 class="hero__title"><?php echo $title; ?></h1>
<?php endif; ?>
<?php if($bg_image): ?>
    <div class="hero__image"><img src="<?php echo $bg_image['url']; ?>" alt="<?php echo $bg_image['title']; ?>"></div>
<?php endif; ?>