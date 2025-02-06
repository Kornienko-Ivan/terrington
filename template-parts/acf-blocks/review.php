<?php 
$image = get_sub_field('image');
$title = get_sub_field('title');
$text = get_sub_field('text');
$button = get_sub_field('button');
?>
<?php if($image): ?>
    <div class="review__image"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>"></div>
<?php endif; ?>
<?php if($title || $text || $button): ?>
    <div class="review__content">
        <?php if($title): ?>
            <h2 class="review__title"><?php echo $title; ?></h2>
        <?php endif; ?>
        <?php if($text): ?>
            <div class="review__text"><?php echo $text; ?></div>
        <?php endif; ?>
        <?php if($button): ?>
            <div class="review__button"><a href="<?php echo $button['url']; ?>" class="button"><?php echo $button['title']; ?></a></div>
        <?php endif; ?>
    </div>
<?php endif; ?>