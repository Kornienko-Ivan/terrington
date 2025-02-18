<?php 
$title = get_sub_field('title');
$text = get_sub_field('text');
$button = get_sub_field('button');
$image = get_sub_field('image');
$icon = get_sub_field('show_spikelet_icon');
?>
<?php if($title || $text || $image || $button): ?>
<div class="infoSection">
    <div class="container container--narrow">
        <div class="infoSection__row">
            <div class="infoSection__col infoSection__col--content">
                <?php if($title): ?>
                    <h2 class="infoSection__title"><?php echo $title; ?></h2>
                <?php endif; ?>
                <?php if($text): ?>
                    <div class="infoSection__text"><?php echo $text; ?></div>
                <?php endif; ?>
                <?php if($button): ?>
                    <div class="infoSection__button">
                        <a href="<?php echo $button['url']; ?>" class="button button--arrow">
                            <span>
                                <?php echo $button['title']; ?>
                            </span>
                            <div class="icon">
                                <?php echo get_inline_svg('arrow-btn'); ?>
                            </div>
                        </a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="infoSection__col infoSection__col--img">
                <?php if($image): ?>
                    <div class="infoSection__imageWrapper">
                        <img src="<?php echo get_custom_image($image, 'custom_500x500'); ?>" alt="<?php echo esc_attr($image['title']); ?>" class="infoSection__image">
                    </div>
                    <div class="infoSection__imageWrapper--small">
                        <img src="<?php echo get_custom_image($image, 'custom_500x500'); ?>" alt="<?php echo esc_attr($image['title']); ?>" class="infoSection__image">
                    </div>
                <?php endif; ?>
                <?php if($icon): ?>
                    <div class="infoSection__icon">
                        <?php echo get_inline_svg('label') ?>
                    </div>
                <?php endif;  ?>
            </div>
        </div>
    </div>
</div>
<?php endif; ?>