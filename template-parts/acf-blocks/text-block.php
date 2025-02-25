<?php 
$title = get_sub_field('title');
$text = get_sub_field('text');
if($title || $text):
?>
<section class="textBlock content-block">
    <div class="container container--narrow">
        <div class="textBlock__content">
            <?php if($title): ?>
                <h2 class="textBlock__title"><?php echo $title; ?></h2>
            <?php endif; ?>
            <?php if($text): ?>
                <div class="textBlock__text"><?php echo $text; ?></div>
            <?php endif; ?>
        </div>
    </div>
</section>
<?php endif; ?>