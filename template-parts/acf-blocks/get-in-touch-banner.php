<?php 
$title = get_field('get_in_touch_title', 'options');
$button = get_field('get_in_touch_button', 'options');
$logo = get_field('get_in_touch_logo', 'options');
$bg = get_field('get_in_touch_background_image', 'options');
?>
<?php if($title || $button || $logo || $bg): ?>
    <?php if($logo): ?>
        <div class="gitBanner__logo"><img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['title'] ?>"></div>
    <?php endif; ?>
    <?php if($title): ?>
        <h2 class="gitBanner__title"><?php echo $title; ?></h2>
    <?php endif; ?>
    <?php if($button): ?>
        <div class="gitBanner__button"><a href="<?php echo $button['url']; ?>" class="button button--arrow"><?php echo $button['title']; ?></a></div>
    <?php endif; ?>
    <?php if($bg): ?>
        <div class="gitBanner__bg"><img src="<?php echo $bg['url']; ?>" alt="<?php echo $bg['title']; ?>"></div>
    <?php endif; ?>
<?php endif; ?>