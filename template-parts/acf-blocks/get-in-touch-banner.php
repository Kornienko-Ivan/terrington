<?php 
$title = get_field('get_in_touch_title', 'options');
$button = get_field('get_in_touch_button', 'options');
$logo = get_field('get_in_touch_logo', 'options');
$bg = get_field('get_in_touch_background_image', 'options');
?>

<?php if($title || $button || $logo || $bg): ?>

    <?php if($bg): ?>
        <style>
            .gitBanner {
                --git-bg: url('<?php echo esc_url($bg['url']); ?>');
            }
        </style>
    <?php endif; ?>


<div class="gitBanner">
    <div class="container">
        <div class="gitBanner__wrapper">
            <div class="gitBanner__row">
                <?php if($logo): ?>
                    <div class="gitBanner__logo"><img src="<?php echo $logo['url'] ?>" alt="<?php echo $logo['title'] ?>"></div>
                <?php endif; ?>
                <?php if($title): ?>
                    <h2 class="gitBanner__title"><?php echo $title; ?></h2>
                <?php endif; ?>
                <?php if($button): ?>
                    <a href="<?php echo $button['url']; ?>" class="button button--arrow">
                        <span>
                            <?php echo $button['title']; ?>
                        </span>
                        <div class="icon">
                            <?php echo get_inline_svg('arrow-btn'); ?>
                        </div>
                    </a>
                <?php endif; ?>
            </div>

        </div>
    </div>
</div>

<?php endif; ?>