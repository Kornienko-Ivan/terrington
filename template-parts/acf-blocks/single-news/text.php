<?php 
$text = get_sub_field('text');
if($text):
?>
<section class="singleText">
    <div class="container container--narrow">
        <div class="singleText__content"><?php echo $text; ?></div>
    </div>
</section>
<?php endif; ?>