<?php 
$title = get_sub_field('title');
$image = get_sub_field('image');
$text = get_sub_field('text');
$button = get_sub_field('button');
if($title || $text || $image || $button):
?>
    <section class="machineryButton">
        <div class="container">
            <div class="machineryButton__contentWrapper">
                <?php if($image): ?>
                    <div class="machineryButton__image"><img src="<?php echo $image['url']; ?>" alt="<?php echo $image['title']; ?>"></div>
                <?php endif; ?>
                <?php if($title || $text || $button): ?>
                    <div class="machineryButton__content">
                        <?php if($title): ?>
                            <div class="machineryButton__title"><?php echo $title; ?></div>
                        <?php endif; ?>
                        <?php if($text): ?>
                            <div class="machineryButton__text"><?php echo $text; ?></div>
                        <?php endif; ?>
                        <?php if($button): ?>
                            <div class="machineryButton__btn"><a href="<?php echo $button['url']; ?>" class="button"><?php echo $button['title']; ?></a></div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section>
<?php endif; ?>