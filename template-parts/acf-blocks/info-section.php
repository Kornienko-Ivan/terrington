<?php 
$title = get_sub_field('title');
$text = get_sub_field('text');
$button = get_sub_field('button');
$image = get_sub_field('image');
$icon = get_sub_field('show_spikelet_icon');
?>
<?php if($title || $text || $image || $button): ?>
    <?php if($title): ?>
        <h2 class="infoSection__title"><?php echo $title; ?></h2>
    <?php endif; ?>
    <?php if($text): ?>
        <div class="infoSection__text"><?php echo $text; ?></div>
    <?php endif; ?>
    <?php if($button): ?>
        <div class="infoSection__button"><a href="<?php echo $button['url']; ?>" class="button button--arrow"><?php echo $button['title']; ?></a></div>
    <?php endif; ?>
    <?php if($image): ?>
        <div class="infoSection__imageWrapper"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>" class="infoSection__image"><?php if($icon): ?><div class="infoSection__icon"></div><?php endif;  ?></div>
    <?php endif; ?>
<?php endif; ?>