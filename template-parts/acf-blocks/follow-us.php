<?php 
$title = get_sub_field('title');
$icon = get_sub_field('icon');
$feed_shortcode = get_sub_field('feed_shortcode');
?>
<?php if($icon || $title): ?>
    <div class="followUs__titleWrapper">
        <?php if($title): ?>
            <h2 class="followUs__title"><?php echo $title; ?></h2>
        <?php endif; ?>
        <?php if($icon): ?>
            <img src="<?php echo $icon['url']; ?>" alt="<?php echo $icon['title']; ?>" class="followUs__icon">
        <?php endif; ?>
    </div>
<?php endif; ?>
<?php if($feed_shortcode): ?>
    <div class="followUs__feed">
        <?php echo do_shortcode( $feed_shortcode ); ?>
    </div>
<?php endif; ?>